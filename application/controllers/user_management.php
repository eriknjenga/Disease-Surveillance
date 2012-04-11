<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library('pagination');
	}

	public function index() {
		$this -> listing();
	}

	public function login() {
		$data = array();
		$data['title'] = "System Login";
		$this -> load -> view("login_v", $data);
	}

	public function listing($offset = 0) {
		$items_per_page = 20;
		$number_of_users = Users::getTotalNumber();
		$users = Users::getPagedUsers($offset, $items_per_page);
		if ($number_of_users > $items_per_page) {
			$config['base_url'] = base_url() . "user_management/listing/";
			$config['total_rows'] = $number_of_users;
			$config['per_page'] = $items_per_page;
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
			$this -> pagination -> initialize($config);
			$data['pagination'] = $this -> pagination -> create_links();
		}

		$data['users'] = $users;
		$data['title'] = "User Management::All System Users";
		$data['module_view'] = "view_users_view";
		$this -> base_params($data);
	}

	public function authenticate() {
		$data = array();
		$validated = $this -> _submit_validate();
		if ($validated) {
			$username = $this -> input -> post("username");
			$password = $this -> input -> post("password");
			$remember = $this -> input -> post("remember");
			$logged_in = Users::login($username, $password);
			//This code checks if the credentials are valid
			if ($logged_in == false) {
				$data['invalid'] = true;
				$data['title'] = "System Login";
				$this -> load -> view("login_v", $data);
			}
			//If the credentials are valid, continue
			else {
				//check to see whether the user is active
				if ($logged_in -> Flag == "0") {
					$data['inactive'] = true;
					$data['title'] = "System Login";
					$this -> load -> view("login_v", $data);
				}
				//looks good. Continue!
				else {
					$session_data = array('user_id' => $logged_in -> id, 'user_indicator' => $logged_in -> Access -> Indicator, 'access_level' => $logged_in -> Access_Level, 'username' => $logged_in -> Username, 'full_name' => $logged_in -> Name, 'district_province_id' => $logged_in -> District_Or_Province, 'can_delete' => $logged_in -> Can_Delete, 'can_download_raw_data' => $logged_in -> Can_Download_Raw_Data);
					$this -> session -> set_userdata($session_data);

					redirect("home_controller");
				}

			}

		} else {
			$data = array();
			$data['title'] = "System Login";
			$this -> load -> view("login_v", $data);
		}
	}

	private function _submit_validate() {
		// validation rules
		$this -> form_validation -> set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[12]');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[12]');

		return $this -> form_validation -> run();
	}

	public function go_home($data) {
		$data['title'] = "System Home";
		$data['content_view'] = "home_v";
		$data['banner_text'] = "Dashboards";
		$data['link'] = "home";
		$this -> load -> view("template", $data);
	}

	public function base_params($data) {
		$data['scripts'] = array("jquery-ui.js", "tab.js");
		$data['styles'] = array("jquery-ui.css", "tab.css","pagination.css");
		$data['content_view'] = "admin_view";
		$data['quick_link'] = "user_management";
		$data['banner_text'] = "System Users";
		$data['link'] = "system_administration";
		$this -> load -> view('template', $data);
	}

}
