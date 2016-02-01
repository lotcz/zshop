<?php 

class Images {

	static $formats = array('mini-thumb' => array( 'width' => 75, 'height' => 50 ),
							'thumb' => array( 'width' => 330, 'height' => 247 ),
							'view' => array( 'width' => 1000, 'height' => 750 )
						);

	public $root_images_disk_path = "";

	public $root_images_url = "";

	public $status = "uninitialized";

	function __construct( $data_path, $data_url) {
		$this->root_images_disk_path = $data_path;
		$this->root_images_url = $data_url;   
		$this->status = "OK"; //would be good to implement some kind of check for Phalcon and php versions
	}
	
	public function getImagePath( $image, $format = null ) {
		if (isset($format)) {
			$path_parts = pathinfo( $image );
			return $this->root_images_disk_path . $format . '/' . $path_parts['filename'] . '-' . $format . '.' . $path_parts['extension'];
		} else {
			return $this->root_images_disk_path . 'originals/' . $image;
		}
	}

	public function getImageURL( $image, $format = null ) {
		if (isset($format)) {
			$path_parts = pathinfo( $image );
			return $this->root_images_url . '/' . $format . '/' . $path_parts['filename'] . '-' . $format . '.' . $path_parts['extension'];
		} else {
			return $this->root_images_url . '/originals/' . $image;
		}
	}

	public function prepareImage( $image, $format = null ) {
		$resized_path = $this->getImagePath( $image, $format );
		if (!file_exists($resized_path)) {
			if (!is_dir($this->root_images_disk_path . $format)) {
				mkdir($this->root_images_disk_path . $format, 0777, true);
			}
			$original_path = $this->getImagePath( $image );
			if (file_exists($original_path)) {
				/* Phalcon 1.3.2
				$image = new Phalcon\Image\Adapter\GD( $original_path );
				$image->resize(Images::$formats[$format]['width'], Images::$formats[$format]['height']);
				if (!$image->save($resized_path)) {
					$this->flashMessages("Cannot resize image $original_path.");
				}
				*/

				$original_image = imagecreatefromjpeg($original_path);

				/* PHP 5.5.
				$rsr_scl = imagescale($rsr_org, ImagesGD::$formats[$format]['width'], ImagesGD::$formats[$format]['height'],  IMG_BICUBIC_FIXED);
				*/

				/* PHP 5.4 */
				list($source_image_width, $source_image_height, $source_image_type) = getimagesize($original_path);
				$resized_image = imagecreatetruecolor(Images::$formats[$format]['width'], Images::$formats[$format]['height']);
				imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, Images::$formats[$format]['width'], Images::$formats[$format]['height'], $source_image_width, $source_image_height);
				imagejpeg($resized_image, $resized_path);
				imagedestroy($resized_image);
				imagedestroy($original_image);
				
			} else {
				handleErr("Image $original_path not found. Cannot resize.", 'error');
			}
		}
	}

	public function deleteImageCache( $image ) {
		foreach (Images::$formats as $key => $format) {
			$resized_path = $this->getImagePath( $image, $key );
				if (file_exists($resized_path)) {
					unlink($resized_path);
			}
		}
	}

	public function exists( $image, $format = null ) {
		$original_path = $this->getImagePath( $image, $format );
		return file_exists($original_path);
	}
	
	public function img( $image, $format = null ) {
		if ($this->status == "OK") {
			$this->prepareImage( $image, $format );
		}
		return $this->getImageURL( $image, $format );
	}
	
	public function renderImage($image, $format = 'thumb', $alt = '', $css = '') {
		$url = $this->img($image, $format);
		echo sprintf('<img src="%s" class="%s" alt="%s" />', $url, $css, $alt);
	}
}