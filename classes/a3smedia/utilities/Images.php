<?php
namespace a3smedia\utilities;

class Images{
	//Source
	private $sourceWidth;
	private $sourceHeight;
	private $sourceImage;

	//Destination
	private $newWidth; 
	private $newHeight;
	private $newImage;

	//File path and name
	private $path;
	private $name;

	public function getSourceWidth(){
		return $this->sourceWidth;
	}

	public function setSourceWidth(){
		if($this->sourceImage){
			$this->sourceWidth = imagesx($this->sourceImage);	
		} else {
			$this->sourceWidth = 0;
		}
	}

	public function getSourceHeight(){
		return $this->sourceHeight;
	}

	public function setSourceHeight(){
		if($this->sourceImage){
			$this->sourceHeight = imagesx($this->sourceImage);	
		} else {
			$this->sourceHeight = 0;
		}
	}

	public function getSourceImage(){
		return $this->sourceImage;
	}

	/**
	* Create the source resource
	* @param array $file: A $_FILES array
	*/
	public function setSourceImage($file){
		$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		//var_dump($extension);

		switch($extension){
			case 'jpg':
        	case 'jpeg':
	            $this->sourceImage = @imagecreatefromjpeg($file['tmp_name']);
	            break;
	        case 'gif':
	            $this->sourceImage = @imagecreatefromgif($file['tmp_name']);
	            break;
	        case 'png':
	            $this->sourceImage = @imagecreatefrompng($file['tmp_name']);
	            break;
	        default:
	            break;
		}
	}

	public function getNewWidth(){
		return $this->newWidth;
	}

	public function setNewWidth($value){
		$this->newWidth = $value;
	}

	public function getNewHeight(){
		return $this->newHeight;
	}

	public function setNewHeight($value){
		$this->newHeight = $value;
	}

	public function getNewImage(){
		return $this->newImage;
	}

	public function setNewImage(){
		if($this->getNewWidth() && $this->getNewHeight()){
			$this->newImage = imagecreatetruecolor($this->getNewWidth(), $this->getNewHeight());
		} else {
			$this->newImage = false;
		}
		
	}

	//Perhaps add directory functions
	public function getPath(){
		return $this->path;
	}

	public function setPath($value){
		if(!file_exists($value)){
			try{
				if(!mkdir($value, 0777, true)){
					throw new Exception('Directories unable to be made');
				}
			} catch(\Exception $e){
				echo '<h1>Exception</h1>';
				echo '<p>'.$e->getMessage().'</p>';
			}
		}

		$this->path = $value;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($value){
		$this->name = $value;
	}

	/*Manipulations*/

	/**
	* Reduce the size of the image to the new image dimensions, or close to it.
	* @link http://stackoverflow.com/questions/1830829/image-resizing-in-php-gd
	* @uses This is to make thumbnails or shrink the size of a full image
	* @return bool
	* @todo Have it create a new image based on the type of image (gif, png, bmp...)
	*/
	public function reduceSize(){
		$sourceAspectRatio 	= $this->getSourceWidth() / $this->getSourceHeight();
		$newAspectRatio 	= $this->getNewWidth() / $this->getNewHeight();

		if($newAspectRatio > $sourceAspectRatio){
			$this->setNewHeight( $this->getNewWidth() / $sourceAspectRatio );
		} else {
			$this->setNewWidth( $this->getNewHeight() * $sourceAspectRatio );
		}

		if(imagecopyresampled(
			$this->getNewImage(), 
			$this->getSourceImage(), 
			0, 0, 
			0, 0, 
			$this->getNewWidth(), 
			$this->getNewHeight(), 
			$this->getSourceWidth(),
			$this->getSourceHeight()) ){

			if( imagejpeg($this->getNewImage(), $this->getPath().$this->getName().'.jpg') ){
				return true;
			}
		}
	}

	//Make a full size image uploader
	//Make a crop size image maker from Tiny Tots
}