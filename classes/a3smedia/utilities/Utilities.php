<?php
namespace a3smedia\utilities;

trait Utilities{
	/**
	* Convert a string in hash and produce a new salt value for that hash
	* @author Jeremy Trpka
	* @param string $string: A string to be converted
	* @param string $salt: A salt to use for hashing
	* @return array: hash => The hash value, salt => The salt value
	*/
	public static function hash($string, $salt = ''){
		if(empty($salt)){ //Create new salt
			$salt = md5(uniqid(rand(), true));
		}

		$hash = hash('sha256', $string);
		$hashBrowns = hash('sha256', $salt.$hash); //Mmmmm, hashbrowns. :D

		return array(
			'hash' => $hashBrowns,
			'salt' => $salt
		);
	}

	/**
	* A var_dump() function surrounded in <pre> tags
	* @author: Jeremy Trpka
	* @param: mixed $value: A value to var_dump
	* @return void
	* @todo Should put this in a helper class
	*/
	public static function pre_var_dump($value){
		echo '<pre>';
		var_dump($value);
		echo '</pre>';
	}
}