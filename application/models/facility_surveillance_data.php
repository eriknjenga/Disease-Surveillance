<?php
class Facility_Surveillance_Data extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('Disease', 'varchar', 32);
		$this -> hasColumn('Lcase', 'varchar', 32);
		$this -> hasColumn('Ldeath', 'varchar', 32);
		$this -> hasColumn('Gcase', 'varchar', 32);
		$this -> hasColumn('Gdeath', 'varchar', 32);
		$this -> hasColumn('Date_Created', 'varchar', 32);
		$this -> hasColumn('Created_By', 'varchar', 32);
		$this -> hasColumn('Epiweek', 'varchar', 4);
		$this -> hasColumn('District', 'varchar', 15);
		$this -> hasColumn('Facility', 'varchar', 15);
		$this -> hasColumn('Week_Ending', 'varchar', 20);
		$this -> hasColumn('Reported_By', 'varchar', 32);
		$this -> hasColumn('Designation', 'varchar', 32);
		$this -> hasColumn('Date_Reported', 'varchar', 32);
		$this -> hasColumn('Reporting_Year', 'varchar', 5);
		$this -> hasColumn('Total_Diseases', 'varchar', 5);
	}

	public function setUp() {
		$this -> setTableName('facility_surveillance_data');
		$this -> hasOne('Disease as Disease_Object', array('local' => 'Disease', 'foreign' => 'id'));
		$this -> hasOne('Users as Record_Creator', array('local' => 'Created_By', 'foreign' => 'id'));
		$this -> hasOne('District as District_Object', array('local' => 'District', 'foreign' => 'id'));
		$this -> hasOne('Facilities as Facility_Object', array('local' => 'Facility', 'foreign' => 'facilitycode'));
	}

	public static function getWeekEnding($year, $epiweek) {
		$query = Doctrine_Query::create() -> select("Week_Ending") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$year' and epiweek = '$epiweek'") -> limit(1);
		$week_ending = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		if (isset($week_ending[0])) {
			return $week_ending[0]['Week_Ending'];
		} else {
			return null;
		}

	}

	public static function getRawData($year, $start_week, $end_week) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$year' and abs(epiweek) between '$start_week' and '$end_week'") -> orderBy("abs(epiweek)");
		$surveillance = $query -> execute();
		return $surveillance;
	}

	public static function getRawDataArray($year, $start_week, $end_week, $district) {
		$query = Doctrine_Query::create() -> select("s.*, s.Disease_Object.Name as Disease_Name, f.name as Facility_Name") -> from("Facility_Surveillance_Data s, s.Facility_Object f") -> where("Reporting_Year = '$year' and abs(Epiweek) between '$start_week' and '$end_week' and District = '$district'") -> OrderBy("abs(Epiweek) asc");
		$surveillance = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $surveillance;
	}

	public static function getWeeklySummaries($year, $epiweek, $district) {
		$query = Doctrine_Query::create() -> select("Disease, Lcase+Gcase as Cases, Ldeath+Gdeath as Deaths") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and District = '$district'") -> OrderBy("abs(Disease) asc");
		$surveillance = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $surveillance;
	}

	public function getLastEpiweek($currentyear) {
		$query = Doctrine_Query::create() -> select("MAX(Epiweek) AS epiweek") -> from("Facility_Surveillance_Data") -> where("Reporting_Year='$currentyear'");
		$result = $query -> execute();
		return $result[0];
	}

	public function getYears() {
		$query = Doctrine_Query::create() -> select("DISTINCT Reporting_Year as filteryear") -> from("Facility_Surveillance_Data") -> orderBy("Reporting_Year DESC");
		$result = $query -> execute();
		return $result;
	}

	public function getPrediction() {
		$year_query = Doctrine_Query::create() -> select("Reporting_Year") -> from("Facility_Surveillance_Data") -> orderBy("Reporting_Year DESC") -> limit(1);
		$year_result = $year_query -> execute();
		$last_year = $year_result[0] -> Reporting_Year;
		$week_query = Doctrine_Query::create() -> select("Epiweek,Week_Ending") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$last_year'") -> orderBy("abs(Epiweek) DESC") -> limit(1);
		$week_result = $week_query -> execute();
		$last_epiweek = $week_result[0] -> Epiweek;
		$last_weekending = $week_result[0] -> Week_Ending;
		$result[0] = $last_year;
		$result[1] = $last_epiweek;
		$result[2] = $last_weekending;
		return $result;
	}

	public function getFacilityData($epiweek, $year, $facility) {
		$query = Doctrine_Query::create() -> select("id") -> from("Facility_Surveillance_Data") -> where("Reporting_Year='$year' and Epiweek='$epiweek' and Facility = '$facility'") -> limit(1);
		$result = $query -> execute();
		return $result[0];
	}

	public function getSurveillanceData($epiweek, $reporting_year, $facility) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("Reporting_Year='$reporting_year' and Epiweek='$epiweek' and Facility = '$facility'");
		$result = $query -> execute();
		return $result;
	}

	public function getSurveillance($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("id = '$id'");
		$result = $query -> execute();
		return $result[0];
	}

	public function getDuplicates($year, $epiweek) {
		$total_diseases = Disease::getTotal();
		$query = Doctrine_Query::create() -> select("Facility, Reporting_Year, Week_Ending, Epiweek, count(id) as Records") -> from("Facility_Surveillance_Data") -> where("epiweek = '$epiweek' and Reporting_Year = '$year'") -> groupBy("Facility") -> having("Records > '$total_diseases'");
		$result = $query -> execute();
		return $result;
	}

	public function getSurveillanceDataArray($epiweek, $reporting_year, $facility) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("Reporting_Year='$reporting_year' and Epiweek='$epiweek' and Facility = '$facility'");
		$result = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $result;
	}

	public function getSurveillanceDataRange($first_surveillance_id, $last_surveillance_id) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("id between '$first_surveillance_id' and $last_surveillance_id");
		$result = $query -> execute();
		return $result;
	}

	public function getReports($year, $epiweek, $district) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and district = '$district'") -> groupBy("Facility");
		$result = $query -> execute();
		return $result;
	}

	public function getRankedReports($year, $epiweek, $disease,$offset,$items) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and disease = '$disease'") -> orderBy("abs(Gcase+Lcase) desc, abs(Gdeath+Ldeath) desc")-> offset($offset) -> limit($items);;
		$result = $query -> execute();
		return $result;
	}

	public function getTotalRankedReports($year, $epiweek, $disease) {
		$query = Doctrine_Query::create() -> select("count(*) as Total_Reports") -> from("Facility_Surveillance_Data") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and disease = '$disease'");
		$result = $query -> execute();
		return $result[0]->Total_Reports;
	}

	public function getFacilityDiseaseData($epiweek, $year, $facility, $disease) {
		$query = Doctrine_Query::create() -> select("id") -> from("Facility_Surveillance_Data") -> where("Reporting_Year='$year' and Epiweek='$epiweek' and Facility = '$facility' and Disease = '$disease'") -> limit(1);
		$result = $query -> execute();
		return $result[0];
	}

	public function getSubmittedFacilities($epiweek, $year) {
		$query = Doctrine_Query::create() -> select("count(DISTINCT Facility) as reported_facilities") -> from("Facility_Surveillance_Data") -> where("Reporting_Year='$year' and Epiweek='$epiweek'");
		$result = $query -> execute();
		return $result[0] -> reported_facilities;
	}

}
