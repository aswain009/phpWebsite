<?php

namespace regodesign\store;

use a3smedia\utilities\Database;

class Products
{
	private $sku;
	private $category;
	private $cost;
	private $description;
    private $shortDescription;
    private $dropDescription;
    private $stoneType;
    private $diamondWeight;
    private $metalType;
    private $partnerPiece;
    private $defaultCenterSize;
    private $diamondQuality;
	private $has_options;
    private $image;
    private $catalogImage;
    private $storeImage;
    private $thumbImage;
	private $name;
	private $price;
	private $status;
	private $tax_class_id;
	private $visibility;
	private $weight;
	private $qty;
	private $min_sale_qty;
	private $links_related_sku;
	private $links_crosssell_sku;
	private $links_upsell_sku;
	private $custom_option_row_title;

	public function getSKU()
    {
		return $this->sku;
	}

	public function setSKU($value)
    {
		$this->sku = $value;
	}

	public function getCategory()
    {
		return $this->category;
	}

	public function setCategory($value)
    {
		$this->category = $value;
	}

	public function getCost()
    {
		return $this->cost;
	}

	public function setCost($value)
    {
		$this->cost = $value;
	}

	public function getDescription()
    {
		return $this->description;
	}

	public function setDescription($value)
    {
		$this->description = $value;
	}

    public function getShortDescription()
    {
        return $this->shortDescription;
    }
    public function setShortDescription($value)
    {
        $this->shortDescription = $value;
    }

    public function getDropDescription() {
        return $this->dropDescription;
    }

    public function getStoneType()
    {
        return $this->stoneType;
    }
    public function setStoneType($value)
    {
        $this->stoneType = $value;
    }

    public function getDiamondWeight()
    {
        return $this->diamondWeight;
    }
    public function setDiamondWeight($value)
    {
        $this->diamondWeight = $value;
    }

    public function getMetalType()
    {
        return $this->metalType;
    }
    public function setMetalType($value)
    {
        $this->metalType = $value;
    }

    public function getPartnerPiece()
    {
        return explode(',', $this->partnerPiece);
    }
    public function setPartnerPiece($value)
    {
        $this->partnerPiece = implode(',', $value);
    }

    public function getDefaultCenterSize()
    {
        return $this->defaultCenterSize;
    }
    public function setDefaultCenterSize($value)
    {
        $this->defaultCenterSize = $value;
    }

    public function getDiamondQuality()
    {
        return $this->diamondQuality;
    }
    public function setDiamondQuality($value)
    {
        $this->diamondQuality = $value;
    }

	public function getHasOptions()
    {
		return $this->has_options;
	}

	public function setHasOptions($value)
    {
		$this->has_options = $value;
	}

	public function getImage()
    {
        $url = 'http://regodesigns.com/beta/images/products/';
        $path = '/var/www/beta/images/products/';
        $product_image = $url . $this->image;
        if (!file_exists($path . $this->image)) {
            $generic = substr($this->image, 0, -8) . '1.jpg';
            if (file_exists($path . $generic)) {
                $product_image = $url . $generic;
            } else {
                $first = substr($this->image, 0, -8) . '01-1.jpg';
                if (file_exists($path . $first)) {
                    $product_image = $url . $first;
                } else {
                    $first = substr($this->image, 0, -8) . '01-2.jpg';
                    if (file_exists($path . $first)) {
                        $product_image = $url . $first;
                    } else {
                        $type = $_SESSION['type'];
                        if ($type == 2 && $_SESSION['logo']) {
                            $product_image = "images/logos/" . $_SESSION['logo'];
                        } else {
                            $product_image = 'images/logo.jpg';
                        }
                    }
                }
            }
        }
		return $product_image;
	}

    public function getGalleryImages() {
        if (strpos($this->getImage(), '-1') !== false) {
            $gallery_images = array();
            for ($i = 1; $i < 5; $i++) {
                $gallery_images[] = preg_replace('/\d(\.\w{3})/', "$i$1", $this->getImage());
            }
        } else {
            $gallery_images = array();
            $gallery_images[] = $this->getImageBase();
            for ($i = 1; $i < 5; $i++) {
                $gallery_images[] = preg_replace('/(\.\w{3})/', "_v$i$1", $this->getImageBase());
            }
        }
        return $gallery_images;
    }

    public function getImageBase()
    {
        return $this->image;
    }

	public function setImage($value)
    {
		$this->image = $value;
	}

    public function getCatalogImage()
    {
        return $this->catalogImage;
    }

    public function setCatalogImage($value)
    {
        $this->catalogImage = $value;
    }

    public function getStoreImage()
    {
        return $this->storeImage;
    }

    public function setStoreImage($value)
    {
        $this->storeImage = $value;
    }

    public function getThumbImage()
    {
        return $this->thumbImage;
    }

    public function setThumbImage($value)
    {
        $this->thumbImage = $value;
    }

	public function getPrice()
    {
		return $this->price;
	}

	public function setPrice($value)
    {
		$this->price = $value;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($value)
    {
		$this->name = $value;
	}

	public function getStatus()
    {
		return $this->status;
	}

	public function setStatus($value)
    {
		$this->status = $value;
	}

	public function getTax()
    {
		return $this->tax_class_id;
	}

	public function setTax($value)
    {
		$this->tax_class_id = $value;
	}

	public function getVisibility()
    {
		return $this->visibility;
	}

	public function setVisibility($value)
    {
		$this->visibility = $value;
	}

	public function getWeight()
    {
		return $this->weight;
	}

	public function setWeight($value)
    {
		$this->weight = $value;
	}

	public function getQty()
    {
		return $this->qty;
	}

	public function setQty($value)
    {
		$this->qty = $value;
	}

	public function getMinSaleQty()
    {
		return $this->min_sale_qty;
	}

	public function setMinSaleQty($value)
    {
		$this->min_sale_qty = $value;
	}

	public function getLinksRelatedSKU()
    {
		return $this->links_related_sku;
	}

	public function setLinksRelatedSKU($value)
    {
		$this->links_related_sku = $value;
	}

	public function getLinksCrossSellSKU()
    {
		return $this->links_crosssell_sku;
	}

	public function setLinksCrossSellSKU($value)
    {
		$this->links_crosssell_sku = $value;
	}

	public function getLinksUpSellSKU()
    {
		return $this->links_upsell_sku;
	}

	public function setLinksUpSellSKU($value)
    {
		$this->links_upsell_sku = $value;
	}

	public function getCustomOptionRowTitle()
    {
		return $this->custom_option_row_title;
	}

	public function setCustomOptionRowTitle($value)
    {
		$this->custom_option_row_title = $value;
	}

	/*CRUD*/
	public function createProduct()
    {
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'INSERT INTO products (sku, category, cost, description, shortDescription, stoneType, diamondWeight, metalType, partnerPiece, defaultCenterSize, diamondQuality, has_options, image, catalogImage, storeImage, thumbImage, name, price, status, tax_class_id, visibility, weight, qty, min_sale_qty, links_related_sku, links_crosssell_sku, links_upsell_sku, custom_option_row_title) VALUES(:sku, :category, :cost, :description,
            :shortDescription, :stoneType, :diamondWeight, :metalType, :partnerPiece, :defaultCenterSize, :diamondQuality, has_options, :image, :name, :price, :status, :tax_class_id, :visibility, :weight, :qty, :min_sale_qty, :links_related_sku, :links_crosssell_sku, :links_upsell_sku, :custom_option_row_title)';

		$query = $db->prepare($sql);
		$query->bindValue(':sku', $this->getSKU());
		$query->bindValue(':category', $this->getCategory());
		$query->bindValue(':cost', $this->getCost());
        $query->bindValue(':description', $this->getDescription());
        $query->bindValue(':shortDescription', $this->getShortDescription());
        $query->bindValue(':stoneType', $this->getStoneType());
        $query->bindValue(':diamondWeight', $this->getDiamondWeight());
        $query->bindValue(':metalType', $this->getMetalType());
        $query->bindValue(':partnerPiece', $this->getPartnerPiece());
        $query->bindValue(':defaultCenterSize', $this->getDefaultCenterSize());
        $query->bindValue(':diamondQuality', $this->getDiamondQuality());
		$query->bindValue(':has_options', $this->getHasOptions());
        $query->bindValue(':image', $this->getImage());
        $query->bindValue(':catalogImage', $this->getCatalogImage());
        $query->bindValue(':storeImage', $this->getStoreImage());
        $query->bindValue(':thumbImage', $this->getThumbImage());
		$query->bindValue(':name', $this->getName());
		$query->bindValue(':price', $this->getPrice());
		$query->bindValue(':status', $this->getStatus());
		$query->bindValue(':tax_class_id', $this->getTax());
		$query->bindValue(':visibility', $this->getVisibility());
		$query->bindValue(':weight', $this->getWeight());
		$query->bindValue(':qty', $this->getQty());
		$query->bindValue(':min_sale_qty', $this->getMinSaleQty());
		$query->bindValue(':links_related_sku', $this->getLinksRelatedSKU());
		$query->bindValue(':links_crosssell_sku', $this->getLinksCrossSellSKU());
		$query->bindValue(':links_upsell_sku', $this->getLinksUpSellSKU());
		$query->bindValue(':custom_option_row_title', $this->getCustomOptionRowTitle());

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
		return $db->commit(); //Should succeed with a value of TRUE
	}

	public function readProductBySKU($value)
    {
        $db = Database::PDO();
        $query = $db->prepare('SELECT * FROM products WHERE sku=:sku');
        $query->bindValue(':sku', $value);

        try {
            $query->execute();
        } catch(PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            return false;
        } catch(Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            return false;
        }

        $query->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        return $query->fetch();
	}

	public function readProductByCategory($value)
    {
		$db = Database::PDO();
        $query = $db->prepare('SELECT * FROM products WHERE category=:category ORDER BY itemPosition ASC, CAST(sku as unsigned) DESC');
        $query->bindValue(':category', $value);
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            return false;
        }
        $query->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        return $query->fetchAll();
	}

    public static function readByCategoryPage($category, $page)
    {
        $page_size = 30;
        $db = Database::PDO();

        $query = $db->prepare("SELECT name FROM categories WHERE slug = :slug LIMIT 1");
        $query->bindParam(':slug', $category);
        $query->execute();
        $category_name = $query->fetch();

        $query = $db->prepare('SELECT * FROM products WHERE category=:category ORDER BY itemPosition ASC, CAST(sku as unsigned) DESC LIMIT :start,:amount');

        $query->bindValue(':category', $category_name['name']);
        $query->bindValue(':start', max(0, ($page-1)*$page_size));
        $query->bindValue(':amount', $page_size);

        try {
            $query->execute();
        } catch (PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            return false;
        }

        $query->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        return $query->fetchAll();
    }

	public function readAllProducts()
    {
		$db = Database::PDO();
        $query = $db->prepare('SELECT * FROM products ORDER BY itemPosition ASC, CAST(sku as unsigned) DESC');

        try {
            $query->execute();
        } catch (PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            yield false;
        } catch (Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
            yield false;
        }

        $query->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        while ($result = $query->fetch()) {
            yield $result;
        }
	}
	public function updateProduct()
    {
		$db = Database::PDO();
		$db->beginTransaction();
		$sql = 'UPDATE products SET category = :category, cost = :cost, description = :description, shortDescription = :shortDescription, stoneType = :stoneType, diamondWeight = :diamondWeight, metalType = :metalType, partnerPiece = :partnerPiece, defaultCenterSize = :defaultCenterSize, diamondQuality = :diamondQuality, has_options = :has_options, image = :image, name = :name, price = :price, status = :status, tax_class_id = :tax_class_id, visibility = :visibility, weight = :weight, qty = :qty, min_sale_qty = :min_sale_qty, links_related_sku = :links_related_sku, links_crosssell_sku = :links_crosssell_sku, links_upsell_sku = :links_upsell_sku, custom_option_row_title = :custom_option_row_title WHERE sku = :sku';

		$query = $db->prepare($sql);
		$query->bindValue(':sku', $this->getSKU());
		$query->bindValue(':category', $this->getCategory());
		$query->bindValue(':cost', $this->getCost());
		$query->bindValue(':description', $this->getDescription());
        $query->bindValue(':shortDescription', $this->getShortDescription());
        $query->bindValue(':stoneType', $this->getStoneType());
        $query->bindValue(':diamondWeight', $this->getDiamondWeight());
        $query->bindValue(':metalType', $this->getMetalType());
        $query->bindValue(':partnerPiece', $this->partnerPiece);
        $query->bindValue(':defaultCenterSize', $this->getDefaultCenterSize());
        $query->bindValue(':diamondQuality', $this->getDiamondQuality());
		$query->bindValue(':has_options', $this->getHasOptions());
		$query->bindValue(':image', $this->getImage());
		$query->bindValue(':name', $this->getName());
		$query->bindValue(':price', $this->getPrice());
		$query->bindValue(':status', $this->getStatus());
		$query->bindValue(':tax_class_id', $this->getTax());
		$query->bindValue(':visibility', $this->getVisibility());
		$query->bindValue(':weight', $this->getWeight());
		$query->bindValue(':qty', $this->getQty());
		$query->bindValue(':min_sale_qty', $this->getMinSaleQty());
		$query->bindValue(':links_related_sku', $this->getLinksRelatedSKU());
		$query->bindValue(':links_crosssell_sku', $this->getLinksCrossSellSKU());
		$query->bindValue(':links_upsell_sku', $this->getLinksUpSellSKU());
		$query->bindValue(':custom_option_row_title', $this->getCustomOptionRowTitle());

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

		return $db->commit(); //Should succeed with a value of TRUE
	}
    
	public function deleteProductBySKU($value)
    {
		return Database::deleteOne($value, 'sku', 'products');
	}
}