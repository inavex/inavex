<?php

class GFGCalClient {

	const ClientAppName = 'Gravity Forms Connect to Google Calendar';
	const ClientID = '70835972665.apps.googleusercontent.com';
	const ClientSecret = 'LudNLZ_Rv_SFFNJVz2Jmvv2G';

	protected $_gclient;
	protected $_gcservice;

	function __construct() {
		require_once GFGCAL_PLUGIN_ROOT . 'lib/google/Google_Client.php';
		require_once GFGCAL_PLUGIN_ROOT . 'lib/google/contrib/Google_CalendarService.php';

		$this->api_service_setup();
	}

	private function api_service_setup() {
		$this->_gclient = new Google_Client();
		$this->_gclient->setApplicationName(self::ClientAppName);
		$this->_gclient->setClientId(self::ClientID);
		$this->_gclient->setClientSecret(self::ClientSecret);
		$this->_gclient->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');

		$this->_gcservice = new Google_CalendarService($this->_gclient);

		$this->set_access_token();
	}

	public function refresh_access_token() {
		$code = self::get_auth_code();

		if (empty($code)) {
			delete_option('gfgcal_access_token');
			return false;
		}

		try {
			$a = $this->_gclient->authenticate($code);
			$token = $this->_gclient->getAccessToken();

			update_option('gfgcal_access_token', $token);

			return true;
		} catch (Google_AuthException $ex) {
			delete_option('gfgcal_access_token');
		}

		return false;
	}

	public static function get_auth_code() {
		return get_option('gfgcal_auth_code', false);
	}

	public static function get_access_token() {
		return get_option('gfgcal_access_token', false);
	}

	private function set_access_token() {
		$token = self::get_access_token();

		if ($token) {
			$this->_gclient->setAccessToken($token);

			return true;
		} else {
			return false;
		}
	}

	public static function api_key_notice() {
		// handle change in settings pages
		if (version_compare(GFCommon::$version, '1.7.0', '<')) {
			$settingsURL = admin_url('admin.php?page=gf_settings&addon=Google+Calendar');
		}
		else {
			$settingsURL = admin_url('admin.php?page=gf_settings&subview=Google+Calendar');
		}

		$message = sprintf(__('You need to get an authentication code so <strong>Gravity Forms Google Calendar</strong> integration can work. Please visit the <a href="%s">settings page</a> to get started.', 'gfgcal'), $settingsURL);

		echo '<div class="error"><p>' . $message  . '</p></div>';
	}

	public function get_auth_url() {
		return $this->_gclient->createAuthUrl();
	}

	public function get_calendar_list() {
		$minaccrole = apply_filters('gfgcal_calendarlist_min_access_role', 'owner');

		try {
			$list = $this->_gcservice->calendarList->listCalendarList(array(
				'minAccessRole' => $minaccrole
			));
		} catch (Exception $ex) {
			return array();
		}

		if ($list && is_array($list))
			return $list['items'];

		return array();
	}

	public function insert_event($calendar_id, $event) {
		try {
			$newevt = $this->_gcservice->events->insert($calendar_id, $event);
			return $newevt;
		} catch (Exception $ex) {
			return false;
		}
	}

	public function delete_event($calendar_id, $event_id) {
		try {
			$this->_gcservice->events->delete($calendar_id, $event_id);
			return true;
		} catch (Exception $ex) {
			return false;
		}
	}

	public function get_calendar($calendar_id) {
		try {
			$calendar = $this->_gcservice->calendars->get($calendar_id);
			return $calendar;
		} catch (Google_ServiceException $ex) {
		}

		return false;
	}

	public function get_event($calendar_id, $id) {
		return $this->_gcservice->events->get($calendar_id, $id);
	}

	public function get_calendar_timezone($calendar_id) {
		$calendar = $this->get_calendar($calendar_id);

		if (! $calendar)
			return null;

		return $calendar['timeZone'];
	}

	public function is_busy($calid, $timemin, $timemax) {
		$fb_request = new Google_FreeBusyRequest();
		$fb_request->setTimeMin($timemin);
		$fb_request->setTimeMax($timemax);
		$fb_request->setItems(array(
			array(
				'id' => $calid
			)
		));

		try {
			$response = $this->_gcservice->freebusy->query($fb_request);
			return ! empty($response['calendars'][$calid]['busy']);
		} catch (Exception $ex) {
			return true;
		}
	}
}
