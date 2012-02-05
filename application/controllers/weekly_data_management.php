<?php
class Weekly_Data_Management extends MY_Controller {

	function __construct() {
		parent::__construct();
	}//end constructor

	public function index() {
		$this -> add();
	}//end index

	public function add() {
		$provinces = Province::getAll();
		$districts = District::getAll();
		$diseases = Disease::getAllObjects();

		$data['provinces'] = $provinces;
		$data['districts'] = $districts;
		$data['diseases'] = $diseases;
		$data['scripts'] = array("special_date_picker.js");
		$this -> base_params($data);
	}//end add

	public function save() {
		$i = 0;
		$valid = $this -> _validate_submission();
		if ($valid == false) {
			$this -> add();
		} else {
			$diseases = Disease::getAllObjects();

			$weekending = $this -> input -> post("week_ending");
			$reporting_year = $this -> input -> post("reporting_year");
			$epiweek = $this -> input -> post("epiweek");
			$district = $this -> input -> post("district");
			$reportingfacilities = $this -> input -> post("reporting_facilities");
			$expectedfacilities = $this -> input -> post("expected_facilities");
			$lmcase = $this -> input -> post("lmcase");
			$lfcase = $this -> input -> post("lfcase");
			$lmdeath = $this -> input -> post("lmdeath");
			$lfdeath = $this -> input -> post("lfdeath");
			$gmcase = $this -> input -> post("gmcase");
			$gfcase = $this -> input -> post("gfcase");
			$gmdeath = $this -> input -> post("gmdeath");
			$gfdeath = $this -> input -> post("gfdeath");
			$sickness = $this -> input -> post("disease");
			$reported_by = $this -> input -> post("reported_by");
			$designation = $this -> input -> post("designation");
			$i = 0;
			foreach ($diseases as $disease) {
				$surveillance = new Surveillance();
				$surveillance -> Week_Ending = $weekending;
				$surveillance -> Epiweek = $epiweek;
				$surveillance -> District = $district;
				$surveillance -> Submitted = $reportingfacilities;
				$surveillance -> Expected = $expectedfacilities;
				$surveillance -> Lmcase = $lmcase[$i];
				$surveillance -> Lfcase = $lfcase[$i];
				$surveillance -> Lmdeath = $lmdeath[$i];
				$surveillance -> Lfdeath = $lfdeath[$i];
				$surveillance -> Gmcase = $gmcase[$i];
				$surveillance -> Gfcase = $gfcase[$i];
				$surveillance -> Gmdeath = $gmdeath[$i];
				$surveillance -> Gfdeath = $gfdeath[$i];
				$surveillance -> Disease = $disease;
				$surveillance -> Reporting_Year = $reporting_year;
				$surveillance -> Created_By = $this -> session -> userdata('user_id');
				$surveillance -> Date_Created = date("d-m-Y");
				$surveillance -> Reported_By = $reported_by;
				$surveillance -> Designation = $designation;
				$surveillance -> save();
				$i++;
			}//end foreach

			//Lab Data
			$labdata = new Lab_Weekly();
			$epiweek = $this -> input -> post("epiweek");
			$weekending = $this -> input -> post("weekending");
			$district = $this -> input -> post("district");

			$totaltestedlessfive = $this -> input -> post("total_tested_less_than_five");
			$totaltestedgreaterfive = $this -> input -> post("total_tested_greater_than_five");
			$totalpositivelessfive = $this -> input -> post("total_positive_less_than_five");
			$totalpositivegreaterfive = $this -> input -> post("total_positive_greater_than_five");
			$remarks = $this -> input -> post("remarks");

			$labdata -> Epiweek = $epiweek;
			$labdata -> Week_Ending = $weekending;
			$labdata -> District = $district;
			$labdata -> Malaria_Below_5 = $totaltestedlessfive;
			$labdata -> Malaria_Above_5 = $totaltestedgreaterfive;
			$labdata -> Positive_Below_5 = $totalpositivelessfive;
			$labdata -> Positive_Above_5 = $totalpositivegreaterfive;
			$labdata -> Remarks = $remarks;
			$labdata -> Reporting_Year = $reporting_year;
			$labdata -> Date_Created = date("d-m-Y");
			$labdata -> save();
		}
	}//end save

	private function _validate_submission() {
		$this -> form_validation -> set_rules('district', 'District', 'trim|required|min_length[2]|max_length[25]');

		return $this -> form_validation -> run();
	}//end validate_submission

	public function base_params($data) {
		$data['title'] = "Weekly Data";
		$data['content_view'] = "weekly_data_add_v";
		$data['banner_text'] = "Weekly Data";
		$data['link'] = "submissions_management";
		$data['quick_link'] = "weekly_data_management";
		$this -> load -> view("template", $data);
	}

}//end class
