<?php
namespace regodesign\store;

use a3smedia\utilities\Database;

class Orders
{
    private $id;
    private $customerId;
    private $date_created;
    private $quantity;
    private $shipped;
    private $status;
    private $trackingNo;
    private $name;
    private $address;
    private $city;
    private $state;
    private $zip;
    private $phone;
    private $email;
    private $shippingInstructions;
    private $po_number;
    public $takenBy;

    public function getID()
    {
        return $this->id;
    }

    public function setID($value)
    {
        $this->id = $value;
    }

    public function getCustomerID()
    {
        return $this->customerId;
    }

    public function setCustomerID($value)
    {
        $this->customerId = $value;
    }

    public function getDate()
    {
        return $this->date_created;
    }

    public function setDate($value)
    {
        $this->date_created = $value;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($value)
    {
        $this->quantity = $value;
    }

    public function getShipped()
    {
        return $this->shipped;
    }

    public function setShipped($value)
    {
        $this->shipped = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getTrackingNo()
    {
        return $this->trackingNo;
    }

    public function setTrackingNo($value)
    {
        $this->trackingNo = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($value)
    {
        $this->address = $value;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($value)
    {
        $this->city = $value;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($value)
    {
        $this->state = $value;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($value)
    {
        $this->zip = $value;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($value)
    {
        $this->phone = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getInstructions()
    {
        return $this->shippingInstructions;
    }

    public function setInstructions($value='')
    {
        $this->shippingInstructions = $value;
    }

    public function getPONumber()
    {
        return $this->po_number;
    }

    public function setPONumber($value='')
    {
        $this->po_number = $value;
    }

    /*CRUD*/
    private function createOrder()
    {
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'INSERT INTO orders (customerId, date_created, quantity, shipped, status, trackingNo, name, address, city, state, zip, phone, email, instructions, po_number) VALUES (:customerId, :date_created, :quantity, :shipped, :status, :trackingNo, :name, :address, :city, :state, :zip, :phone, :email, :instructions, :po_number)';

        $query = $db->prepare($sql);
        $query->bindValue(':customerId', $this->getCustomerID(), \PDO::PARAM_INT);
        $query->bindValue(':date_created', $this->getDate());
        $query->bindValue(':quantity', $this->getQuantity(), \PDO::PARAM_INT);
        $query->bindValue(':shipped', $this->getShipped(), \PDO::PARAM_INT);
        $query->bindValue(':status', $this->getStatus(), \PDO::PARAM_INT);
        $query->bindValue(':trackingNo', $this->getTrackingNo());
        $query->bindValue(':name', $this->getName());
        $query->bindValue(':address', $this->getAddress());
        $query->bindValue(':city', $this->getCity());
        $query->bindValue(':state', $this->getState());
        $query->bindValue(':zip', $this->getZip());
        $query->bindValue(':phone', $this->getPhone());
        $query->bindValue(':email', $this->getEmail());
        $query->bindValue(':instructions', $this->getInstructions());
        $query->bindValue(':po_number', $this->getPONumber());

        try {
            $query->execute();
        } catch(PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            $db->rollBack();
            return false;
        } catch(Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            $db->rollBack();
            return false;
        }

        $return = $db->lastInsertId(); //Must do this before commit()
        $this->setID($return);

        $db->commit();

        return $return; //ID as true value
    }

    public function readOrderByID($value)
    {
        return Database::read(__CLASS__, $value, 'id', 'final_orders');
    }

    public function readOrdersByConsumer($value)
    {
        // return Database::read(__CLASS__, $value, 'customerId', 'final_orders', true);
        $db = Database::PDO();
        $query = $db->prepare("SELECT * FROM final_orders WHERE customerId = :customer ORDER BY date_created DESC");
        $query->bindValue(":customer", $value);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        return $query->fetchAll();
    }

    public function readAllOrders()
    {
        return Database::readAll(__CLASS__, 'final_orders');
    }

    private function updateOrder()
    {
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'UPDATE orders SET customerId = :customerId, date_created = :date_created, quantity = :quantity, shipped = :shipped, status = :status, trackingNo = :trackingNo, name = :name, address = :address, city = :city, state = :state, zip = :zip, phone = :phone, email = :email, instructions = :instructions, po_number = :po_number WHERE id = :id';

        $query = $db->prepare($sql);
        $query->bindValue(':customerId', $this->getCustomerID(), \PDO::PARAM_INT);
        $query->bindValue(':date_created', $this->getDate());
        $query->bindValue(':quantity', $this->getQuantity(), \PDO::PARAM_INT);
        $query->bindValue(':shipped', $this->getShipped(), \PDO::PARAM_INT);
        $query->bindValue(':status', $this->getStatus(), \PDO::PARAM_INT);
        $query->bindValue(':trackingNo', $this->getTrackingNo());
        $query->bindValue(':name', $this->getName());
        $query->bindValue(':address', $this->getAddress());
        $query->bindValue(':city', $this->getCity());
        $query->bindValue(':state', $this->getState());
        $query->bindValue(':zip', $this->getZip());
        $query->bindValue(':phone', $this->getPhone());
        $query->bindValue(':email', $this->getEmail());
        $query->bindValue(':instructions', $this->getInstructions());
        $query->bindValue(':po_number', $this->getPONumber());
        $query->bindValue(':id', $this->getID(), \PDO::PARAM_INT);

        try {
            $query->execute();
        } catch(PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            $db->rollBack();
            return false;
        } catch(Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            $db->rollBack();
            return false;
        }

        return $db->commit(); //Should succeed with a value of TRUE
    }

    public function deleteOrderByID($value)
    {
        return Database::deleteOne($value, 'id', 'orders');
    }

    public function save()
    {
        if ($this->getID()) {
            return $this->updateOrder();
        } else {
            return $this->createOrder();
        }
    }
}