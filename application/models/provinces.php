<?php
class Provinces extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('provinces');
	}//end setUp

	public function getAll() {
		$query = Doctrine_Query::create() -> select("name") -> from("Provinces");
		$provinceData = $query -> execute();
		return $provinceData;
	}//end getAll

}//end class
?>