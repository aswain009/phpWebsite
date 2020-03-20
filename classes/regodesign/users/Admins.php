<?php
namespace regodesign\users;
use a3smedia\utilities\Database;

class Admins{
	private $adminID;
	private $adminEmail;
	private $adminPassword;
	private $adminSalt;

	public function getID(){
		return $this->adminID;
	}

	public function setID($value){
		$this->adminID = $value;
	}

	public function getEmail(){
		return $this->adminEmail;
	}

	public function setEmail($value){
		$this->adminEmail = $value;
	}

	public function getPassword(){
		return $this->adminPassword;
	}

	public function setPassword($value){
		$this->adminPassword = $value;
	}

	public function getSalt(){
		return $this->adminSalt;
	}

	public function setSalt($value){
		$this->adminSalt = $value;
	}

	/**
	* Create an admin row from a defined admin object
	* @return bool
	*/
	private function createAdmin(){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'INSERT INTO admins (adminEmail, adminPassword, adminSalt) VALUES(:adminEmail, :adminPassword, :adminSalt)';

		try{
			$query = $db->prepare($sql);
			$query->bindValue(':adminEmail', $this->getEmail());
			$query->bindValue(':adminPassword', $this->getPassword());
			$query->bindValue(':adminSalt', $this->getSalt());
			$query->execute();
		} catch(PDOException $e){
			echo '<h2>PDO Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		} catch(Exception $e){
			echo '<h2>Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		}

		$return = $db->lastInsertId();
		$db->commit();

		return $return;
	}

	public function readAdminByEmail($email){
		return Database::read(__CLASS__, $email, 'adminEmail', 'admins');
	}

	public function readAdminByID($id){
		return Database::read(__CLASS__, $id, 'adminID', 'admins');
	}

	public function readAllAdmins(){
		return Database::readAll(__CLASS__, 'admins');
	}

	private function updateAdmin(){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'UPDATE admins SET adminEmail = :adminEmail, adminPassword = :adminPassword, adminSalt = :adminSalt WHERE adminID = :adminID';

		try{
			$query = $db->prepare($sql);
			$query->bindValue(':adminEmail', $this->getEmail());
			$query->bindValue(':adminPassword', $this->getPassword());
			$query->bindValue(':adminSalt', $this->getSalt());
			$query->bindvalue(':adminID', $this->getID(), \PDO::PARAM_INT);
			$query->execute();
		} catch(PDOException $e){
			echo '<h2>PDO Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		} catch(Exception $e){
			echo '<h2>Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		}

		$db->commit(); //Should succeed with a value of TRUE

		return $this->getID();
	}

	public function deleteAdminByID($id){
		return Database::deleteOne($id, 'adminID', 'admins');
	}

	public function save(){
		if($this->getID()){
			return $this->updateAdmin();
		} else {
			return $this->createAdmin();
		}
	}
}