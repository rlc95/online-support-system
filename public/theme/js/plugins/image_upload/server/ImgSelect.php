<?php
/**
* ImgSelect
*/
class ImgSelect
{
	protected $options;

	protected $error_messages = array(
		// File upload errors codes
		// http://www.php.net/manual/en/features.file-upload.errors.php
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
        'gd' => 'PHP GD library is NOT installed on your web server',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => 'File is too big',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'Filetype not allowed',
        'max_width'  => 'Image exceeds maximum width of ',
        'min_width'  => 'Image requires a minimum width of ',
        'max_height' => 'Image exceeds maximum height of ',
        'min_height' => 'Image requires a minimum height of ',
        'upload_failed' => 'Failed to upload the file',
        'move_failed' => 'Failed to upload the file',
        'invalid_image' => 'Invalid image',
        'image_resize' => 'Failed to resize image',
        'not_exists' => 'Failed to load the image'
    );
	
	/**
	 *	Constructor
	 *
	 *  @param 	array|null 		$options
	 * 	@param  array|null 		$error_messages
	 *  @return void
	 */
	function __construct($options = null, $error_messages = null)
	{
		$this->options = array(
			// Upload directory
			'upload_dir' => 'assets/image_upload/temp_files/',
			
			// Accepted file types
			'accept_file_types' => 'png|jpg|jpeg|gif',
			
			// Directory mode
			'mkdir_mode' => 0755,
			
			// File max/min size in bytes
			'max_file_size' => null,
            'min_file_size' => 1,
            
            // Image size validation
            'max_width'  => null,
            'max_height' => null,
            'min_width'  => 1,
            'min_height' => 1,
    
    		// If the image size < crop size then force the resize
            'force_crop' => true,
            // Crop max width
            'crop_max_width' => null,
            // Crop max height
            'crop_max_height' => null,
		);

		if ($options) {
            $this->options = $options + $this->options;
        }

		if ($error_messages) {
            $this->error_messages = $error_messages + $this->error_messages;
        }

        $this->initialize();
	}

	/**
	 *	Initialize upload and crop actions
	 *
	 *  @return void
	 */
	protected function initialize()
	{
		// GD extension check
		// http://www.php.net/manual/en/book.image.php
		if (!extension_loaded('gd') || !function_exists('gd_info')) {
		    $this->error = $this->getErrorMessage('gd');
            return false;
		}

		switch (@$_POST['action']) {
			case 'upload':
				$this->upload();
			break;
			case 'crop':
				$this->crop();
			break;
		}

		if (isset($this->error)) {
			$this->generateResponse($this->error, false);
		}
	}

	/**
	 *	Upload action
	 *
	 *  @return void
	 */
	protected function upload()
	{
		$upload = null;
		
		if (isset($_FILES['file'])) {
			$upload = $_FILES['file'];	
		} elseif (isset($_POST['file'])) {
			$upload['tmp_name'] = base64_decode($_POST['file']);
			// When uploading via flash webcam the extension must be .jpg
			$upload['name'] = $this->getRandFilename().(empty($_POST['flashwebcam'])?'.png':'.jpg');
		}

		$file = $this->handleFileUpload(
			$upload['tmp_name'],
			$upload['name'],
			isset($upload['size']) ? $upload['size'] : strlen(@$upload['tmp_name']),
			isset($upload['error']) ? $upload['error'] : null
		);

		if ($file) {
			$this->generateResponse($file);
		}
	}

	/**
	 *	Handle file upload 
	 *
	 *  @param 	string  		$uploaded_file
	 * 	@param  string 		  	$name
	 *  @param 	integer 		$size
	 *  @param 	string 			$error 
	 *  @return stdClass
	 */
	protected function handleFileUpload($uploaded_file, $name, $size, $error)
	{
		$file = new stdClass();
		$file->name = $this->getFilename($name);
		$file->type = $this->getFileExtension($file->name);
		$file->size = $this->fixIntOverflow(intval($size));

		// Before upload callback
		if (isset($this->options['before_upload'])) {
			call_user_func($this->options['before_upload'], $file, $this);
		}

		$upload_path = $this->getUploadPath($file->name);
		$upload_dir = $this->getUploadPath();

		if (!$this->validate($uploaded_file, $file, $error)) {
			return false;
		}

		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, $this->options['mkdir_mode'], true);
		}

		if (is_uploaded_file($uploaded_file)) {
			if (!move_uploaded_file($uploaded_file, $upload_path)) {
				$this->error = $this->getErrorMessage('move_failed');
				return false;
			}
		} else {
			if (!$handle = fopen($upload_path , 'wb')) {
			   	$this->error = $this->getErrorMessage('upload_failed');
				return false;
			}
			if (!fwrite($handle, $uploaded_file)) {
			    $this->error = $this->getErrorMessage('upload_failed');
			    return false;
			}
			fclose($handle);
		}

		$this->orientImage($upload_path);
		
		list($img_width, $img_height) = getimagesize($upload_path);

		$file->path   = $upload_path;
		$file->url    = $this->getFullUrl() .'/'. $upload_path;
		$file->width  = $img_width;
		$file->height = $img_height;

		// Upload complete callback
		if (isset($this->options['upload_complete'])) {
			call_user_func($this->options['upload_complete'], $file, $this);
		}
		
		unset($file->path);

		return $file;
	}

	/**
	 * 	Validate
	 *
	 *  @param 	string  		$uploaded_file
	 * 	@param  stdClass 		$name
	 *  @param 	string 			$error 
	 *  @return boolean
	 */
	protected function validate($uploaded_file, $file, $error)
	{	
		if (!$uploaded_file) {
			$this->error = $this->getErrorMessage(4);
			return false;
		}

		if ($error) {
			$this->error = $this->getErrorMessage($error);
			return false;
		}

		$content_length = $this->fixIntOverflow(intval($_SERVER['CONTENT_LENGTH']));
        $post_max_size  = $this->getConfigBytes(ini_get('post_max_size'));
        
        if ($post_max_size && $content_length > $post_max_size) {
            $this->error = $this->getErrorMessage('post_max_size');
            return false;
        }

        if ($this->options['max_file_size'] && $file->size > $this->options['max_file_size']) {
        	$this->error = $this->getErrorMessage('max_file_size');
            return false;
        }

        if ($this->options['min_file_size'] && $file->size < $this->options['min_file_size']) {
        	$this->error = $this->getErrorMessage('min_file_size');
            return false;
        }

		if (!preg_match('/.('.$this->options['accept_file_types'].')+$/i', $file->name)) {
			$this->error = $this->getErrorMessage('accept_file_types');
			return false;
		}

		$max_width  = @$this->options['max_width'];
        $max_height = @$this->options['max_height'];
        $min_width  = @$this->options['min_width'];
        $min_height = @$this->options['min_height'];
        
        if ($max_width || $max_height || $min_width || $min_height) {
        	if (is_uploaded_file($uploaded_file)) {
        		list($img_width, $img_height) = getimagesize($uploaded_file);
        	} else {
        		$img = @imagecreatefromstring($uploaded_file);
        		$img_width  = @imagesx($img);
        		$img_height = @imagesy($img);
        	}
        }

        if (!empty($img_width)) {
            if ($max_width && $img_width > $max_width) {
                $this->error = $this->getErrorMessage('max_width').$max_width.'px';
                return false;
            }
            if ($max_height && $img_height > $max_height) {
                $this->error = $this->getErrorMessage('max_height').$max_height.'px';
                return false;
            }
            if ($min_width && $img_width < $min_width) {
                $this->error = $this->getErrorMessage('min_width').$min_width.'px';
                return false;
            }
            if ($min_height && $img_height < $min_height) {
                $this->error = $this->getErrorMessage('min_height').$min_height.'px';
                return false;
            }
        } else {
        	$this->error = $this->getErrorMessage('invalid_image');
            return false;
        }

        return true;
	}

	/**
	 *	Crop action 
	 *
	 * @return void
	 */
	protected function crop()
	{
		$crop = new stdClass();

		$crop->file_name = basename(@$_POST['image']);
		$crop->file_type = $this->getFileExtension($crop->file_name);
		
		$crop->src_path = $this->getUploadPath($crop->file_name);
		$crop->dst_path = $crop->src_path;

		if (!file_exists($crop->src_path)) {
			$this->error = $this->getErrorMessage('not_exists');
			return false;
		}
		
		if (!preg_match('/.('.$this->options['accept_file_types'].')+$/i', $crop->file_name)) {
			$this->error = $this->getErrorMessage('accept_file_types');
			return false;
		}

		@list($crop->src_x, $crop->src_y, $x2, $y2, $crop->src_w, $crop->src_h) = @array_values(@$_POST['coords']);

		if (empty($crop->src_w) || empty($crop->src_h)) {
			list($crop->src_w, $crop->src_h) = getimagesize($crop->src_path);
			$min = min($crop->src_w, $crop->src_h);

			if (empty($crop->src_x) && empty($crop->src_y)) {
				$crop->src_x = ($crop->src_w - $min)/2;
				$crop->src_y = ($crop->src_h - $min)/2;	
			}

			$crop->src_w = $crop->src_h = $min;
		}

		$crop->dst_w = $crop->src_w; 
		$crop->dst_h = $crop->src_h;
		
		$max_width  = $this->options['crop_max_width'];
		$max_height = $this->options['crop_max_height'];
		
		if (!empty($max_width)) {
			if ( ($crop->src_w > $max_width) || ($crop->src_w < $max_width && $this->options['force_crop']) ) {
				$crop->dst_w = $max_width;
				$crop->dst_h = $crop->src_h / $crop->src_w * $max_width;
			}
		}
		if (!empty($max_height)) {
			if ( ($crop->src_h > $max_height) || ($crop->src_h < $max_height && $this->options['force_crop']) ) {
				$crop->dst_h = $max_height;
				$crop->dst_w = $crop->src_w / $crop->src_h * $max_height;
			}
		}

		// Before crop callback
		if (isset($this->options['before_crop'])) {
			call_user_func($this->options['before_crop'], $crop, $this);
		}

		$this->resizeImage($crop->src_path, $crop->dst_path, $crop->src_x, $crop->src_y, 
					$crop->dst_w, $crop->dst_h, $crop->src_w, $crop->src_h);
		
		$image = new stdClass();
		$image->name = $crop->file_name;
		$image->url  = $this->getFullUrl() .'/'. $crop->dst_path;
		$image->path = $crop->dst_path;
		$image->type = $crop->file_type;
		$image->width  = ceil($crop->dst_w);
		$image->height = ceil($crop->dst_h);

		// Crop complete callback
		if (isset($this->options['crop_complete'])) {
			call_user_func($this->options['crop_complete'], $image, $this);
		}
		
		unset($image->path);

		// Generate json response
		$this->generateResponse($image);
	}

	/**
	 * 	Resize image
	 *
	 *  @param 	string  		$src_path 	Source image path
	 *  @param 	string|null  	$dst_path 	Destination image path
	 *  @param 	integer  		$src_x 		x-coordinate of source point
	 *  @param 	integer  		$src_y 		y-coordinate of source point
	 *  @param 	integer  		$dst_w 		Destination width
	 *  @param 	integer  		$dst_h 		Destination height
	 *  @param 	integer  		$src_w 		Source width
	 *  @param 	integer  		$src_h 		Source height
	 *  @return void
	 */
	public function resizeImage($src_path, $dst_path = null, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
	{
		$src_x = ceil($src_x);
		$src_y = ceil($src_y);
		$dst_w = 520;
		$dst_h = 520;
		$src_w = ceil($src_w);
		$src_h = ceil($src_h);

		$dst_path  = ($dst_path) ? $dst_path : $src_path;
		$dst_image = imagecreatetruecolor($dst_w, $dst_h);
		$extension = $this->getFileExtension($src_path);

		switch ($extension) {
	        case 'gif':
	            $src_image = imagecreatefromgif($src_path); 
	        break;
	        case 'jpeg':
	        case 'jpg':
	            $src_image = imagecreatefromjpeg($src_path); 
	        break;
	        case 'png':
	        	imagealphablending($dst_image, false);
				imagesavealpha($dst_image, true);  
	            $src_image = imagecreatefrompng($src_path);
	            imagealphablending($src_image, true);
	        break;
	    }

	    imagecopyresampled($dst_image, $src_image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

		switch ($extension) {
	         case 'gif':
	            imagegif($dst_image, $dst_path);
	        break;
	        case 'jpeg':
	        case 'jpg':
	            imagejpeg($dst_image, $dst_path);
	        break;
	        case 'png':
	            imagepng($dst_image, $dst_path);
	        break;
	    }
	}

	/**
	 * 	Rotate image based on EXIF orientation data
	 *
	 *  @param 	string  		$file_path
	 *  @return void
	 */
	protected function orientImage($file_path)
	{
		if (!preg_match('/\.(jpe?g)$/i', $file_path)) return;

		if (!function_exists('exif_read_data')) return;

		$exif = @exif_read_data($file_path);
		if (!empty($exif['Orientation'])) {
		    switch($exif['Orientation']) {
		        case 3: $degrees = 180; break;
		        case 6: $degrees = -90; break;
		        case 8: $degrees = 90; break;
		    }

		    if (isset($degrees)) {
		    	$source = imagecreatefromjpeg($file_path);
		    	$image = imagerotate($source, $degrees, 0);
				imagejpeg($image, $file_path, 90);
				imagedestroy($image);
			}
		}
	}

	/**
	 * 	Get upload directory path
	 *
	 *  @param 	string 		$file_name
	 *  @return string
	 */
	public function getUploadPath($file_name = '')
	{
    	return $this->options['upload_dir'].$file_name;
    }

    /**
	 * 	Get upload directory url
	 *
	 *  @return string
	 */
    public function getFullUrl()
	{
		$https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
	    return
	        ($https ? 'https://' : 'http://').
	        (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
	        (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
	        ($https && $_SERVER['SERVER_PORT'] === 443 ||
	        $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
	        substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}

	/**
	 * 	Get file name
	 *
	 *  @return string
	 */
	public function getFilename($name)
	{
		return $this->getUniqueFilename($name);
	}

    /**
	 * 	Get unique file name
	 *
	 * 	@param  string
	 *  @return string
	 */
	public function getUniqueFilename($name)
	{
		while (is_dir($this->getUploadPath($name))) {
            $name = $this->upcountName($name);
        }
        while(is_file($this->getUploadPath($name))) {
            $name = $this->upcountName($name);
        }
        return $name;
	}

    public function upcountName($name)
    {
        return preg_replace_callback(
            '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
            array($this, 'upcountNameCallback'),
            $name,
            1
        );
    }

    public function upcountNameCallback($matches)
    {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' ('.$index.')'.$ext;
    }

	/**
	 * 	Generate random file name
	 *
	 *  @return string
	 */
	public function getRandFilename()
	{
		return md5(time().rand());
	}

	public function getFileExtension($filename)
	{
		return pathinfo(strtolower($filename), PATHINFO_EXTENSION);
	}

	public function generateResponse($data = array(), $success = true)
	{
		echo json_encode(array('success' => $success, 'data' => $data));
	}

	public function getErrorMessage($error) {
        return array_key_exists($error, $this->error_messages) ? 
        	$this->error_messages[$error] : $error;
    }

    public function getConfigBytes($val) {
        $val  = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $this->fixIntOverflow($val);
    }

    public function fixIntOverflow($size) {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }
        return $size;
    }
}