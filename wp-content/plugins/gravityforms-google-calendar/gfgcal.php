<?php
/*
Plugin Name: Gravity Forms Connect to Google Calendar™
Plugin URI: http://codecanyon.net/item/gravity-forms-connect-to-google-calendar/3598271
Description: Integrates Gravity Forms with Google Calendar™ and allows you to approve submitted events and push them to your Google Calendar.
Author: Allan Schmidt
Version: 1.2.4
Author URI:
*/

if (!defined('GFGCAL_PLUGIN_ROOT')) {
	define('GFGCAL_PLUGIN_SCRIPT', __FILE__);
	define('GFGCAL_PLUGIN_ROOT', dirname(__FILE__) . '/');
	define('GFGCAL_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
	define('GFGCAL_PLUGIN_SLUG', 'gravityforms-google-calendar/gfgcal.php');

	// script/style version
	if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)
		define('GFGCAL_VERSION', time());
	else
		define('GFGCAL_VERSION', '1.2.4');

	// URL for querying latest version information for plugin
	define('GFGCAL_PLUGIN_LATEST', 'http://ctrl-anykey.dk/gravityforms-google-calendar-latest.xml');
}

class GFGCal {

	static $client = null;

	static $registered_fields = array(
		'gc_title' => 'Фамилия',
        'gc_model' => 'Модель ТС',
        'gc_brand' => 'Марка ТС',
        'gc_firstname' => 'Имя',
        'gc_tel' => 'Телефон',
		'gc_date_start' => 'Start Date',
		'gc_date_end' => 'End Date',
		'gc_time_start' => 'Start Time',
		'gc_time_end' => 'End Time',
		'gc_location' => 'Место',
		'gc_allday' => 'All Day',
		'gc_desc' => 'Описание'
	);

	private static $field = null;

	public static function init() {
		load_plugin_textdomain('gfgcal', false, dirname(plugin_basename(__FILE__)) . '/lang/');

		// check for plugin updates
		add_filter('pre_set_site_transient_update_plugins', array(__CLASS__, 'checkPluginUpdates'));
		add_filter('plugins_api', array(__CLASS__, 'checkPluginInfo'), 10, 3);

		if (! class_exists('RGForms')) {
			add_action('admin_notices', array(__CLASS__, 'gravityforms_missing_notice'));
			return;
		}

		GFGCalSettingsPage::init();

		self::$client = new GFGCalClient();

		if (! GFGCalClient::get_access_token()) {
			add_action('admin_notices', array('GFGCalClient', 'api_key_notice'));

			return;
		}

		add_filter('gform_add_field_buttons', array(__CLASS__, 'add_field_buttons'));
		add_filter('gform_field_type_title', array(__CLASS__, 'add_field_type_title'));
		add_filter('gform_field_input', array(__CLASS__, 'field_input'), 1, 5);
		add_filter('gform_tooltips', array(__CLASS__, 'tooltips'));
		add_action('gform_editor_js_set_default_values', array(__CLASS__, 'js_set_default_values'));
		add_filter('admin_footer', array(__CLASS__, 'admin_enqueue_scripts'));
		add_filter('gform_noconflict_scripts', array(__CLASS__, 'gform_noconflict_scripts'));
		add_action('admin_print_styles', array(__CLASS__, 'admin_styles'));
		add_action('gform_field_standard_settings', array(__CLASS__, 'field_standard_settings'), 10, 2);
		add_action('gform_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'), 10, 2);
		add_filter('gform_entries_field_value', array(__CLASS__, 'entries_field_value'), 10, 4);
		add_filter('gform_allowable_tags', array(__CLASS__, 'prevent_array_error_on_save_field'), 10, 3);
		add_filter('gform_save_field_value', array(__CLASS__, 'save_field_value'), 10, 4);
		add_filter('gform_field_validation', array(__CLASS__, 'field_validation'), 10, 4);
		add_filter('gform_validation', array(__CLASS__, 'entry_validation'));
		add_filter('gform_entry_field_value', array(__CLASS__, 'entry_field_value'), 10, 4);
		add_filter('gform_get_field_value', array(__CLASS__, 'get_field_value'), 10, 3);
		add_filter('gform_pre_submission_filter', array(__CLASS__, 'pre_submission_filter'));
		add_action('gform_entry_post_save', array(__CLASS__, 'entry_post_save'), 10, 2);
		add_action('gform_after_submission', array(__CLASS__, 'after_submission'), 10, 2);
		add_action('gform_entries_first_column_actions', array(__CLASS__, 'entries_first_column_actions'), 10, 5);
		add_action('admin_print_scripts', array(__CLASS__, 'gf_entries_scripts'));

		add_action('wp_ajax_gf_gc_approve', array(__CLASS__, 'ajax_approve'));

		add_action('gform_entry_info', array(__CLASS__, 'entry_info'), 10, 2);
		add_filter('gform_entry_apply_button', array(__CLASS__, 'entry_apply_button'));

		add_filter('gform_replace_merge_tags', array(__CLASS__, 'replace_merge_tags'), 10, 3);
		add_filter('gform_custom_merge_tags', array(__CLASS__, 'custom_merge_tags'));

		add_filter('gform_field_css_class', array(__CLASS__, 'field_css_class'), 10, 3);

		// handle changes in settings pages
		if (version_compare(GFCommon::$version, '1.7.0', '<')) {
			add_action('gform_properties_settings', array(__CLASS__, 'properties_settings'), 10, 2);
		}
		else {
			add_action('gform_form_settings', array(__CLASS__, 'form_settings'), 10, 2);
		}

		/*
		 * Ugly hack to remove field duplicate link because of not so
		 * well used apply_filters for $duplicate_field_link
		 */
		add_filter('gform_field_content', array(__CLASS__, 'remove_duplicate_field_hack'), 10, 2);
	}

	public static function add_field_buttons($field_groups) {
		$field_groups[] = array(
			'name' => 'google_calendar_fields',
			'label' => __('Google Calendar', 'gfgc'),
			'fields' => array(
				array(
					'class' => 'button',
					'id' => 'gc_title',
					'value' => GFCommon::get_field_type_title('gc_title'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_firstname',
					'value' => GFCommon::get_field_type_title('gc_firstname'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_tel',
					'value' => GFCommon::get_field_type_title('gc_tel'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_model',
					'value' => GFCommon::get_field_type_title('gc_model'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_brand',
					'value' => GFCommon::get_field_type_title('gc_brand'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_date_start',
					'value' => GFCommon::get_field_type_title('gc_date_start'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_date_end',
					'value' => GFCommon::get_field_type_title('gc_date_end'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_time_start',
					'value' => GFCommon::get_field_type_title('gc_time_start'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_time_end',
					'value' => GFCommon::get_field_type_title('gc_time_end'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_location',
					'value' => GFCommon::get_field_type_title('gc_location'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_allday',
					'value' => GFCommon::get_field_type_title('gc_allday'),
				),
				array(
					'class' => 'button',
					'id' => 'gc_desc',
					'value' => GFCommon::get_field_type_title('gc_desc'),
				)
			)
		);

		return $field_groups;
	}

	public static function add_field_type_title($type) {
		if (! in_array($type, array_keys(self::$registered_fields)))
			return $type;

		return __(self::$registered_fields[$type], 'gfgcal');
	}

	public static function field_input($input, $field, $value, $lead_id, $form_id) {
		if (! in_array($field['type'], array_keys(self::$registered_fields)))
			return;

		switch ($field['type']) {
			case 'gc_title':
				return self::text_field_input($field, $value, $lead_id, $form_id);
			case 'gc_firstname':
				return self::text_field_input($field, $value, $lead_id, $form_id);
			case 'gc_tel':
				return self::text_field_input($field, $value, $lead_id, $form_id);
			case 'gc_brand':
				return self::text_field_input($field, $value, $lead_id, $form_id);
			case 'gc_model':
				return self::text_field_input($field, $value, $lead_id, $form_id);
			case 'gc_date_start':
			case 'gc_date_end':
				return self::date_field_input($field, $value, $lead_id, $form_id);
			case 'gc_time_start':
			case 'gc_time_end':
				return self::time_field_input($field, $value, $lead_id, $form_id);
			case 'gc_location':
				return self::text_field_input($field, $value, $lead_id, $form_id);
			case 'gc_allday':
				return self::checkbox_field_input($field, $value, $lead_id, $form_id);
			case 'gc_desc':
				return self::textarea_field_input($field, $value, $lead_id, $form_id);
			default:
				return $input;
		}

		return $input;
	}

	private static function text_field_input($field, $value, $lead_id, $form_id) {
		$field['type'] = 'text';

		return GFCommon::get_field_input($field, $value, $lead_id, $form_id);
	}

	private static function date_field_input($field, $value, $lead_id, $form_id) {
		$field['type'] = 'date';

		return GFCommon::get_field_input($field, $value, $lead_id, $form_id);
	}

	private static function time_field_input($field, $value, $lead_id, $form_id) {
		$field['type'] = 'time';

		return GFCommon::get_field_input($field, $value, $lead_id, $form_id);
	}

	private static function checkbox_field_input($field, $value, $lead_id, $form_id) {
		$field['type'] = 'checkbox';

		return GFCommon::get_field_input($field, $value, $lead_id, $form_id);
	}

	private static function textarea_field_input($field, $value, $lead_id, $form_id) {
		$field['type'] = 'textarea';

		return GFCommon::get_field_input($field, $value, $lead_id, $form_id);
	}

	public static function tooltips($tooltips) {
		$tooltips['form_google_calendar_fields'] 	= __('<h6>Google Calendar</h6> Google Calendar fields allow you to add fields to your form that enable creation of Google Calendar Events.', 'gfgcal');
		$tooltips['form_field_google_calendar'] 	= __('<h6>Google Calendar</h6> Select a calendar from the list', 'gfgcal');
		$tooltips['form_events_require_approval'] 	= __('<h6>Google Calendar Events Require Approval</h6> Check this if you want to manually approve submitted events.', 'gfgcal');

		$tooltips['form_freebusy_check']			= __('<h6>Check Free/Busy</h6> Check if there are any overlapping events on submission and return a validation error if so.', 'gfgcal');

		return $tooltips;
	}

	public static function entries_field_value($value, $form_id, $field_id, $lead) {
		$form = RGFormsModel::get_form_meta($form_id);
		$field = RGFormsModel::get_field($form, $field_id);

		if (! in_array($field['type'], array_keys(self::$registered_fields)))
			return $value;

		switch ($field['type']) {
			case 'gc_date_start':
			case 'gc_date_end':
				return GFCommon::date_display($value, $field["dateFormat"]);
		}

		return $value;
	}

	/**
	* prevent strip_tags errors on our custom fields with array values
	* @param bool $allow_html
	* @param array $field
	* @param int $form_id
	* @return bool
	*/
	public static function prevent_array_error_on_save_field($allow_html, $field, $form_id) {
		if ($field['type'] == 'gc_time_start' || $field['type'] == 'gc_time_end') {
			$allow_html = true;
		}

		return $allow_html;
	}

	public static function save_field_value($value, $lead, $field, $form) {
		if (! in_array($field['type'], array_keys(self::$registered_fields)))
			return $value;

		$nfield = $field;
		switch ($field['type']) {
			case 'gc_date_start':
			case 'gc_date_end':
				$nfield['type'] = 'date';
				break;
			case 'gc_time_start':
			case 'gc_time_end':
				$nfield['type'] = 'time';
				break;
			case 'gc_allday':
				$nfield['type'] = 'checkbox';
				break;
            case 'gc_desc':
                if (rgar($form, "gcDescTemplateEnabled")) {
                    foreach ($form['fields'] as $f) {
                        $fv = RGFormsModel::get_field_value($f);
                        $lead[$f['id']] = RGFormsModel::prepare_value($form, $f, $fv, '', $lead['id']);
                    }

                    $value = GFCommon::replace_variables($form["gcDescTemplate"], $form, $lead);
                }
                break;
        }

		return RGFormsModel::prepare_value($form, $nfield, $value, '', $lead['id'], $lead);
	}

	/**
	* attempt to parse a calendar date
	* @param string $value
	* @param string $format
	* @return string
	*/
	protected static function parse_date($value, $format) {
		switch ($format) {
			case 'mdy' :
				$parseFormat = '%m/%d/%Y';
				break;
			case 'dmy' :
				$parseFormat = '%d/%m/%Y';
				break;
			case 'dmy_dash' :
				$parseFormat = '%d-%m-%Y';
				break;
			case 'dmy_dot' :
				$parseFormat = '%d.%m.%Y';
				break;
			case 'ymd_slash' :
				$parseFormat = '%Y/%m/%d';
				break;
			case 'ymd_dash' :
				$parseFormat = '%Y-%m-%d';
				break;
			case 'ymd_dot' :
				$parseFormat = '%Y.%m.%d';
				break;
			default:
				// default to mdy since that's the top selection in the form editor
				$parseFormat = '%m/%d/%Y';
				break;
		}

		$tm = strptime($value, $parseFormat);
		$date = $tm ? sprintf('%04d-%02d-%02d', $tm['tm_year'] + 1900, $tm['tm_mon'] + 1, $tm['tm_mday']) : '';

		return $date;
	}

	/**
	* validate custom fields in entry
	* @param mixed $validation
	* @param string $value
	* @param array $form
	* @param array $field
	* @return mixed
	*/
	public static function field_validation($validation, $value, $form, $field) {
		switch ($field['type']) {
			case 'gc_date_start':
			case 'gc_date_end':
				$date = self::parse_date($value, $field['dateFormat']);
				if ($date === '' && $value !== '') {
					$validation = array(
						'is_valid' => false,
						'message' => __('Please enter a valid date.', 'gravityforms'),
					);
				}
				break;

			case 'gc_time_start':
			case 'gc_time_end':
				$hour = $value[0];
				$minute = $value[1];

				if (empty($hour) && empty($minute))
					break;

				$is_valid_format = is_numeric($hour) && is_numeric($minute);

				$min_hour = rgar($field, 'timeFormat') == '24' ? 0 : 1;
				$max_hour = rgar($field, 'timeFormat') == '24' ? 23 : 12;

				if (!$is_valid_format || $hour < $min_hour || $hour > $max_hour || $minute < 0 || $minute >= 60) {
					$validation = array(
						'is_valid' => false,
						'message' => __('Please enter a valid time.', 'gravityforms'),
					);
				}
				break;
		}

		return $validation;
	}

	/**
	* validate the calendar entry to fail if busy and freeBusyCheck is selected
	* @param array $data an array with elements is_valid (boolean) and form (array of form elements)
	* @return array
	*/
	public static function entry_validation($data) {
		// make sure all other validations passed
		if (!$data['is_valid'])
			return $data;

		$form = &$data['form'];
		$start_date_field = null;

		// only check busy if form configured for checking
		if (!rgar($form, 'freeBusyCheck'))
			return $data;

		$calendar_id = $form['googleCalendar'];

		$start_time = $end_time = '00:00:00';

		foreach ($form['fields'] as &$f) {
			$fvalue = RGFormsModel::get_field_value($f);

			if (empty($fvalue))
				continue;

			switch ($f['type']) {
				case 'gc_date_start':
					$start_date = self::parse_date($fvalue, $f['dateFormat']);
					$start_date_field = &$f;
					break;

				case 'gc_date_end':
					$end_date = self::parse_date($fvalue, $f['dateFormat']);
					break;

				case 'gc_time_start':
					$nf = $f;
					$nf['type'] = 'time';
					$start_time = RGFormsModel::prepare_value($form, $nf, $fvalue, '', -1);
					break;

				case 'gc_time_end':
					$nf = $f;
					$nf['type'] = 'time';
					$end_time = RGFormsModel::prepare_value($form, $nf, $fvalue, '', -1);
					break;

				case 'gc_all_day':
					$all_day = true;
					$end_time = '23:59:59';
					break;
			}
		}

		if ((isset($all_day) && $all_day) || ! isset($end_date)) {
			$end_date = $start_date;
		}

		$tz_string = GFGCal::$client->get_calendar_timezone($calendar_id);

		$timemin = strftime('%FT%X.000%z', strtotime("$start_date $start_time $tz_string"));
		$timemax = strftime('%FT%X.000%z', strtotime("$end_date $end_time $tz_string"));

		$busy = self::$client->is_busy($calendar_id, $timemin, $timemax);

		if ($busy) {
			$data['is_valid'] = false;
			$start_date_field['failed_validation'] = true;
			$start_date_field['validation_message'] = __('The time interval you have selected is already taken.', 'gfgcal');
		}

		return $data;
	}

	/**
	* prevent Gravity Forms from removing our admin scripts when in No Conflict mode
	* @param array $required_objects
	* @return $required_objects
	*/
	public static function gform_noconflict_scripts($required_objects) {
		$required_objects[] = 'gfgcal-admin';

		return $required_objects;
	}

	/**
	* enqueue and localise admin scripts
	*/
	public static function admin_enqueue_scripts() {
		// ensure that we're on a form, not on the form list
		$screen = get_current_screen();
		if ($screen->id != 'toplevel_page_gf_edit_forms')
			return;

		// enqueue script, unminified if SCRIPT_DEBUG is set
		$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script('gfgcal-admin', plugins_url("js/editor$min.js", __FILE__), false, GFGCAL_VERSION, true);

		// localise messages
		$msgs = apply_filters('gfgcal_js_messages', array(
			'mandatory_fields' => __('Missing Start Date/Title Google Calendar fields. These two are mandatory for event submission to work correctly.', 'gfgcal'),
			'mandatory_time_fields' => __("You can't use only one time field, you need to add both start and end time fields for enabling submission of exact time periods to your calendar.", 'gfgcal'),
			'calendar_not_selected' => __('To be able to add these fields you must first select a Google Calendar from Form Settings.'),
		));

		wp_localize_script('gfgcal-admin', 'gfgcal', array(
			'gf_version' => GFCommon::$version,
			'gf_pre17' => (version_compare(GFCommon::$version, '1.7.0', '<') ? 'true' : 'false'),
			'msg' => $msgs,
		));
	}

	public static function js_set_default_values() {
	?>
        case 'gc_title':
        if (! field.label)
        field.label = '<?php _e('Фамилия', 'gfgcal'); ?>';

        field.isRequired = true;
        field.inputs = null;
        break;
        case 'gc_brand':
        if (! field.label)
        field.label = '<?php _e('Марка ТС', 'gfgcal'); ?>';

        field.isRequired = true;
        field.inputs = null;
        break;
        case 'gc_model':
        if (! field.label)
        field.label = '<?php _e('Модель ТС', 'gfgcal'); ?>';

        field.isRequired = true;
        field.inputs = null;
        break;
        case 'gc_firstname':
        if (! field.label)
        field.label = '<?php _e('Имя', 'gfgcal'); ?>';

        field.isRequired = true;
        field.inputs = null;
        break;

        case 'gc_tel':
        if (! field.label)
        field.label = '<?php _e('Телефон', 'gfgcal'); ?>';

        field.isRequired = true;
        field.inputs = null;
        break;

        case 'gc_date_start':
        if (! field.label)
        field.label = '<?php _e('Start Date', 'gfgcal'); ?>';

        field.dateType = 'datepicker';
        field.isRequired = true;
        field.inputs = null;
        break;
        case 'gc_date_end':
        if (! field.label)
        field.label = '<?php _e('End Date', 'gfgcal'); ?>';

        field.dateType = 'datepicker';
        field.inputs = null;
        break;
        case 'gc_time_start':
        if (! field.label)
        field.label = '<?php _e('Start Time', 'gfgcal'); ?>';

        field.inputs = null;
        break;
        case 'gc_time_end':
        if (! field.label)
        field.label = '<?php _e('End Time', 'gfgcal'); ?>';

        field.inputs = null;
        break;
        case 'gc_location':
        if (! field.label)
        field.label = '<?php _e('Место', 'gfgcal'); ?>';

        field.inputs = null;
        break;
        case 'gc_allday':
        field.label = '';

        if(!field.choices)
        field.choices = new Array(new Choice("<?php _e('All Day Event', 'gfgcal'); ?>", 'allday'));

        field.inputs = new Array();
        for(var i=1; i<=field.choices.length; i++) {
        field.inputs.push(new Input(field.id + (i/10), field.choices[i-1].text));
        }

        break;
        case 'gc_desc':
        field.label = '<?php _e('Description', 'gfgcal'); ?>';

        field.inputs = null;
        break;
	<?php
	}

	public static function admin_styles() {
	?>
		<style type="text/css">
			#add_google_calendar_fields input.disabled {
				color: #AAA!important;
				border-color: #DDD!important;
			}
		</style>
	<?php
	}

	public static function entry_field_value($display_value, $field, $lead, $form) {
		if (! in_array($field['type'], array_keys(self::$registered_fields)))
			return $display_value;

		$nfield = $field;
		switch ($field['type']) {
			case 'gc_date_start':
			case 'gc_date_end':
				$nfield['type'] = 'date';
				break;
			case 'gc_time_start':
			case 'gc_time_end':
				$nfield['type'] = 'time';
				break;
			case 'gc_allday':
				$nfield['type'] = 'checkbox';
				break;
			default:
				return $display_value;
		}

		return GFCommon::get_lead_field_display($nfield, $display_value);
	}

	public static function get_field_value($value, $lead, $field) {
		switch ($field['type']) {
			case 'gc_date_start':
			case 'gc_date_end':
				return GFCommon::date_display($value, $field["dateFormat"]);
			case 'gc_allday':
				$field['type'] = 'checkbox';

				return GFCommon::get_lead_field_display($field, $value);
		}

		return $value;
	}

	/**
	* after lead submission, handle processing of the description if there's a content template
	* (NB: this can't happen on the save_field_value filter, because the description may be empty and thus won't trigger the filter)
	* @param array $lead
	* @param array $form
	* @return array
	*/
	public static function entry_post_save($lead, $form) {
		if (rgar($form, 'gcDescTemplateEnabled')) {
			foreach ($form['fields'] as $field) {
				if ($field['type'] == 'gc_desc') {
					$value = GFCommon::replace_variables($form['gcDescTemplate'], $form, $lead);

					$input_name = 'input_' . str_replace('.', '_', $field['id']);
					$_POST[$input_name] = $value;

					self::update_lead_detail($form, $lead, $field);
				}
			}
		}

		return $lead;
	}

	/**
	* simplistic lead detail update, doesn't handle arrays
	* (currently only used for updating the calendar description field)
	* @param array $form
	* @param array $lead
	* @param array $field
	*/
	protected static function update_lead_detail($form, $lead, $field) {
		global $wpdb;

		$lead_detail_table = GFFormsModel::get_lead_details_table_name();
		$current_fields = $wpdb->get_results($wpdb->prepare("SELECT id, field_number FROM $lead_detail_table WHERE lead_id=%d", $lead['id']));

		GFFormsModel::save_input($form, $field, $lead, $current_fields, $field['id']);
	}

	public static function after_submission($entry, $form) {
		if (! self::has_gc_enabled($form['id']))
			return;

		gform_update_meta($entry['id'], 'gc_approve', 0);

		if (! self::requires_event_approval($form['id'])) {
			self::create_event($entry['id']);
		}
	}

	public static function pre_submission_filter($form) {
		foreach ($form['fields'] as &$field) {
			switch ($field['type']) {
				case 'gc_time_start':
				case 'gc_time_end':
					$field['type'] = 'time';
					break;
				case 'gc_date_start':
				case 'gc_date_end':
					$field['type'] = 'date';
					break;
				case 'gc_allday':
					$field['type'] = 'checkbox';
					break;
			}
		}

		return $form;
	}

	public static function ajax_approve() {
		check_ajax_referer('gf_gc_approve', 'gf_gc_approve');

		$lead_id = rgpost('lead_id');
		$approve = rgpost('value');

		header('Content-Type: application/json');

		if ($approve) {
			if (! self::create_event($lead_id))
				$message = array(
					'error' => __("ERROR: Couldn't submit event to Google Calendar.", 'gfgcal')
				);
		} else {
			if (! self::delete_event($lead_id))
				$message = array(
					'error' => __("ERROR: Selected event might have been deleted manually.", 'gfgcal')
				);
		}

		echo isset($message) ? json_encode($message) : 0;

		exit();
	}

	public static function create_event($lead_id) {
		if (gform_get_meta($lead_id, 'gc_event_id'))
			return false;

		$lead = RGFormsModel::get_lead($lead_id);
		$form = RGFormsModel::get_form_meta($lead['form_id']);

		$calendar_id = $form['googleCalendar'];

		$event = new Google_Event();

		$start = new Google_EventDateTime();
		$end = new Google_EventDateTime();

		$start_date = $end_date = '';
		$start_time = $end_time = '00:00:00.000';

		$all_day = false;

		$location = '';

		foreach ($form['fields'] as $field) {
			$id = $field['id'];

			if (! empty($field['inputs'])) {
				$value = array();

				foreach ($field['inputs'] as $input) {
					$value_id = (string)$input['id'];
					$value[] = $lead[$value_id];
				}
			} else {
				$value = $lead[$id];
			}

			switch ($field['type']) {
                case 'gc_title':
                    $event->setSummary($value);
                    break;
                case 'gc_firstname':
                    $event->addSummary($value);
                    break;
                case 'gc_tel':
                    $event->addSummary($value);
                    break;
                case 'gc_brand':
                    $event->addSummary($value);
                    break;
                case 'gc_model':
                    $event->addSummary($value);
                    break;
                case 'gc_desc':
                    $event->setDescription($value);
                    break;
                case 'gc_date_start':
                    $start_date = $value;
                    break;
                case 'gc_date_end':
                    $end_date = $value;
                    break;
                case 'gc_time_start':
                    $start_time = strftime('%X.000', strtotime($value));
                    $end_time = strftime('%X.000', strtotime($value));
                    break;
				case 'gc_time_end':
					$end_time = strftime('%X.000', strtotime($value));
					break;
				case 'gc_location':
					$location = trim($value);
					break;
				case 'gc_allday':
					if (in_array('allday', (array)$value)) {
						$all_day = true;
					}
					break;
			}
		}

		if (empty($end_date))
			$end_date = $start_date;

		$tz_string = GFGCal::$client->get_calendar_timezone($calendar_id);
		$tz_string = apply_filters('gfgcal_timezone_string', $tz_string, $lead, $form);

		if (! empty($tz_string)) {
			$start->setTimeZone($tz_string);
			$end->setTimeZone($tz_string);
		}

        if ($all_day || ($start_date == $end_date && $start_time == $end_time)) {
            //$end_date = strftime("%F", strtotime("$start_date+1day"));

            $startstr = $start_date . 'T' . $start_time;
            $endstr = $end_date . 'T' . $end_time;

            $start->setDateTime($startstr);
            $end->setDateTime($endstr);
        } else {
            $startstr = $start_date . 'T' . $start_time;
            $endstr = $end_date . 'T' . $end_time;

            $start->setDateTime($startstr);
            $end->setDateTime($endstr);
        }

        $event->setStart($start);
        $event->setEnd($end);

        $rem = new Google_EventReminders();
        $rem->setUseDefault('false');
        $overrides = array(
            array("method"=>"popup", "minutes"=>"2880"),
            array("method"=>"popup", "minutes"=>"1440")
        );
        $rem->setOverrides($overrides);
        $event->setReminders($rem);

		if (! empty($location))
			$event->setLocation($location);

		$ret = self::$client->insert_event($calendar_id, $event);

		if ($ret) {
			gform_update_meta($lead_id, 'gc_event_id', $ret['id']);
			gform_update_meta($lead_id, 'gc_approve', 1);
		}

		return !empty($ret);
	}

	public static function delete_event($lead_id) {
		$lead = RGFormsModel::get_lead($lead_id);
		$form = RGFormsModel::get_form_meta($lead['form_id']);

		$calendar_id = $form['googleCalendar'];

		$event_id = gform_get_meta($lead_id, 'gc_event_id');

		if (empty($event_id))
			return false;

		$ret = self::$client->delete_event($calendar_id, $event_id);

		if ($ret) {
			gform_delete_meta($lead_id, 'gc_event_id');
			gform_update_meta($lead_id, 'gc_approve', 0);
		}

		return $ret;
	}

	public static function field_standard_settings($position, $form_id) {
		if ($position == 900) {
			$form = RGFormsModel::get_form_meta($form_id);
			require_once GFGCAL_PLUGIN_ROOT . 'views/field-standard-settings.php';
		}
	}

	/**
	* pre-v1.7 form settings
	*/
	public static function properties_settings($position, $form_id) {
		if ($position == 500) {
			$form = RGFormsModel::get_form_meta($form_id);
			require_once GFGCAL_PLUGIN_ROOT . 'views/form-properties-settings.php';
		}
	}

	/**
	* post-1.7 form settings
	*/
	public static function form_settings($settings, $form) {
		ob_start();
		require_once GFGCAL_PLUGIN_ROOT . 'views/form-settings.php';
		$settings['Google Calendar'] = array('gfgcal_settings' => ob_get_clean());

		return $settings;
	}

	/**
	* enqueue scripts for the front end, but only if form has a date field
	*/
	public static function enqueue_scripts($form, $ajax) {
		if (self::has_gc_date_field($form)) {
			$gfBaseUrl = GFCommon::get_base_url();

			if (version_compare(GFCommon::$version, '1.6.99999', '<')) {
				// pre-1.7
				wp_enqueue_script('gforms_ui_datepicker', $gfBaseUrl . '/js/jquery-ui/ui.datepicker.js', array('jquery'), GFCommon::$version, true);
				wp_enqueue_script('gforms_datepicker', $gfBaseUrl . '/js/datepicker.js', array('gforms_ui_datepicker'), GFCommon::$version, true);
			}

			elseif (version_compare(GFCommon::$version, '1.7.6.99999', '<')) {
				// pre-1.7.7
				wp_enqueue_script("gforms_datepicker", $gfBaseUrl . "/js/datepicker.js", array('jquery-ui-datepicker'), GFCommon::$version, true);
			}

			else {
				// post-1.7.7
				wp_enqueue_script("gform_datepicker_init");
			}
		}
		add_action('wp_footer', array(__CLASS__, 'form_print_scripts'), 10);
	}

	public static function entries_first_column_actions($form_id, $field_id, $value, $lead, $query_string) {
		if (! self::has_gc_enabled($form_id))
			return;

		?>
		<span class="gc_approve">
			|
			<?php self::print_lead_approve_link($lead['id']); ?>
		</span>
		<?php
	}

	public static function remove_duplicate_field_hack($field_content, $field) {
		if (! in_array($field['type'], array_keys(self::$registered_fields)))
			return $field_content;

		return preg_replace("|<a class='field_duplicate_icon'[^>]+>[^<]+</a>|", '', $field_content);
	}

	private static function has_gc_date_field($form) {
		if (is_array($form["fields"])) {
			foreach ($form["fields"] as $field) {
				if ('gc_date_start' == RGFormsModel::get_input_type($field))
					return true;

				if ('gc_date_end' == RGFormsModel::get_input_type($field))
					return true;
			}
		}

		return false;
	}

	private static function has_gc_enabled($form_id) {
		$meta = RGFormsModel::get_form_meta($form_id);

		return !empty($meta['googleCalendar']);
	}

	private static function requires_event_approval($form_id) {
		$meta = RGFormsModel::get_form_meta($form_id);

		return !empty($meta['eventsRequireApproval']);
	}

	public static function gf_entries_scripts() {
		$screen = get_current_screen();
		// NB: could be forms_page_gf_entries or forms1_page_gf_entries
		if (!preg_match('/page_gf_entries$/', $screen->id))
			return;

	?>
		<script type="text/javascript">
			function ApproveGCEvent(lead_id, value) {
				jQuery.ajax(ajaxurl, {
					type: 'POST',
					data: {
						action: 'gf_gc_approve',
						gf_gc_approve: "<?php echo wp_create_nonce('gf_gc_approve'); ?>",
						lead_id: lead_id,
						value: value
					},
					success: function(response){
						if (response && response.error) {
							alert(response.error);
							return;
						}

						jQuery('#gc_approve_'+lead_id).css('display', value == 0 ? 'inline' : 'none');
						jQuery('#gc_disapprove_'+lead_id).css('display', value == 1 ? 'inline' : 'none');
					},
					error: function(){
						alert('<?php echo esc_js(__('Ajax Error while setting lead property', 'gfgcal')); ?>');
					},
					dataType: 'json'
				});

				return true;
			}

			function ApproveAllGCEvents(value) {
				jQuery('input[name="lead[]"]:checked').each(function(){
					ApproveGCEvent(this.value, value);
				});
			}
		</script>
	<?php
	}

	public static function entry_info($form_id, $lead) {
		if (! self::has_gc_enabled($form_id))
			return;

		$meta = RGFormsModel::get_form_meta($lead['form_id']);

		$calendar_id = rgar($meta, 'googleCalendar');
		$event_id = gform_get_meta($lead['id'], 'gc_event_id');

		if (empty($event_id))
			return;

		$event = self::$client->get_event($calendar_id, $event_id);

		if (empty($event))
			return;
	?>

		<?php _e('Event URL:', 'gfgcal'); ?> <a href="<?php echo $event['htmlLink']; ?>" title="<?php echo isset($event['description']) ? $event['description'] : ''; ?>" target="_blank"><?php echo $event['summary']; ?></a>

		<div class="gc_approve" style="border-top: 1px solid whiteSmoke; padding: 10px 0; margin: 10px 0 0;">
			<?php self::print_lead_approve_link($lead['id']); ?>
		</div>
	<?php
	}

	private static function print_lead_approve_link($lead_id) {
		$approve = gform_get_meta($lead_id, 'gc_approve');
	?>
			<a id="gc_approve_<?php echo $lead_id; ?>" href="javascript:ApproveGCEvent(<?php echo $lead_id; ?>, 1)" title="<?php echo esc_attr(__('Approve this event', 'gfgcal')); ?>" style="display: <?php echo $approve ? 'none' : 'inline'; ?>"><?php _e('Approve'); ?></a>
			<a id="gc_disapprove_<?php echo $lead_id; ?>" href="javascript:ApproveGCEvent(<?php echo $lead_id; ?>, 0)" title="<?php echo esc_attr(__('Disapprove this event', 'gfgcal')); ?>" style="display: <?php echo $approve ? 'inline' : 'none'; ?>"><?php _e('Disapprove'); ?></a>
	<?php
	}

	public static function entry_apply_button($apply_button) {
		$form_id = rgget('id');
		if (! self::has_gc_enabled($form_id))
			return $apply_button;

		$output  = '<div style="margin-top: 10px"><a href="javascript:ApproveAllGCEvents(1)">' . __('Approve', 'gfgcal') . '</a>';
		$output .= ' / ';
		$output .= '<a href="javascript:ApproveAllGCEvents(0)">' . __('Disapprove', 'gfgcal') . '</a> ' . __('All Checked Events', 'gfgcal') . '</div>';

		return $apply_button . $output;
	}

	public static function gravityforms_missing_notice() {
		$message = __('<strong>Gravity Forms</strong> is missing or not active. To use <strong>Gravity Forms Google Calendar</strong> you must first install and/or activate Gravity Forms.', 'gfgcal');

		echo '<div class="error"><p>' . $message  . '</p></div>';
	}

	public static function replace_merge_tags($text, $form, $entry) {
		if (! self::has_gc_enabled($form['id']))
			return $text;

		$calendar = self::$client->get_calendar($form['googleCalendar']);

		if (! $calendar)
			return $text;

		$text = str_replace("{calendar_title}", $calendar['summary'], $text);

		return $text;
	}

	public static function custom_merge_tags($merge_tags) {
		$merge_tags[] = array(
			'tag' => '{calendar_title}',
			'label' => __('Google Calendar Title', 'gfgcal')
		);

		return $merge_tags;
	}

	public static function field_css_class($css_class, $field, $form) {
		switch ($field['type']) {
			case 'gc_date_start':
				$css_class .= ' gc_date_start';
				break;
			case 'gc_date_end':
				$css_class .= ' gc_date_end';
				break;
		}

		return $css_class;
	}

	public static function form_print_scripts() {
		?>
		<script type="text/javascript">
		jQuery(function($){
			$('.gc_date_start input').change(function(){
				$(this).parents('.gform_body').find('.gc_date_end input').val($(this).val());
			});
		});
		</script>
		<?php
	}

	/**
	* check for plugin updates, every so often
	* @param object $plugins
	* @return object
	*/
	public static function checkPluginUpdates($plugins) {
		if (empty($plugins->checked)) {
			return $plugins;
		}

		$current = get_plugin_data(GFGCAL_PLUGIN_SCRIPT);
		$latest = self::getLatestVersionInfo();

		if ($latest && version_compare($current['Version'], $latest->new_version, '<')) {
			$data = new stdClass;

			$data->slug = $latest->slug;
			$data->new_version = $latest->new_version;
			$data->homepage = $latest->homepage;

			$plugins->response[GFGCAL_PLUGIN_NAME] = $data;
		}

		return $plugins;
	}

	/**
	* check plugin info
	* @param boolean $false
	* @param array $action
	* @param object $args
	* @return bool|object
	*/
	public static function checkPluginInfo($false, $action, $args) {
		if ($args->slug == GFGCAL_PLUGIN_SLUG) {
			return self::getLatestVersionInfo();
		}

		return $false;
	}

	/**
	* get plugin version info from remote server
	* @return object
	*/
	protected static function getLatestVersionInfo() {
		$url = add_query_arg(array('v' => time()), GFGCAL_PLUGIN_LATEST);
		$response = wp_remote_get($url, array('timeout' => 60));

		if (is_wp_error($response)) {
			return false;
		}

		if ($response && isset($response['body']) && function_exists('simplexml_load_string')) {
			// prevent XML injection attacks, and handle errors without warnings
			$oldDisableEntityLoader = libxml_disable_entity_loader(TRUE);
			$oldUseInternalErrors = libxml_use_internal_errors(TRUE);

			// load XML from response body
			$xml = simplexml_load_string($response['body'], 'SimpleXMLElement', LIBXML_NOCDATA);

			// restore old libxml settings
			libxml_disable_entity_loader($oldDisableEntityLoader);
			libxml_use_internal_errors($oldUseInternalErrors);

			if ($xml) {
				$info = new stdClass();
				$info->slug = (string) $xml->slug;
				$info->plugin_name = (string) $xml->plugin_name;
				$info->new_version = (string) $xml->new_version;
				$info->requires = (string) $xml->requires;
				$info->tested = (string) $xml->tested;
				$info->last_updated = (string) $xml->last_updated;
				$info->sections = array(
					'description' => (string) $xml->sections->description,
					'changelog' => (string) $xml->sections->changelog,
				);
				$info->homepage = (string) $xml->homepage;
				$info->download_link = (string) $xml->download_link;

				return $info;
			}
		}

		return false;
	}

}

$modules = array(
	'gfgcal-client',
	'gfgcal-settings-page',
);

foreach ($modules as $module) {
	require_once GFGCAL_PLUGIN_ROOT . "$module.php";
}

add_action('init', array('GFGCal', 'init'));
