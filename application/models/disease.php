<?php
class Disease extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('Type', 'varchar', 32);
		$this -> hasColumn('Description', 'text');
		$this -> hasColumn('Flag', 'text');
	}

	public function setUp() {
		$this -> setTableName('diseases');
	}

	public function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("Disease");
		$diseases = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $diseases;
	}

	public function getAllObjects() {
		$query = Doctrine_Query::create() -> select("*") -> from("Disease");
		$diseases = $query -> execute();
		return $diseases;
	}

	public function getName($diseaseId) {
		$query = Doctrine_Query::create() -> select("name") -> from("disease") -> where("id ='$diseaseId'");
		$results = $query -> execute();
		return $results[0];
	}

}
