<?php
namespace regodesign\store;
use a3smedia\utilities\Database;

class Statuses{
	private $statusID;
	private $statusName;

	public function getID(){
		return $this->statusID;
	}

	public function setID($value){
		$this->statusID = $value;
	}

	public function getName(){
		return $this->statusName;
	}

	public function setName($value){
		$this->statusName = $value;
	}

	/*CRUD*/
	//Should only be READ methods

	public function readStatusByID($value){
		return Database::read(__CLASS__, $value, 'statusID', 'statuses');
	}

	public function readAllStatuses(){
		return Database::readAll(__CLASS__, 'statuses');
	}
}