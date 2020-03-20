<?php
namespace regodesign\store;
use a3smedia\utilities\Database;

class OrderProducts{
    public $RecID;
	public $orderID;
	public $productID;
	public $productOrderQuantity;
	public $productOrderShipped;
    public $productOrderInstructions;
    public $productOrderRingSize;
    public $orderTrackingNumber;
    public $specialComments;
    public $shipDate;
    public $shipMethod;

    public function getRecID(){
        return $this->RecID;
    }

    public function setRecID($value){
        $this->RecID = $value;
    }

    public function getOrderID(){
        return $this->orderID;
    }

    public function setOrderID($value){
        $this->orderID = $value;
    }

	public function getProductID(){
		return $this->productID;
	}

	public function setProductID($value){
		$this->productID = $value;
	}

	public function getQuantity(){
        return $this->productOrderQuantity;
    }

    public function setQuantity($value){
        $this->productOrderQuantity = $value;
    }

    public function getInstructions(){
        return $this->productOrderInstructions;
    }

    public function setInstructions($value){
        $this->productOrderInstructions = $value;
    }

    public function getRingSize(){
        return $this->productOrderRingSize;
    }

    public function setRingSize($value){
        $this->productOrderRingSize = $value;
    }

	public function getShipped(){
		return $this->productOrderShipped;
	}

	public function setShipped($value){
		$this->productOrderShipped = $value;
	}

    public function getTracking(){
        if (stripos($this->shipMethod, 'UPS') !== false) {
            return "<a href=\"https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=" . $this->orderTrackingNumber . "\">" . $this->orderTrackingNumber . "</a>";
        }
        if (stripos($this->shipMethod, 'FedEx') !== false) {
            return "<a href=\"https://www.fedex.com/apps/fedextrack/?tracknumbers=" . $this->orderTrackingNumber . "\">" . $this->orderTrackingNumber . "</a>";
        }
        if (empty($this->shipMethod)) {
            return $this->orderTrackingNumber;
        }
        return "<a href=\"https://tools.usps.com/go/TrackConfirmAction.action?tRef=fullpage&tLc=1&text28777=&tLabels=" . $this->orderTrackingNumber . "\">" . $this->orderTrackingNumber . "</a>";
    }

    public function getComments()
    {
        return $this->specialComments;
    }

	/*CRUD*/
	public function createProductOrder(){
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'INSERT INTO productOrders (orderID, productID, productOrderQuantity, productOrderShipped, productOrderInstructions, productOrderRingSize) VALUES (:orderID, :productID, :productOrderQuantity, :productOrderShipped, :productOrderInstructions, :productOrderRingSize)';

		$query = $db->prepare($sql);
		$query->bindValue(':orderID', $this->getOrderID(), \PDO::PARAM_INT);
		$query->bindValue(':productID', $this->getProductID());
		$query->bindValue(':productOrderQuantity', $this->getQuantity(), \PDO::PARAM_INT);
		$query->bindValue(':productOrderShipped', $this->getShipped(), \PDO::PARAM_INT);
        $query->bindValue(':productOrderInstructions', $this->getInstructions());
        $query->bindValue(':productOrderRingSize', $this->getRingSize());

		try {
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

		return $db->commit(); //ID as true value
	}

	public function readProductsByOrder($value) {
		return Database::read(__CLASS__, $value, 'orderID', 'productOrders', true);
	}

	public function updateProductOrder() {
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'UPDATE productOrders SET productOrderQuantity = :productOrderQuantity, productOrderShipped = :productOrderShipped, productOrderInstructions = :productOrderInstructions, productOrderRingSize = :productOrderRingSize WHERE orderID = :orderID AND productID = :productID';

		$query = $db->prepare($sql);
		$query->bindValue(':orderID', $this->getOrderID(), \PDO::PARAM_INT);
		$query->bindValue(':productID', $this->getProductID());
		$query->bindValue(':productOrderQuantity', $this->getQuantity(), \PDO::PARAM_INT);
		$query->bindValue(':productOrderShipped', $this->getShipped(), \PDO::PARAM_INT);
        $query->bindValue(':productOrderInstructions', $this->getInstructions());
        $query->bindValue(':productOrderRingSize', $this->getRingSize());

		try {
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

		return $db->commit(); //ID as true value
	}
}