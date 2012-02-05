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
		$this -> hasOne('Surveillance as Surveillance', array('local' => 'id', 'foreign' => 'District'));
	}//end setUp

	public function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("District")->OrderBy("Name asc");
		$districtData = $query -> execute();
		return $districtData;
	}//end getAll

	public function getDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("id = '$id'");
		$districtData = $query -> execute();
		return $districtData;
	}

	public static function getProvinceDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("Province = '$id'");
		$districtData = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $districtData;
	}

	public static function getDNRDistricts($year, $epiweek) {
		$query = Doctrine_Query::create() -> select("d.Name, d.Province") -> from("district d") -> leftJoin("d.Surveillance s on d.id = s.district and reporting_year = '$year' and epiweek = '$epiweek'") -> where("s.district is null");
		$districts = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $districts;
	}

	public function getName($districtId) {
		$query = Doctrine_Query::create() -> select("Name") -> from("district") -> where(" id = '$districtId'");
		$results = $query -> execute();
		return $results[0];
	}

	public function getNameAndId($provinceId) {
		$query = Doctrine_Query::create() -> select("*") -> from("district") -> where("Province = '$provinceId'");
		$results = $query -> execute();
		return $results;
	}

}//end class
?>