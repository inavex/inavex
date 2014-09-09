<?php

class GFGCalSettingsPage {

	public static function init() {
		if (is_admin())
			RGForms::add_settings_page('Google Calendar', array(__CLASS__, 'page'), '');

		add_action('admin_init', array(__CLASS__, 'save_settings'));
	}

	public static function page() {
		require_once GFGCAL_PLUGIN_ROOT . 'views/admin-settings.php';
	}

	public static function save_settings() {
		if (! isset($_REQUEST['gf_gcal_submit']))
			return;

		$authcode = $_REQUEST['gf_gcal_authcode'];

		check_admin_referer('_gfgcal_nonce', 'gfgcal_settings_nonce');

		if (! empty($authcode))
			remove_action('admin_notices', array('GFGCalClient', 'api_key_notice'));

		$oldcode = GFGCalClient::get_auth_code();
		if ($oldcode !== $authcode) {
			update_option('gfgcal_auth_code', $authcode);

			if (GFGCal::$client->refresh_access_token()) {
				add_action('admin_notices', array(__CLASS__, 'settings_saved_notice'));
			} else {
				add_action('admin_notices', array(__CLASS__, 'invalid_auth_code_notice'));
			}
		}
	}

	public static function invalid_auth_code_notice() {
		$message = __('The auth code provided is invalid. Please try again.', 'gfgcal');

		echo '<div class="error"><p>' . $message . '</p></div>';
	}

	public static function settings_saved_notice() {
		$message = __('Settings saved.');

		echo '<div class="updated"><p>' . $message . '</p></div>';
	}
}
