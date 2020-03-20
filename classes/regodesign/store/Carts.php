<?php
namespace regodesign\store;
use a3smedia\utilities\Database;

class Carts
{
    private $id;
    private $cartConsumerID;
    private $cartProductID;
    private $cartProductQuantity;
    private $cartProductRingSize;

    public function getID()
    {
        return $this->id;
    }

    public function setID($value='')
    {
        $this->id = $value;
    }

    public function getConsumerID()
    {
        return $this->cartConsumerID;
    }

    public function setConsumerID($value){
        $this->cartConsumerID = $value;
    }

    public function getProductID()
    {
        return $this->cartProductID;
    }

    public function setProductID($value){
        $this->cartProductID = $value;
    }

    public function getQuantity()
    {
        return $this->cartProductQuantity;
    }

    public function setQuantity($value)
    {
        $this->cartProductQuantity = $value;
    }

    public function getInstructions()
    {
        return $this->cartProductInstructions;
    }

    public function setInstructions($value)
    {
        $this->cartProductInstructions = $value;
    }

    public function getRingSize()
    {
        return $this->cartProductRingSize;
    }

    public function setRingSize($value)
    {
        $this->cartProductRingSize = $value;
    }

    /*CRUD*/

    public function createCart(){
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'INSERT INTO carts (cartConsumerID, cartProductID, cartProductInstructions, cartProductRingSize, cartProductQuantity) VALUES(:cartConsumerID, :cartProductID, :cartProductInstructions, :cartProductRingSize, :cartProductQuantity)';

        $query = $db->prepare($sql);
        $query->bindValue(':cartConsumerID', $this->getConsumerID(), \PDO::PARAM_INT);
        $query->bindValue(':cartProductInstructions', $this->getInstructions());
        $query->bindValue(':cartProductID', $this->getProductID(), \PDO::PARAM_INT);
        $query->bindValue(':cartProductQuantity', $this->getQuantity(), \PDO::PARAM_INT);
        $query->bindValue(':cartProductRingSize', $this->getRingSize());

        try{
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

    public static function readCartByConsumer($value){
        return Database::read(__CLASS__, $value, 'cartConsumerID', 'carts', true);
    }

    public static function readCartExist($consumer, $product){
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'SELECT * FROM carts WHERE cartConsumerID = :cartConsumerID AND cartProductID = :cartProductID';

        $query = $db->prepare($sql);
        $query->bindValue(':cartConsumerID', $consumer, \PDO::PARAM_INT);
        $query->bindValue(':cartProductID', $product, \PDO::PARAM_INT);

        try{
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

        $db->commit();

        if($query->rowCount() > 0){
            return $query->fetchColumn(4); //Return the quantity as a true value
        } else {
            return false; //Cart item does not exist
        }
    }

    public function updateCart(){
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'UPDATE carts SET cartProductQuantity = :cartProductQuantity, cartProductInstructions = :cartProductInstructions, cartProductRingSize = :cartProductRingSize WHERE id = :cartID';

        $query = $db->prepare($sql);
        $query->bindValue(':cartID', $this->getID(), \PDO::PARAM_INT);
        $query->bindValue(':cartProductQuantity', $this->getQuantity(), \PDO::PARAM_INT);
        $query->bindValue(':cartProductInstructions', $this->getInstructions(), \PDO::PARAM_INT);
        $query->bindValue(':cartProductRingSize', $this->getRingSize(), \PDO::PARAM_INT);

        try{
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

    /**
    * Remove a cart item
    * Even though the function reads, ByProduct, it still looks for the consumer
    * @param int $consumer: The consumer ID
    * @param int $product: The product SKU
    * @return bool
    */
    public function deleteCartByProduct($consumer, $product){
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'DELETE FROM carts WHERE cartConsumerID = :cartConsumerID AND cartProductID = :cartProductID';

        $query = $db->prepare($sql);
        $query->bindValue(':cartConsumerID', $consumer, \PDO::PARAM_INT);
        $query->bindValue(':cartProductID', $product, \PDO::PARAM_INT);

        try{
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

    public function delete()
    {
        $db = Database::PDO();
        $db->beginTransaction();
        $sql = 'DELETE FROM carts WHERE id = :id';

        $query = $db->prepare($sql);
        $query->bindValue(':id', $this->id, \PDO::PARAM_INT);

        try{
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

    public function deleteCartByConsumer($value){
        //Though this function is meant to do only one row; this should work regardless.
        return Database::deleteOne($value, 'cartConsumerID', 'carts');
    }
}