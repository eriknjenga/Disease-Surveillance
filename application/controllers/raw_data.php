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

	public function export() {
		$surveillance_data_requested = $this -> input -> post('surveillance');
		$malaria_data_requested = $this -> input -> post('malaria');
		$year = $this -> input -> post('year_from');
		$start_week = $this -> input -> post('epiweek_from');
		$end_week = $this -> input -> post('epiweek_to');
		if (strlen($surveillance_data_requested)>0) {
			$surveillance_data = Surveillance::getRawData($year, $start_week, $end_week);
			$excell_headers = "Disease\t District Name\t Province Name\t Week Number\t Week Ending\t Male Cases (Less Than 5)\t Female Cases (Less Than 5)\t Male Cases (Greater Than 5)\t Female Cases (Greater Than 5)\t Total Cases\t Male Deaths (Less Than 5)\t Female Deaths (Less Than 5)\t Male Deaths (Greater Than 5)\t Female Deaths (Greater Than 5)\t Total Deaths\tYear\t Reported By\t Designation\t Date Reported\t\n";
			$excell_data = "";
			foreach ($surveillance_data as $result_set) {
				$excell_data .= $result_set -> Disease_Object -> Name . "\t" . $result_set -> District_Object -> Name . "\t" . $result_set -> District_Object -> Province_Object -> Name . "\t" . $result_set -> Epiweek . "\t" . $result_set -> Week_Ending . "\t" . $result_set -> Lmcase . "\t" . $result_set -> Lfcase . "\t" . $result_set -> Gmcase . "\t" . $result_set -> Gfcase . "\t" . ($result_set -> Lmcase + $result_set -> Lfcase + $result_set -> Gmcase + $result_set -> Gfcase) . "\t" . $result_set -> Lmdeath . "\t" . $result_set -> Lfdeath . "\t" . $result_set -> Gmdeath . "\t" . $result_set -> Gfdeath . "\t" . ($result_set -> Lmdeath + $result_set -> Lfdeath + $result_set -> Gmdeath + $result_set -> Gfdeath) . "\t" . $result_set -> Reporting_Year . "\t" . $result_set -> Reported_By . "\t" . $result_set -> Designation . "\t" . $result_set -> Date_Reported . "\t";
				$excell_data .= "\n";
			}
			header("Content-type: application/vnd.ms-excel; name='excel'");
			header("Content-Disposition: filename=Surveillance_Data (" . $year . " epiweek " . $start_week . " to epiweek " . $end_week . ").xls");
			// Fix for crappy IE bug in download.
			header("Pragma: ");
			header("Cache-Control: ");
			echo $excell_headers . $excell_data;
		} else if (strlen($malaria_data_requested)>0) {
			$malaria_data = Lab_Weekly::getRawData($year, $start_week, $end_week);
			$excell_headers = "District\t Province\t Week Number\t Week Ending\t Tested (Less Than 5)\t Tested (Greater Than 5)\t Total Tested\t Positive (Less Than 5)\t Positive (Greater Than 5)\t Total Positive\t\n";
			$excell_data = "";
			foreach ($malaria_data as $result_set) {
				$excell_data .= $result_set -> District_Object -> Name . "\t" . $result_set -> District_Object -> Province_Object -> Name . "\t" . $result_set -> Epiweek . "\t" . $result_set -> Week_Ending . "\t" . $result_set -> Malaria_Below_5 . "\t" . $result_set -> Malaria_Above_5 . "\t" . ($result_set -> Malaria_Below_5 + $result_set -> Malaria_Above_5) . "\t" . $result_set -> Positive_Below_5 . "\t" . $result_set -> Positive_Above_5 . "\t" . ($result_set -> Positive_Below_5 + $result_set -> Positive_Above_5) . "\t";
				$excell_data .= "\n";
			}
			header("Content-type: application/vnd.ms-excel; name='excel'");
			header("Content-Disposition: filename=Malaria_Test_Data (" . $_POST['year_from'] . " epiweek " . $_POST['epiweek_from'] . " to epiweek " . $_POST['epiweek_to'] . ").xls");
			// Fix for crappy IE bug in download.
			header("Pragma: ");
			header("Cache-Control: ");
			echo $excell_headers . $excell_data;
		}
	}

	public function base_params($data) {
		$data['styles'] = array("jquery-ui.css");
		$data['scripts'] = array("jquery-ui.js");
		$data['quick_link'] = "raw_data";
		$data['title'] = "System Reports";
		$data['report_view'] = "raw_data_v";
		$data['content_view'] = "reports_v";
		$data['banner_text'] = "Raw Data";
		$data['link'] = "reports_management";

		$this -> load -> view('template', $data);
	}

}
