<?php
class District extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('Province', 'int', 14);
		$this -> hasColumn('Comment', 'varchar', 32);
		$this -> hasColumn('Flag', 'int', 32);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('districts');
		$this -> hasOne('Province as Province_Object', array('local' => 'Province', 'foreign' => 'id'));
	}//end setUp

	public function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("District");
		$districtData = $query -> execute();
		return $districtData;
	}//end getAll

	public function getDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("District")->where("id = '$id'");
		$districtData = $query -> execute();
		return $districtData;
	}

	public static function getProvinceDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("Province = '$id'");
		$districtData = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $districtData;
	}

}//end class
?>