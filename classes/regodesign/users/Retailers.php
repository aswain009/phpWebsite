<?php
namespace regodesign\users;
use a3smedia\utilities\Database;

class Retailers{
	private $id;
	private $name;
    private $logo;
    private $banner;
    private $color;
	private $markup;
	private $email;
    private $domain;

	public function getID()
    {
		return $this->id;
	}

	public function setID($value)
    {
		$this->id = $value;
	}

	public function getName()
    {
		return $this->name;
	}

	public function setName($value)
    {
		$this->name = $value;
	}

	public function getLogo()
    {
		return $this->logo;
	}

	public function setLogo($value)
    {
		$this->logo = $value;
	}

    public function getBanner()
    {
        return $this->banner;
    }

    public function setBanner($value)
    {
        $this->banner = $value;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($value)
    {
        $this->color = $value;
    }

	public function getMarkup()
    {
		if ($this->markup < 150) $this->markup = 150;
		return number_format($this->markup / 100, 2);
	}

	public function setMarkup($value)
    {
		$this->markup = $value * 100;
	}

	public function getEmail()
    {
		return $this->email;
	}

	public function setEmail($value)
    {
		$this->email = $value;
	}

    public function getSelfConsumer()
    {
        $db = Database::PDO();
        $query = $db->prepare('SELECT * FROM `consumers` WHERE `retailerId` = :id AND `customer_number` = `retailerId` LIMIT 1');
        $query->bindParam(':id', $this->getID());
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS, '\regodesign\users\Consumers');
        return $query->fetch();
    }

	/*CRUD*/

	public function createRetailer()
    {
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'INSERT INTO retailers (`id`, `name`, `logo`, `banner`, `color`, `markup`, `email`, TimeStamp) VALUES(:id, :name, :logo, :banner, :color, :markup, :email, \'\')';

		try {
			$query = $db->prepare($sql);
			$query->bindValue(':id', $this->getID());
			$query->bindValue(':name', $this->getName());
            $query->bindValue(':logo', $this->getLogo());
            $query->bindValue(':banner', $this->getBanner());
            $query->bindValue(':color', $this->getColor());
			$query->bindValue(':markup', $this->markup);
			$query->bindValue(':email', $this->getEmail());
			$query->execute();
		} catch (PDOException $e) {
			echo '<h2>PDO Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		} catch (Exception $e) {
			echo '<h2>Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		}

		return $db->commit();
	}

	public static function readRetailerByID($value)
    {
		return Database::read(__CLASS__, $value, 'id', 'retailers');
	}

    public static function readByDomain($domain)
    {
        return Database::read(__CLASS__, $domain, 'domain', 'retailers');
    }

    public static function readByAffiliateID($value)
    {
        return Database::read(__CLASS__, $value, 'affiliateID', 'retailers');
    }

	public static function readAllRetailers()
    {
		return Database::readAll(__CLASS__, 'retailers');
	}

	public function updateRetailer()
    {
		$db = Database::PDO();
		$db->beginTransaction(); //Wonder if placing this before the two classes may work
		$sql = 'UPDATE retailers SET name = :name, logo = :logo, banner = :banner, color = :color, markup = :markup, email = :email WHERE id = :id';

		try {
			$query = $db->prepare($sql);
			$query->bindValue(':name', $this->getName());
            $query->bindValue(':logo', $this->getLogo());
            $query->bindValue(':banner', $this->getBanner());
            $query->bindValue(':color', $this->getColor());
			$query->bindValue(':markup', $this->markup);
			$query->bindValue(':email', $this->getEmail());
			$query->bindValue(':id', $this->getID());
			$query->execute();
		} catch (PDOException $e) {
			echo '<h2>PDO Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		} catch (Exception $e) {
			echo '<h2>Exception</h2>';
			echo '<p>'.$e->getMessage().'</p>';
			$db->rollBack();
			return false;
		}

		return $db->commit(); //Should succeed with a value of TRUE
	}

	public static function deleteRetailerByID($value)
    {
		return Database::deleteOne($value, 'id', 'retailers');
	}
}