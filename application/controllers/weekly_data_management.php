<?php
class Weekly_Data_Management extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {

		$this -> add();
	}

	public function add($data = array()) {
		$access_level = $this -> session -> userdata('user_indicator');
		if ($access_level == "district_clerk") {
			$district = $this -> session -> userdata('district_province_id');
			$data['facilities'] = Facilities::getDistrictFacilities($district);
			$diseases = Disease::getAllObjects();
			$data['diseases'] = $diseases;
			$data['editing'] = false;
			$data['prediction'] = Facility_Surveillance_Data::getPrediction();
			$data['scripts'] = array("special_date_picker.js", "validationEngine-en.js", "validator.js");
			$data["styles"] = array("validator.css");
			$this -> base_params($data);
		} else {
			$data['title'] = "Weekly Data";
			$data['content_view'] = "error_message_v";
			$data['error_message'] = "You are not authorized to add weekly epidemiological data. Please contact the system administrator for assistance!";
			$data['banner_text'] = "Weekly Data";
			$data['link'] = "submissions_management";
			$data['quick_link'] = "weekly_data_management";
			$this -> load -> view("template", $data);
		}
	}

	public function edit_weekly_data($epiweek, $reporting_year, $facility) {
		$facility_object = Facilities::getFacility($facility);
		$district = $this -> session -> userdata('district_province_id');
		//Check if the facility that the user wants to edit data for is in their district
		if ($facility_object -> district == $district) {
			$data['surveillance_data'] = Facility_Surveillance_Data::getSurveillanceData($epiweek, $reporting_year, $facility);
			$data['lab_data'] = Facility_Lab_Weekly::getWeeklyFacilityLabData($epiweek, $reporting_year, $facility);
			$data['editing'] = true;
			$this -> add($data);
		} else {
			$data['title'] = "Weekly Data";
			$data['content_view'] = "error_message_v";
			$data['error_message'] = "You are not authorized to edit epidemiological data for facilities outside your district. Please contact the system administrator for assistance!";
			$data['banner_text'] = "Weekly Data";
			$data['link'] = "submissions_management";
			$data['quick_link'] = "weekly_data_management";
			$this -> load -> view("template", $data);
		}

	}

	public function delete_weekly_data($epiweek, $reporting_year, $district) {
		$data['surveillance_data'] = Surveillance::getSurveillanceData($epiweek, $reporting_year, $district);
		$data['title'] = "Delete Weekly Data";
		$data['content_view'] = "delete_weekly_data_v";
		$data['banner_text'] = "Delete Data";
		$data['link'] = "submissions_management";
		$this -> load -> view("template", $data);
	}

	public function confirm_delete_weekly_data($epiweek, $reporting_year, $district) {
		$surveillance_data = Surveillance::getSurveillanceData($epiweek, $reporting_year, $district);
		$lab_data = Lab_Weekly::getWeeklyDistrictLabData($epiweek, $reporting_year, $district);
		//Delete the data
		foreach ($surveillance_data as $disease_data) {
			$disease_data -> delete();
		}
		$lab_data -> delete();
		//Log the action
		$log = new Data_Delete_Log();
		$log -> Deleted_By = $this -> session -> userdata('user_id');
		$log -> District_Affected = $district;
		$log -> Epiweek = $epiweek;
		$log -> Reporting_Year = $reporting_year;
		$log -> Timestamp = date('U');
		$log -> save();
		redirect("data_delete_management");
	}

	public function save() {
		$i = 0;
		$valid = $this -> _validate_submission();
		if ($valid == false) {
			$this -> add();
		} else {
			$editing = false;
			$existing_district_data = false;
			$existing_district_lab_data = false;
			$diseases = Disease::getAllObjects();
			$district = $this -> session -> userdata('district_province_id');
			$weekending = $this -> input -> post("week_ending");
			$reporting_year = $this -> input -> post("reporting_year");
			$epiweek = $this -> input -> post("epiweek");
			$facility = $this -> input -> post("facility");
			$lcase = $this -> input -> post("lcase");
			$ldeath = $this -> input -> post("ldeath");
			$gcase = $this -> input -> post("gcase");
			$gdeath = $this -> input -> post("gdeath");
			$reported_by = $this -> input -> post("reported_by");
			$designation = $this -> input -> post("designation");
			$lab_id = $this -> input -> post("lab_id");
			$surveillance_ids = $this -> input -> post("surveillance_ids");
			//Check if a duplicate for facility data exists
			$data_exists = Facility_Surveillance_Data::getFacilityData($epiweek, $reporting_year, $facility);
			if ($lab_id > 0) {
				$editing = true;
			}
			//If there is a duplicate, redirect the user to the input form and inform them
			if ($data_exists -> id && $editing == false) {
				$data = array();
				$data['duplicate_facility'] = Facilities::getFacility($facility);
				$data['duplicate_epiweek'] = $epiweek;
				$data['duplicate_reporting_year'] = $reporting_year;
				$data['existing_data'] = true;
				$this -> add($data);
				return;
			}

			$total_diseases = Disease::getTotal();
			$timestamp = date('d/m/Y');
			$i = 0;
			foreach ($diseases as $disease) {
				//also retrieve the aggregated district record to update it
				$district_data = Surveillance::getDistrictDiseaseData($epiweek, $reporting_year, $district, $disease -> id);
				//If the record already existed, just update it. If not, create a new one!
				if (!$district_data -> id) {
					$district_data = new Surveillance();
				} else {
					$existing_district_data = true;
				}
				if ($editing == true) {
					//If we are editing, retrieve the record being edited from the database
					$surveillance = Facility_Surveillance_Data::getSurveillance($surveillance_ids[$i]);

				} else {
					//If not, create a new surveillance record
					$surveillance = new Facility_Surveillance_Data();
				}

				//Populate the district surveillance data
				$district_data -> Week_Ending = $weekending;
				$district_data -> Epiweek = $epiweek;
				$district_data -> District = $district;
				$district_data -> Expected = Facilities::getTotalNumber($district);
				//If the district data already existed, update it. Else, create it
				if ($existing_district_data) {
					//If we are editing a record,
					if ($editing == true) {
						//retrieve the value in the district row,
						$district_lcase = $district_data -> Lcase;
						//subtract the old value and add the new value
						$district_lcase -= $surveillance -> Lcase;
						$district_lcase += $lcase[$i];

						//retrieve the value in the district row,
						$district_ldeath = $district_data -> Ldeath;
						//subtract the old value and add the new value
						$district_ldeath -= $surveillance -> Ldeath;
						$district_ldeath += $ldeath[$i];

						//retrieve the value in the district row,
						$district_gcase = $district_data -> Gcase;
						//subtract the old value and add the new value
						$district_gcase -= $surveillance -> Gcase;
						$district_gcase += $gcase[$i];

						//retrieve the value in the district row,
						$district_gdeath = $district_data -> Gdeath;
						//subtract the old value and add the new value
						$district_gdeath -= $surveillance -> Gdeath;
						$district_gdeath += $gdeath[$i];

						$district_data -> clearRelated();
						$district_data -> Lcase = $district_lcase;
						$district_data -> Ldeath = $district_ldeath;
						$district_data -> Gcase = $district_gcase;
						$district_data -> Gdeath = $district_gdeath;
					}
					//If it is a new facility record, just add it to the existing values
					else {
						//retrieve the value in the district row,
						$district_lcase = $district_data -> Lcase;
						$district_lcase += $lcase[$i];

						//retrieve the value in the district row,
						$district_ldeath = $district_data -> Ldeath;
						$district_ldeath += $ldeath[$i];

						//retrieve the value in the district row,
						$district_gcase = $district_data -> Gcase;
						$district_gcase += $gcase[$i];

						//retrieve the value in the district row,
						$district_gdeath = $district_data -> Gdeath;
						$district_gdeath += $gdeath[$i];

						//Update the submitted/expected parameters
						$district_submitted = $district_data -> Submitted;
						$district_submitted += 1;

						$district_data -> clearRelated();
						$district_data -> Lcase = $district_lcase;
						$district_data -> Ldeath = $district_ldeath;
						$district_data -> Gcase = $district_gcase;
						$district_data -> Gdeath = $district_gdeath;
						$district_data -> Submitted = $district_submitted;

					}

				} else {
					$district_data -> Lcase = $lcase[$i];
					$district_data -> Ldeath = $ldeath[$i];
					$district_data -> Gcase = $gcase[$i];
					$district_data -> Gdeath = $gdeath[$i];
					$district_data -> Submitted = '1';
				}

				$district_data -> Disease = $disease;
				$district_data -> Reporting_Year = $reporting_year;
				$district_data -> Created_By = $this -> session -> userdata('user_id');
				$district_data -> Date_Created = date("Y-m-d");
				$district_data -> Reported_By = $reported_by;
				$district_data -> Designation = $designation;
				$district_data -> Total_Diseases = $total_diseases;
				$district_data -> Date_Reported = $timestamp;
				$district_data -> save();

				//Populate the facility surveillance data
				$surveillance -> clearRelated();
				$surveillance -> Week_Ending = $weekending;
				$surveillance -> Epiweek = $epiweek;
				$surveillance -> District = $district;
				$surveillance -> Facility = $facility;
				$surveillance -> Lcase = $lcase[$i];
				$surveillance -> Ldeath = $ldeath[$i];
				$surveillance -> Gcase = $gcase[$i];
				$surveillance -> Gdeath = $gdeath[$i];
				$surveillance -> Disease = $disease;
				$surveillance -> Reporting_Year = $reporting_year;
				$surveillance -> Created_By = $this -> session -> userdata('user_id');
				$surveillance -> Date_Created = date("Y-m-d");
				$surveillance -> Reported_By = $reported_by;
				$surveillance -> Designation = $designation;
				$surveillance -> Total_Diseases = $total_diseases;
				$surveillance -> Date_Reported = $timestamp;
				$surveillance -> save();
				$i++;
			}//end foreach

			//Lab Data
			//also retrieve the aggregated district record to update it
			$district_lab__data = Lab_Weekly::getWeeklyDistrictLabData($epiweek, $reporting_year, $district);
			$district_lab__data = $district_lab__data[0];
			//If the record already existed, just update it. If not, create a new one!
			if (!$district_lab__data -> id) {
				$district_lab__data = new Lab_Weekly();
			} else {
				$existing_district_lab_data = true;
			}

			//Check if we are editing the facility lab data
			if ($editing == true) {
				$labdata = Facility_Lab_Weekly::getLabObject($lab_id);
			} else {
				$labdata = new Facility_Lab_Weekly();
			}
			$totaltestedlessfive = $this -> input -> post("total_tested_less_than_five");
			$totaltestedgreaterfive = $this -> input -> post("total_tested_greater_than_five");
			$totalpositivelessfive = $this -> input -> post("total_positive_less_than_five");
			$totalpositivegreaterfive = $this -> input -> post("total_positive_greater_than_five");
			$remarks = $this -> input -> post("remarks");

			//Populate the district lab data
			$district_lab__data -> Week_Ending = $weekending;
			$district_lab__data -> Epiweek = $epiweek;
			$district_lab__data -> District = $district;
			//If the district data already existed, update it. Else, create it
			if ($existing_district_lab_data) {
				//If we are editing a record,
				//retrieve the value in the district row,
				$district_mbelow = $district_lab__data -> Malaria_Below_5;
				//retrieve the value in the district row,
				$district_mabove = $district_lab__data -> Malaria_Above_5;

				//retrieve the value in the district row,
				$district_pbelow = $district_lab__data -> Positive_Below_5;

				//retrieve the value in the district row,
				$district_pabove = $district_lab__data -> Positive_Above_5;

				if ($editing == true) {
					//subtract the old value and add the new value
					$district_mbelow -= $labdata -> Malaria_Below_5;
					$district_mbelow += $totaltestedlessfive;

					//subtract the old value and add the new value
					$district_mabove -= $labdata -> Malaria_Above_5;
					$district_mabove += $totaltestedgreaterfive;

					//subtract the old value and add the new value
					$district_pbelow -= $labdata -> Positive_Below_5;
					$district_pbelow += $totalpositivelessfive;

					//subtract the old value and add the new value
					$district_pabove -= $labdata -> Positive_Above_5;
					$district_pabove += $totalpositivegreaterfive;
				}
				//If it is a new facility record, just add it to the existing values
				else {
					$district_mbelow += $totaltestedlessfive;

					$district_mabove += $totaltestedgreaterfive;

					$district_pbelow += $totalpositivelessfive;

					$district_pabove += $totalpositivegreaterfive;

				}
				$district_lab__data -> clearRelated();
				$district_lab__data -> Malaria_Below_5 = $district_mbelow;
				$district_lab__data -> Malaria_Above_5 = $district_mabove;
				$district_lab__data -> Positive_Below_5 = $district_pbelow;
				$district_lab__data -> Positive_Above_5 = $district_pabove;

			} else {
				$district_lab__data -> Malaria_Below_5 = $totaltestedlessfive;
				$district_lab__data -> Malaria_Above_5 = $totaltestedgreaterfive;
				$district_lab__data -> Positive_Below_5 = $totalpositivelessfive;
				$district_lab__data -> Positive_Above_5 = $totalpositivegreaterfive;
			}

			$district_lab__data -> Reporting_Year = $reporting_year;
			$district_lab__data -> Date_Created = date("Y-m-d");
			$district_lab__data -> Remarks = $remarks;
			$district_lab__data -> save();

			//Populate the facility lab data
			$labdata -> Epiweek = $epiweek;
			$labdata -> Week_Ending = $weekending;
			$labdata -> District = $district;
			$labdata -> Facility = $facility;
			$labdata -> Malaria_Below_5 = $totaltestedlessfive;
			$labdata -> Malaria_Above_5 = $totaltestedgreaterfive;
			$labdata -> Positive_Below_5 = $totalpositivelessfive;
			$labdata -> Positive_Above_5 = $totalpositivegreaterfive;
			$labdata -> Remarks = $remarks;
			$labdata -> Reporting_Year = $reporting_year;
			$labdata -> Date_Created = date("Y-m-d");
			$labdata -> save();
			if ($editing) {
				$data['success_message'] = "You have successfully edited data for <b>" . $labdata -> Facility_Object -> name . "</b>";
				$this -> add($data);
			}
			if (!$editing) {
				$data['success_message'] = "You have successfully added weekly data for <b>" . $labdata -> Facility_Object -> name . "</b>";
				$this -> add($data);
			}
		}
	}//end save

	private function _validate_submission() {
		$this -> form_validation -> set_rules('facility', 'Facility', 'trim|required|min_length[1]|max_length[25]');

		return $this -> form_validation -> run();
	}//end validate_submission

	/*
	 * Function to check if district data for a particular week exists
	 *
	 */
	function check_facility_data($epiweek, $year, $facility) {
		$data = Facility_Surveillance_Data::getFacilityData($epiweek, $year, $facility);
		if ($data -> id) {
			echo "yes";
		} else {
			echo "no";
		}
	}

	public function base_params($data) {
		$data['title'] = "Weekly Data";
		$data['content_view'] = "weekly_data_add_v";
		$data['banner_text'] = "Weekly Data";
		$data['link'] = "submissions_management";
		$data['quick_link'] = "weekly_data_management";
		$this -> load -> view("template", $data);
	}

}//end class
