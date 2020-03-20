<?php
namespace regodesign\users;
use a3smedia\utilities\Database;

class Consumers{
	private $id;
    private $customer_number;
	private $retailerId;
	private $type;
	private $username;
	private $password;
    private $adminPassword;
    private $canUpdateAdminPassword;
	private $fullName;
	private $addressStreet;
	private $addressSuite;
	private $addressCity;
	private $addressState;
	private $addressZip;
	private $phone;
    private $disclaimer;

	public function getID(){
        return $this->id;
    }

    public function acceptedDisclaimer()
    {
        return $this->disclaimer;
    }

    public function acceptDisclaimer()
    {
        $this->disclaimer = true;
    }

    public function setID($value){
        $this->id = $value;
    }

    public function getCustomerID(){
        return $this->customer_number;
    }

    public function setCustomerID($value){
        $this->customer_number = $value;
    }

	public function getRetailerID(){
		return $this->retailerId;
	}

	public function setRetailerID($value){
		$this->retailerId = $value;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($value){
		$this->type = $value;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setUsername($value){
		$this->username = $value;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($value){
		$this->password = $value;
	}

    public function getAdminPassword(){
        return $this->adminPassword;
    }

    public function setAdminPassword($value){
        if ($this->canUpdateAdminPassword) {
            $this->adminPassword = $value;
            $this->canUpdateAdminPassword = false;
        }
    }

    public function canUpdateAdminPassword() {
        return $this->canUpdateAdminPassword;
    }

	public function getFullName(){
		return $this->fullName;
	}

	public function setFullName($value){
		$this->fullName = $value;
	}

	public function getAddressStreet(){
		return $this->addressStreet;
	}

	public function setAddressStreet($value){
		$this->addressStreet = $value;
	}

	public function getAddressSuite(){
		return $this->addressSuite;
	}

	public function setAddressSuite($value){
		$this->addressSuite = $value;
	}

	public function getAddressCity(){
		return $this->addressCity;
	}

	public function setAddressCity($value){
		$this->addressCity = $value;
	}

	public function getAddressState(){
		return $this->addressState;
	}

	public function setAddressState($value){
		$this->addressState = $value;
	}

	public function getAddressZip(){
		return $this->addressZip;
	}

	public function setAddressZip($value){
		$this->addressZip = $value;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($value){
		$this->phone = $value;
	}

	/*CRUD*/

	public function createConsumer(){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'INSERT INTO consumers (retailerId, type, username, password, adminPassword, fullName, addressStreet, addressSuite, addressCity, addressState, addressZip, phone, `TimeStamp`) VALUES(:retailerId, :type, :username, :password, :adminPassword, :fullName, :addressStreet, :addressSuite, :addressCity, :addressState, :addressZip, :phone, :timestamp)';

		try{
			$query = $db->prepare($sql);
			$query->bindValue(':retailerId', $this->getRetailerID());
			$query->bindValue(':type', $this->getType());
			$query->bindValue(':username', $this->getUsername());
            $query->bindValue(':password', $this->getPassword());
            $query->bindValue(':adminPassword', $this->getAdminPassword());
			$query->bindValue(':fullName', $this->getFullName());
			$query->bindValue(':addressStreet', $this->getAddressStreet());
			$query->bindValue(':addressSuite', $this->getAddressSuite());
			$query->bindValue(':addressCity', $this->getAddressCity());
			$query->bindValue(':addressState', $this->getAddressState());
			$query->bindValue(':addressZip', $this->getAddressZip());
            $query->bindValue(':phone', $this->getPhone());
            $query->bindValue(':timestamp', date('Y-m-d H:i:s'));
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

		return $db->commit(); //Should succeed with a value of TRUE
	}

    public static function readConsumerByID($value){
        return Database::read(__CLASS__, $value, 'id', 'consumers');
    }

    public static function readConsumerByNumber($value){
        return Database::read(__CLASS__, $value, 'customer_number', 'consumers');
    }

	public static function readConsumerByUsername($value){
		return Database::read(__CLASS__, $value, 'username', 'consumers');
	}

	public static function readConsumersByRetailer($value){
		return Database::read(__CLASS__, $value, 'retailerId', 'consumers', true);
	}

	public static function readAllConsumers(){
		return Database::readAll(__CLASS__, 'consumers');
	}

	public function updateConsumer(){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'UPDATE consumers SET retailerId = :retailerId, type = :type, username = :username, password = :password, adminPassword = :adminPassword, canUpdateAdminPassword = :canUpdateAdminPassword, fullName = :fullName, addressStreet = :addressStreet, addressSuite = :addressSuite, addressCity = :addressCity, addressState = :addressState, addressZip = :addressZip, phone = :phone, disclaimer = :disclaimer, `TimeStamp` = :timestamp WHERE id = :id';

		try{
			$query = $db->prepare($sql);
			$query->bindValue(':retailerId', $this->getRetailerID());
			$query->bindValue(':type', $this->getType());
			$query->bindValue(':username', $this->getUsername());
			$query->bindValue(':password', $this->getPassword());
            $query->bindValue(':adminPassword', $this->getAdminPassword());
            $query->bindValue(':canUpdateAdminPassword', $this->canUpdateAdminPassword());
			$query->bindValue(':fullName', $this->getFullName());
			$query->bindValue(':addressStreet', $this->getAddressStreet());
			$query->bindValue(':addressSuite', $this->getAddressSuite());
			$query->bindValue(':addressCity', $this->getAddressCity());
			$query->bindValue(':addressState', $this->getAddressState());
			$query->bindValue(':addressZip', $this->getAddressZip());
            $query->bindValue(':phone', $this->getPhone());
            $query->bindValue(':disclaimer', $this->disclaimer);
			$query->bindValue(':timestamp', date('Y-m-d H:i:s'));

			$query->bindValue(':id', $this->getID());
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

		return $db->commit(); //Should succeed with a value of TRUE
	}

	public function deleteConsumerByID($value){
		return Database::deleteOne($value, 'id', 'consumers');
	}
}