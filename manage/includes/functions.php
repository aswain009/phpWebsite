<?php use a3smedia\utilities\Database;

date_default_timezone_set('America/New_York'); //Sadly none for Ohio. PHP is discriminating! >:P

if(isset($_GET['logout'])){
	unset($_SESSION['_admin']);
	header('Location: index.php');
}

if(!isset($_SESSION['_admin'])){
	header('Location: index.php');
}

//Template
function getExample($action, $id = '', $values = ''){
	$object = '';
	$required = array();

	switch($action){
		case 'create':
			break;
		//create
		case 'read':
			break;
		//read
		case 'readAll':
			break;
		//readAll
		case 'update':
			break;
		//update
		case 'delete':
			break;
		//delete
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getAdmin($action, $id = '', $values = ''){
	$valid = true;
	$object = new regodesign\users\Admins;
	$required = array('adminEmail');

	switch($action){
		case 'create':
			$required[] = 'adminPassword';
			$required[] = 'adminConfirm';

			foreach($required as $require){
				if(empty($values[$require])){
					$_SESSION['_error'] = 'Missing required fields';
					$valid = false;
				}
			}

			if(!filter_var($values['adminEmail'], FILTER_VALIDATE_EMAIL)){
				$_SESSION['_error'] = 'Not a valid email address for admin email';
				$valid = false;
			}

			if(!Database::uniqueCheck($values['adminEmail'], 'adminEmail', 'admins')){
				$_SESSION['_error'] = 'Email already being used';
				$valid = false;
			}

			if($values['adminPassword'] != $values['adminConfirm']){
				$_SESSION['_error'] = 'Passwords do not match';
				$valid = false;
			}

			if($valid){
				$hash = Database::hash($values['adminPassword']);

				$object->setEmail($values['adminEmail']);
				$object->setPassword($hash['hash']);
				$object->setSalt($hash['salt']);
				$object->save();
			}
			break;
		//create
		case 'readByID':
			return $object->readAdminByID($id);
			break;
		//read
		case 'readAll':
			return $object->readAllAdmins();
			break;
		//readAll
		case 'update':
			$check = getAdmin('readByID', $id);

			foreach($required as $require){
				if(empty($values[$require])){
					$_SESSION['_error'] = 'Missing required fields';
					$valid = false;
				}
			}

			if(!filter_var($values['adminEmail'], FILTER_VALIDATE_EMAIL)){
				$_SESSION['_error'] = 'Not a valid email address for admin email';
				$valid = false;
			}

			if($check->getEmail() != $values['adminEmail']){
				if(!Database::uniqueCheck($values['adminEmail'], 'adminEmail', 'admins')){
					$_SESSION['_error'] = 'Email already being used';
					$valid = false;
				}
			}

			$password = false; //Does not need to change
			if($values['adminPassword']){
				if($values['adminPassword'] != $values['adminConfirm']){
					$_SESSION['_error'] = 'Passwords do not match';
					$valid = false;
				} else {
					$password = true;
				}
			} //if nothing then continue


			if($valid){

				if($password){
					//if new then replace password and salt
					$hash = Database::hash($values['adminPassword']);	
				} else {
					//if not, then keep old values
					$hash['hash'] = $check->getPassword();
					$hash['salt'] = $check->getSalt();
				}
				

				$object->setID($id);
				$object->setEmail($values['adminEmail']);
				$object->setPassword($hash['hash']);
				$object->setSalt($hash['salt']);
				$object->save();
			}

			break;
		//update
		case 'delete':
			return $object->deleteAdminByID($id);
			break;
		//delete
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getConsumer($action, $id = '', $values = ''){

	$object = new regodesign\users\Consumers;
	$required = array('consumerID', 'consumerRetailer', 'consumerType', 'consumerUsername', 'consumerFullName', 'consumerAddressStreet', 'consumerAddressCity', 'consumerAddressState', 'consumerAddressZip', 'consumerPhone');
	$valid = true;

	switch($action){
		case 'create':

			$required[] = 'consumerPassword';
			$required[] = 'consumerConfirm';

			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing required fields';
				}
			}

			var_dump(Database::uniqueCheck($values['consumerID'], 'consumerID', 'consumers'));

			//Check if id is unique
			if(!Database::uniqueCheck($values['consumerID'], 'consumerID', 'consumers')){
				$valid = false;
				$_SESSION['_error'] = 'ID already taken';
			}

			//Check if username is unique
			if(!Database::uniqueCheck($values['consumerUsername'], 'consumerUsername', 'consumers')){
				$valid = false;
				$_SESSION['_error'] = 'Username already taken';
			}

			

			//Check if passwords (password and confirm) match
			if($values['consumerPassword'] != $values['consumerConfirm']){
				$valid = false;
				$_SESSION['_error'] = 'Passwords do not match';
			}



			if($valid){
				$object->setID($values['consumerID']);
				$object->setRetailerID($values['consumerRetailer']);
				$object->setType($values['consumerType']);
				$object->setUsername($values['consumerUsername']);
				$object->setPassword(md5($values['consumerPassword']));
				$object->setSalt(''); //slowly deprecating
				$object->setFullName($values['consumerFullName']);
				$object->setAddressStreet($values['consumerAddressStreet']);
				$object->setAddressSuite($values['consumerAddressSuite']);
				$object->setAddressCity($values['consumerAddressCity']);
				$object->setAddressState($values['consumerAddressState']);
				$object->setAddressZip($values['consumerAddressZip']);
				$object->setPhone($values['consumerPhone']);

				var_dump($object);

				$object->createConsumer();
			}

			break;
		//create
		case 'readByID':
			return $object->readConsumerByID($id);
			break;
		//read
		case 'readByRetailer':
			return $object->readConsumersByRetailer($id);
			break;
		//readByRetailer
		case 'readAll':
			return $object->readAllConsumers();
			break;
		//readAll
		case 'update':
			//Use to compare
			$compare = getConsumer('readByID', $id);

			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing required fields';
				}
			}

			//Check if username is unique only when new username is different from old username
			if($compare->getUsername() != $values['consumerUsername']){
				if(!Database::uniqueCheck($values['consumerUsername'], 'consumerUsername', 'consumers')){
					$valid = false;
					$_SESSION['_error'] = 'Username already taken';
				}
			}

			//Check if passwords (password and confirm) match
			if($values['consumerPassword'] != $values['consumerConfirm']){
				$valid = false;
				$_SESSION['_error'] = 'Passwords do not match';
			}

			if($valid){
				//If there was a new value for password and it matches with confirm
				if($values['consumerPassword'] && ($values['consumerPassword'] == $values['consumerConfirm'])){
					$pass = md5($values['consumerPassword']);
				} else {
					//Get old password hash and salt
					$pass = $compare->getPassword();
				}

				$object->setID($id);
				$object->setRetailerID($values['consumerRetailer']);
				$object->setType($values['consumerType']);
				$object->setUsername($values['consumerUsername']);
				$object->setPassword($pass);
				$object->setSalt(''); //slowly deprecating
				$object->setFullName($values['consumerFullName']);
				$object->setAddressStreet($values['consumerAddressStreet']);
				$object->setAddressSuite($values['consumerAddressSuite']);
				$object->setAddressCity($values['consumerAddressCity']);
				$object->setAddressState($values['consumerAddressState']);
				$object->setAddressZip($values['consumerAddressZip']);
				$object->setPhone($values['consumerPhone']);

				$object->updateConsumer();
			}
			break;
		//update
		case 'delete':
			return $object->deleteConsumerByID($id);
			break;
		//delete
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getOrder($action, $id = '', $values = ''){
	$object = new regodesign\store\Orders;
	$required = array('orderCustomerID', 'orderDate', 'orderQuantity', 'orderStatus');
	$valid = true;

	switch($action){
		case 'readByID':
			return $object->readOrderByID($id);
			break;
		//read
		case 'readAll':
			return $object->readAllOrders();
			break;
		//readAll
		case 'update':
			//Database::pre_var_dump($values); die();

			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing required fields';
				}
			}

			if($values['orderQuantity'] <= 0){
				$valid = false;
				$_SESSION['_error'] = 'Quantity must be a whole, positive number';
			}

			if($values['orderShipped'] < 0){
				$valid = false;
				$_SESSION['_error'] = 'Shipped must be a positive number';
			}

			if($valid){
				$object->setID($id);
				$object->setCustomerID($values['orderCustomerID']);
				$object->setDate($values['orderDate']);
				$object->setQuantity($values['orderQuantity']);
				$object->setShipped($values['orderShipped']);
				$object->setStatus($values['orderStatus']);
				$object->setTrackingNo($values['orderTrackingNo']);
				
				if($object->save()){
					$quantity = $values['quantity'];
					$shipped = $values['shipped'];
					//var_dump($shipped['10001-05']); die();

					//Since both quantity and shipped arrays will have the same array keys; grab the array keys to get the values
					$keys = array_keys($quantity);

					foreach($keys as $key){
						$orderProducts = new regodesign\store\OrderProducts;
						$orderProducts->setOrderID($id);
						$orderProducts->setProductID($key);
						$orderProducts->setShipped($shipped[$key]);
						$orderProducts->setQuantity($quantity[$key]);
						$orderProducts->updateProductOrder();
					}
				} else {
					$_SESSION['General order failed to update'];
				}
			} 
			break;
		//update
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getOrderProducts($action, $id = '', $values = ''){
	$object = new regodesign\store\OrderProducts;

	switch($action){
		case 'readByOrder':
			return $object->readProductsByOrder($id);
			break;
		//read
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getProduct($action, $id = '', $values = ''){
	$object = new regodesign\store\Products;
	$required = array('productName', 'productCategory', 'productPrice', 'productCost');

	$valid = true;

	switch($action){
		case 'create':
			$required[] = 'productSKU'; //Only for create function
			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing required fields';
				}
			}

			if(!Database::uniqueCheck($values['productSKU'], 'sku', 'products')){
				$valid = false;
				$_SESSION['_error'] = 'SKU already used';
			}

			if($valid){
				$object->setSKU($values['productSKU']);
				$object->setCategory($values['productCategory']);
				$object->setCost($values['productCost']);
				$object->setDescription($values['productDescription']);
				$object->setHasOptions($values['productHasOptions']); //Unknown use
				$object->setImage($values['productImage']);
				$object->setName($values['productName']);
				$object->setPrice($values['productPrice']);
				$object->setStatus($values['productStatus']);
				$object->setTax($values['productTaxClass']); //Unknown use
				$object->setVisibility($values['productVisibility']);
				$object->setWeight($values['productWeight']);
				$object->setQty($values['productQty']);
				$object->setMinSaleQty($values['productMinSaleQty']);
				$object->setLinksRelatedSKU($values['productLinksRelatedSKU']);
				$object->setLinksCrossSellSKU($values['productLinksCrossSellSKU']);
				$object->setLinksUpSellSKU($values['productLinksUpsellSKU']);
				$object->setCustomOptionRowTitle($values['productCustomOptionRow']);

				//Since the primary key is not auto-incrementing, just go straight to the create method of the class
				if(!$object->createProduct()){
					$_SESSION['_error'] = 'Product could not be created';
				}
			}
			break;
		//create
		case 'readByID':
			return $object->readProductBySKU($id);
			break;
		//read
		case 'readAll':
			return $object->readAllProducts();
			break;
		//readAll
		case 'update':
			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing required fields';
				}
			}

			if($valid){
				$object->setSKU($id);
				$object->setCategory($values['productCategory']);
				$object->setCost($values['productCost']);
				$object->setDescription($values['productDescription']);
				$object->setHasOptions($values['productHasOptions']); //Unknown use
				$object->setImage($values['productImage']);
				$object->setName($values['productName']);
				$object->setPrice($values['productPrice']);
				$object->setStatus($values['productStatus']);
				$object->setTax($values['productTaxClass']); //Unknown use
				$object->setVisibility($values['productVisibility']);
				$object->setWeight($values['productWeight']);
				$object->setQty($values['productQty']);
				$object->setMinSaleQty($values['productMinSaleQty']);
				$object->setLinksRelatedSKU($values['productLinksRelatedSKU']);
				$object->setLinksCrossSellSKU($values['productLinksCrossSellSKU']);
				$object->setLinksUpSellSKU($values['productLinksUpsellSKU']);
				$object->setCustomOptionRowTitle($values['productCustomOptionRow']);

				//Since the primary key is not auto-incrementing, just go straight to the create method of the class
				if(!$object->updateProduct()){
					$_SESSION['_error'] = 'Product could not be updated';
				}
			}
			break;
		//update
		case 'delete':
			return $object->deleteProductBySKU($id);
			break;
		//delete
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getRetailer($action, $id = '', $values = ''){
	$object = new regodesign\users\Retailers;
	$required = array('retailerName', 'retailerEmail');
	$valid = true;

	switch($action){
		case 'create':
			$logo = $_FILES['retailerLogo'];

			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing Required Fields';
				}
			}

			//Check if id is unique
			if(!Database::uniqueCheck($values['retailerID'], 'retailerID', 'retailers')){
				$valid = false;
				$_SESSION['_error'] = 'ID already taken';
			}

			//Logo is not mandatory, but still needs some validations if there is a file uploaded
			if($logo['name']){
				$logoInfo = pathinfo($logo['name']);
				$imgExtensions = array('bmp', 'jpeg', 'jpg', 'gif', 'png');

				if($logo['error'] > 0){
					$valid = false;
					$_SESSION['_error'] = 'An error occured uploading image';
				}

				//file type check
				if(!in_array(strtolower($logoInfo['extension']), $imgExtensions)){
					$valid = false;
					$_SESSION['_error'] = 'Invalid image type';
				}
			}
			

			if($valid){
				if($logo['name']){
					$logoObj = new a3smedia\utilities\Images;
					$logoObj->setPath(LOGO_PATH);
					$logoObj->setName($logoInfo['filename']);
					//Dimensions of the new image size
					$logoObj->setNewWidth(226);
					$logoObj->setNewHeight(162);
					$logoObj->setNewImage();
					//Dimensions of the original image
					$logoObj->setSourceImage($logo);
					$logoObj->setSourceWidth();
					$logoObj->setSourceHeight();
					$logoObj->reduceSize();

					$object->setLogo($logoInfo['filename'].'.jpg');
				} else {
					$object->setLogo(null);
				}
				
				$object->setID($values['retailerID']);
				$object->setName($values['retailerName']);
				$object->setMarkup($values['retailerMarkup']);
				$object->setEmail($values['retailerEmail']);
				$object->createRetailer();
			}

			break;
		//create
		case 'readByID':
			return $object->readRetailerByID($id);
			break;
		//read
		case 'readAll':
			return $object->readAllRetailers();
			break;
		//readAll
		case 'update':
			$logo = $_FILES['retailerLogo'];

			foreach($required as $require){
				if(empty($values[$require])){
					$valid = false;
					$_SESSION['_error'] = 'Missing Required Fields';
				}
			}

			//Logo is not mandatory, but still needs some validations if there is a file uploaded
			if($logo['name']){
				$logoInfo = pathinfo($logo['name']);
				$imgExtensions = array('bmp', 'jpeg', 'jpg', 'gif', 'png');

				if($logo['error'] > 0){
					$valid = false;
					$_SESSION['_error'] = 'An error occured uploading image';
				}

				//file type check
				if(!in_array(strtolower($logoInfo['extension']), $imgExtensions)){
					$valid = false;
					$_SESSION['_error'] = 'Invalid image type';
				}
			}

			if($valid){
				if($logo['name']){
					$logoObj = new a3smedia\utilities\Images;
					$logoObj->setPath(LOGO_PATH);
					$logoObj->setName($logoInfo['filename']);
					//Dimensions of the new image size
					$logoObj->setNewWidth(226);
					$logoObj->setNewHeight(162);
					$logoObj->setNewImage();
					//Dimensions of the original image
					$logoObj->setSourceImage($logo);
					$logoObj->setSourceWidth();
					$logoObj->setSourceHeight();
					$logoObj->reduceSize();

					$object->setLogo($logoInfo['filename'].'.jpg');
				} else {
					$object->setLogo(null);
				}
				
				$object->setID($id);
				$object->setName($values['retailerName']);
				$object->setMarkup($values['retailerMarkup']);
				$object->setEmail($values['retailerEmail']);
				$object->updateRetailer();
			}

			break;
		//update
		case 'delete':
			//First remove all consumers related to the retailer
			//Probably do an email notification, or something
			$dropConsumers = getConsumer('readByRetailer', $id);
			foreach($dropConsumers as $drop){
				if(!getConsumer('delete', $drop->getID())){
					$_SERVER['_error'] = 'Unable to continue deleting the retailer';
					return false;
				}
			}

			return $object->deleteRetailerByID($id);
			break;
		//delete
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}

function getStatus($action, $id = '', $values = ''){
	$object = new regodesign\store\Statuses;
	$required = array();

	switch($action){
		case 'readByID':
			return $object->readStatusByID($id);
			break;
		//read
		case 'readAll':
			return $object->readAllStatuses();
			break;
		//readAll
		default:
			$_SESSION['_error'] = 'Unknown function detected';
			break;
		//default
	}
}