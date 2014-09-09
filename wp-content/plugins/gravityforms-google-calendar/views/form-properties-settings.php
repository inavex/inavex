<?php /* pre-v1.7 form settings */ ?>

<li class="google_calendar_setting gfrom_setting">
	<label for="form_google_calendar">
		<?php _e('Google Calendar', 'gfgcal'); ?>
		<?php gform_tooltip('form_field_google_calendar') ?>
	</label>
	<select id="form_google_calendar">
		<option value=""><?php _e('&mdash; Select Calendar &mdash;', 'gfgcal'); ?></option>
		<?php $calendars = GFGCal::$client->get_calendar_list(); ?>
		<?php foreach ((array) $calendars as $calendar) : ?>
			<option value="<?php echo esc_attr($calendar['id']); ?>" <?php selected(esc_attr($calendar['id']), rgar($form, 'googleCalendar')); ?>><?php echo $calendar['summary']; ?></option>

		<?php endforeach; ?>
	</select>
</li>

<li class="events_require_approval_setting gfrom_setting">
	<input type="checkbox" id="form_events_require_approval" name="form_events_require_approval" value="1" <?php checked(rgar($form, 'eventsRequireApproval'), true); ?>/>
	<label for="form_events_require_approval">
		<?php _e('Google Calendar Events require approval', 'gfgcal'); ?>
		<?php gform_tooltip('form_events_require_approval'); ?>
	</label>
</li>

<li class="freebusy_check_setting gform_setting">
	<input type="checkbox" id="form_freebusy_check" name="form_freebusy_check" value="1" <?php checked(rgar($form, 'freeBusyCheck'), true); ?>/>
	<label for="form_freebusy_check">
		<?php _e('Google Calendar Check Free/Busy', 'gfgcal'); ?>
		<?php gform_tooltip('form_freebusy_check'); ?>
	</label>
</li>

