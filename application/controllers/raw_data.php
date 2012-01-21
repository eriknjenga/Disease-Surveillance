<?php
class Raw_Data extends MY_Controller {

	//required
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this -> show_interface();
	}

	public function show_interface() {
		$data = array();
		$data['settings_view'] = "raw_data_v";  
		$this -> base_params($data);
	}
 

	public function base_params($data) {
		$data['styles'] = array("jquery-ui.css");
		$data['scripts'] = array("jquery-ui.js");
		$data['quick_link'] = "raw_data";
		$data['title'] = "System Reports";
		$data['content_view'] = "raw_data_v";
		$data['banner_text'] = "Raw Data";
		$data['link'] = "reports_management";
		
		$this -> load -> view('template', $data);
	}

}
