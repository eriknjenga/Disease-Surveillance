<?php
class Districts extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('Province', 'int', 14);
		$this -> hasColumn('Comment', 'varchar', 32);
		$this -> hasColumn('Flag', 'int', 32);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('districts');
		$this -> hasOne('Province as Province_Id', array('local' => 'Province', 'foreign' => 'ID'));
	}//end setUp

	public function getAll() {
		$query = Doctrine_Query::create() -> select("ID, name, province, flag") -> from("Districts");
		$districtData = $query -> execute();
		return $districtData;
	}//end getAll

}//end class
?>