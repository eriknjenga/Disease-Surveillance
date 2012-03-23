<?php
class Data_Delete_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library('pagination');
	}

	public function index() {
		$this -> view_logs();
	}

	public function view_logs($offset = 0) {
		$items_per_page = 20;
		$number_of_logs = Data_Delete_Log::getTotalLogs();
		$logs = Data_Delete_Log::getPagedLogs($offset, $items_per_page);
		if ($number_of_logs > $items_per_page) {
			$config['base_url'] = base_url() . "data_delete_management/view_logs/";
			$config['total_rows'] = $number_of_logs;
			$config['per_page'] = $items_per_page;
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
			$this -> pagination -> initialize($config);
			$data['pagination'] = $this -> pagination -> create_links();
		}

		$data['logs'] = $logs;
		$data['title'] = "Data Deletion Logs";
		$data['content_view'] = "data_deletion_logs_v";
		$data['banner_text'] = "Deletion Logs";
		$data['link'] = "submissions_management"; 
		$data['styles'] = array("pagination.css");
		$this -> load -> view("template", $data);
	}

}
