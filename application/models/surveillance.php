<?php
class Surveillance extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('Disease', 'varchar', 32);
		$this -> hasColumn('Lmcase', 'varchar', 32);
		$this -> hasColumn('Lfcase', 'varchar', 32);
		$this -> hasColumn('Lmdeath', 'varchar', 32);
		$this -> hasColumn('Lfdeath', 'varchar', 32);
		$this -> hasColumn('Date_Created', 'varchar', 32);
		$this -> hasColumn('Created_By', 'varchar', 32);
		$this -> hasColumn('Date_Modified', 'varchar', 20);
		$this -> hasColumn('Modified_By', 'varchar', 32);
		$this -> hasColumn('Flag', 'varchar', 1);
		$this -> hasColumn('Epiweek', 'varchar', 4);
		$this -> hasColumn('Submitted', 'varchar', 15);
		$this -> hasColumn('Expected', 'varchar', 15);
		$this -> hasColumn('District', 'varchar', 15);
		$this -> hasColumn('Facility', 'varchar', 15);
		$this -> hasColumn('Dn', 'varchar', 100);
		$this -> hasColumn('Ds', 'varchar', 100);
		$this -> hasColumn('Week_Ending', 'varchar', 20);
		$this -> hasColumn('Gmcase', 'varchar', 32);
		$this -> hasColumn('Gfcase', 'varchar', 32);
		$this -> hasColumn('Gmdeath', 'varchar', 32);
		$this -> hasColumn('Gfdeath', 'varchar', 32);
		$this -> hasColumn('Reported_By', 'varchar', 32);
		$this -> hasColumn('Designation', 'varchar', 32);
		$this -> hasColumn('Date_Reported', 'varchar', 20);
		$this -> hasColumn('Reporting_Year', 'varchar', 5);
	}

	public function setUp() {
		$this -> setTableName('surveillance');
		$this -> hasOne('Disease as Disease_Object', array('local' => 'Disease', 'foreign' => 'id'));
		$this -> hasOne('District as District_Object', array('local' => 'District', 'foreign' => 'id'));
	}

	public static function getWeekEnding($year, $epiweek) {
		$query = Doctrine_Query::create() -> select("Week_Ending") -> from("surveillance") -> where("Reporting_Year = '$year' and epiweek = '$epiweek'")->limit(1);
		$week_ending = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $week_ending[0]['Week_Ending'];
	}

	public static function getRawData($year, $start_week, $end_week) {
		$query = Doctrine_Query::create() -> select("*") -> from("surveillance") -> where("Reporting_Year = '$year' and epiweek between '$start_week' and '$end_week'");
		$surveillance = $query -> execute();
		return $surveillance;
	}

	public static function getWeeklySummaries($year, $epiweek, $district) {
		$query = Doctrine_Query::create() -> select("Submitted, Expected, Disease, Lfcase+Lmcase+Gfcase+Gmcase as Cases, Lfdeath+Lmdeath+Gfdeath+Gmdeath as Deaths") -> from("surveillance") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and District = '$district'") -> OrderBy("Disease asc");
		$surveillance = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $surveillance;
	}

	public static function getWeeklyDiseaseSummaries($year, $epiweek, $disease) {
		$query = Doctrine_Query::create() -> select("sum(Lfcase+Lmcase+Gfcase+Gmcase) as Cases, sum(Lfdeath+Lmdeath+Gfdeath+Gmdeath) as Deaths") -> from("surveillance") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and Disease = '$disease'");
		$surveillance = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $surveillance[0];
	}

	public static function getAnnualDiseaseSummaries($year, $disease) {
		$query = Doctrine_Query::create() -> select("sum(Lfcase+Lmcase+Gfcase+Gmcase) as Cases, sum(Lfdeath+Lmdeath+Gfdeath+Gmdeath) as Deaths") -> from("surveillance") -> where("Reporting_Year = '$year' and Disease = '$disease'");
		$surveillance = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $surveillance[0];
	}

}
