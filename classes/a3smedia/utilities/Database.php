<?php
namespace a3smedia\utilities;
use \PDO;

class Database{
    /**
     * The database that the code is referencing is the RegoMain database accessed through phpAdmin.
     *To log into this server you can use the $user and the $pass defined below or you can use the
     *Linux server log in information available in the IT office.
     */
	use Utilities;
	private static $PDO;

	/**
	* Creates a PDO object from our static fields
	* @author Jeffery Jenson
	*/
	private function __construct(){
		$host = 'localhost';
		$dbname = 'RegoMain';
		$user = 'Nick';
		$pass = '#n1ckw0rk54r3g0!';

		try{
			Database::$PDO = new PDO("mysql:host=".$host.";dbname=".$dbname.";charset=utf8", $user, $pass);
			Database::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			Database::$PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);	
		} catch (PDOException $e){
			echo '<h1>PDO Exception</h1>';
			echo '<p>'.$e->getMessage().'</p>';
		} catch (Exception $e){
			echo '<h1>Exception</h1>';
			echo '<p>'.$e->getMessage().'</p>';
		}
		
	}

	/** 
	* Returns a PDO object which has been created already. If 
	* a PDO object hasn't yet been created, create a new one 
	* that can be used again and return that. 
	* 
	* @author Jeffery Jenson
	* @return PDO
	*/
	public static function PDO(){
		if( ! isset(Database::$PDO)){
			new Database();
		}

		return Database::$PDO;
	}

	/**
	* Get one or more rows from a single table
	* @author Jeremy Trpka
	* @param string $class: The name of the class for the FETCH_CLASS
	* @param string $value: The value to look for in a column
	* @param string $column: The name of the table column to search for value
	* @param string $table: The name of the table to search for value
	* @param bool $multi: If this is expected to get one or more rows then set to true otherwise defaults at false for one row only
	* @return array: A single array of a row
	* @todo Add PDO Exceptions
	*/
	public static function read($class, $value, $column, $table, $multi = false){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'SELECT * FROM '.$table.' WHERE '.$column.' = :value';

		try{
			$query = $db->prepare($sql);
			$query->bindValue(':value', $value);
			$query->execute();
		} catch(Exception $e){
			var_dump($e->getMessage());
			$db->rollBack();
		}
		
		$db->commit();
		 //Since the $class would be an illegal type (it expects 2nd param to be a long type), use setFetchMode to initialize
		$query->setFetchMode(\PDO::FETCH_CLASS, $class);

		//If true, it will output more than one object otherwise a single row
		if($multi){
			return $query->fetchAll();
		} else {
			return $query->fetch();
		}
		
	}

	/**
	* Get all rows from a single table
	* @author Jeremy Trpka
	* @param string $class: The name of the class for the FETCH_CLASS
	* @param string $table: The name of the table
	* @return array: An associate array (FETCH_ASSOC) of all rows in the table
	* @todo Add PDO Exceptions
	*/
	public static function readAll($class, $table){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'SELECT * FROM '.$table;

		try{
			$query = $db->query($sql, \PDO::FETCH_CLASS, $class);
		} catch(Exception $e){
			var_dump($e->getMessage());
			$db->rollBack();
		}		
		
		$db->commit();
		return $query;
	}

	/**
	* Delete one row from a single table
	* Advise not to do a Delete All version due to the catastrophic nature
	* @author Jeremy Trpka
	* @param string $value: The value to look for in a column
	* @param string $column: The name of the table column to search for value
	* @param string $table: The name of the table to search for value
	* @return bool
	* @todo Add PDO Exceptions
	*/
	public static function deleteOne($value, $column, $table){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'DELETE FROM '.$table.' WHERE '.$column.' = :value';

		try{
			$query = $db->prepare($sql);
			$query->bindValue(':value', $value);
			$query->execute();
		} catch(Exception $e){
			var_dump($e->getMessage());
			$db->rollBack();
		}
		
		return $db->commit();
	}

	/**
	* Check for unique
	* @author Jeremy Trpka
	* @param string $value: The value to look for in a column
	* @param string $column: The name of the table column to search for value
	* @param string $table: The name of the table to search for value
	* @return bool
	* @todo Add PDO Exceptions
	*/
	public static function uniqueCheck($value, $column, $table){
		$db = Database::PDO();
		$db->beginTransaction();

		$sql = 'SELECT * FROM '.$table.' WHERE '.$column.' = :value';
		$query = $db->prepare($sql);
		$query->bindValue(':value', $value);



		try{
			$query->execute();
		} catch(Exception $e){
			var_dump($e->getMessage());
			$db->rollBack();
		}



		$db->commit();
		if($query->rowCount() > 0){
			return false; //It is not unique
		} else {
			return true; //It is unique
		}
	}

}