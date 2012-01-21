<?php
class Lab_Weekly extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Epiweek', 'int', 32);
		$this -> hasColumn('Weekending', 'varchar', 100);
		$this -> hasColumn('District', 'int', 32);
		$this -> hasColumn('Facility', 'int', 11);
		$this -> hasColumn('Malaria_below_5', 'int', 32);
		$this -> hasColumn('Malaria_above_5', 'int', 32);
		$this -> hasColumn('Positive_below_5', 'int', 32);
		$this -> hasColumn('Positive_above_5', 'int', 32);
		$this -> hasColumn('Datecreated', 'varchar', 32);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('lab_weekly');
		$this -> hasOne('District as District_Id', array('local' => 'District', 'foreign' => 'ID'));
		//$this -> hasOne('Facility as Facility_Id', array('local' => 'Facility', 'foreign' => 'Facility code'));
	}//end setUp

	public function getLabData() {
		$query = Doctrine_Query::create() -> select("Epiweek, Weekending, District, Malaria_below_5, Malaria_above_5, Positive_below_5, Positive_above_5") -> from("Lab_Weekly");
		$labData = $query -> execute();
		return $labData;
	}//end getLabData

}//end class
?>