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

	public function edit_duplicate($number_of_diseases, $first_surveillance_id, $malaria_data_id) {
		$last_surveillance_id = $first_surveillance_id + $number_of_diseases - 1;
		$provinces = Province::getAll();
		$districts = District::getAll();
		$diseases = Disease::getAllObjects();

		$data['provinces'] = $provinces;
		$data['districts'] = $districts;
		$data['diseases'] = $diseases;
		$data['prediction'] = Surveillance::getPrediction();
		$data['surveillance_data'] = Surveillance::getSurveillanceDataRange($first_surveillance_id, $last_surveillance_id);
		$data['lab_data'] = Lab_Weekly::getLabObjects($malaria_data_id);
		$data['editing'] = true;
		$data['scripts'] = array("special_date_picker.js", "validationEngine-en.js", "validator.js");
		$data["styles"] = array("validator.css");
		$data['title'] = "Duplicate Data Editing";
		$data['content_view'] = "weekly_data_add_v";
		$data['banner_text'] = "Weekly Data Correction";
		$data['link'] = "data_quality_management";
		$this -> load -> view("template", $data);
	}

	public function delete_duplicate($number_of_diseases, $first_surveillance_id, $malaria_data_id,$district,$epiweek,$year) {
		$last_surveillance_id = $first_surveillance_id + $number_of_diseases - 1;
		$surveillance_records = Surveillance::getSurveillanceDataRange($first_surveillance_id, $last_surveillance_id);
		foreach($surveillance_records as $surveillance_record){
			$surveillance_record->delete();
		}
		$lab_data = Lab_Weekly::getLabObjects($malaria_data_id);
		$lab_data->delete();
		$redirection_url = base_url()."data_duplication/view_details/".$epiweek."/".$year."/".$district;
		redirect($redirection_url); 
	}

}
