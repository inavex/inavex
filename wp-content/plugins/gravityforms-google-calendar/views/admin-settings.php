<form method="post" action="">
	<?php wp_nonce_field('_gfgcal_nonce', 'gfgcal_settings_nonce'); ?>
	<h3><?php _e('Google Calendar Settings', 'gfgcal'); ?></h3>

	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="gf_gcal_authcode"><?php _e('Google Auth Code', 'gfgcal'); ?></label>
			</th>
			<td>
				<input type="text" id="gf_gcal_authcode" name="gf_gcal_authcode" value="<?php echo esc_attr(GFGCal::$client->get_auth_code()); ?>" class="large-text" />
				<a href="<?php echo GFGCal::$client->get_auth_url(); ?>" title="<?php _e('Get auth code', 'gfcal'); ?>" target="_blank"><?php _e('Get auth code', 'gfcal'); ?></a>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<input type="submit" name="gf_gcal_submit" class="button-primary" value="<?php _e('Save Settings', 'gfgcal'); ?>" />
			</td>
		</tr>
	</table>
</form>
