<?php /* post-v1.7 form settings */ ?>

<tr class="google_calendar_setting gform_setting">
	<th>
		<?php _e('Google Calendar', 'gfgcal'); ?>
		<?php gform_tooltip('form_field_google_calendar') ?>
	</th>
	<td>
		<select id="form_google_calendar">
			<option value=""><?php _e('&mdash; Select Calendar &mdash;', 'gfgcal'); ?></option>
			<?php $calendars = GFGCal::$client->get_calendar_list(); ?>
			<?php foreach ((array) $calendars as $calendar) : ?>
				<option value="<?php echo esc_attr($calendar['id']); ?>" <?php selected(esc_attr($calendar['id']), rgar($form, 'googleCalendar')); ?>><?php echo $calendar['summary']; ?></option>

			<?php endforeach; ?>
		</select>
	</td>
</tr>

<tr class="events_require_approval_setting gform_setting">
	<th>&nbsp;</th>
	<td>
		<input type="checkbox" id="form_events_require_approval" name="form_events_require_approval" value="1" <?php checked(rgar($form, 'eventsRequireApproval'), true); ?>/>
		<label for="form_events_require_approval">
			<?php _e('Google Calendar Events require approval', 'gfgcal'); ?>
			<?php gform_tooltip('form_events_require_approval'); ?>
		</label>
	</td>
</tr>

<tr class="freebusy_check_setting gform_setting">
	<th>&nbsp;</th>
	<td>
		<input type="checkbox" id="form_freebusy_check" name="form_freebusy_check" value="1" <?php checked(rgar($form, 'freeBusyCheck'), true); ?>/>
		<label for="form_freebusy_check">
			<?php _e('Google Calendar Check Free/Busy', 'gfgcal'); ?>
			<?php gform_tooltip('form_freebusy_check'); ?>
		</label>
	</td>
</tr>

