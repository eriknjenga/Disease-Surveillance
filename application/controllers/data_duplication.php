<?php
class Data_Duplication extends MY_Controller {

	//required
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this -> show_interface();
	}

	public function show_interface() {
		$data = array();
		$data['quality_view'] = "data_duplication_v";
		$this -> base_params($data);
	}

	public function base_params($data) {
		$data['styles'] = array("jquery-ui.css");
		$data['scripts'] = array("jquery-ui.js");
		$data['quick_link'] = "data_duplication";
		$data['title'] = "Data Quality";
		$data['content_view'] = "data_quality_v";
		$data['banner_text'] = "Data Duplication";
		$data['link'] = "data_quality_management";
		$this -> load -> view('template', $data);
	}

	public function analyze() {
		$year = $this -> input -> post('year');
		$epiweek = $this -> input -> post('epiweek');
		$data['duplicates'] = Surveillance::getDuplicates($year, $epiweek);
		$data['quality_view'] = "data_duplication_v";
		$data['total_diseases'] = Disease::getTotal();
		$data['epiweek'] = $epiweek;
		$data['year'] = $year;
		$data['small_title'] = "Districts with duplicates in " . $year . " Epiweek " . $epiweek;
		$this -> base_params($data);
	}

	public function view_details($epiweek, $year, $district) {
		$data['surveillance_data'] = Surveillance::getSurveillanceData($epiweek, $year, $district);
		$data['lab_data'] = Lab_Weekly::getWeeklyDistrictLabData($epiweek, $year, $district);
		$data['quality_view'] = "data_duplication_details_v";
		$data['diseases'] = Disease::getAllObjects();
		$this -> base_params($data);
	}
	
	public function edit_duplicate(){
		
	}

}
