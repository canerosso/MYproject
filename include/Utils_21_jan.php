<?php

	require_once 'Config.php';
	/**
	* 
	*/
	class Utils 
	{
		//Method for send message to user
		public static function sendMessage($number,$msg){
               
		$ch = curl_init();
		$user="testmobi2070@gmail.com:asdasd";
		$receipientno=$number;
	    $senderID="TEST SMS";
        $msgtxt=$msg;
		curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
        $buffer = curl_exec($ch);
            if(empty ($buffer))
               { echo " buffer is empty "; }
               else
              {
               //var_dump($buffer);
               return $buffer; }
               curl_close($ch);
              }

		public static function createThumbnail($source,$destination,$quality){

			$info = getimagesize($source); 
			if ($info['mime'] == 'image/jpeg') 
				$image = imagecreatefromjpeg($source); 
			elseif ($info['mime'] == 'image/gif') 
				$image = imagecreatefromgif($source); 
			elseif ($info['mime'] == 'image/png') 
				$image = imagecreatefrompng($source); 
			imagejpeg($image, $destination, $quality); 
			return $destination; 
		}

		
		public static function uploadFileToServer($uploadPath,$file){
			//echo "in function";

			//print_r($file);
			$target_file = $uploadPath . basename($file["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$autogen = time().".".$imageFileType;	
			$rename_file = $uploadPath .$autogen;
			// Check if image file is a actual image or fake image
			
    			$check = getimagesize($file["tmp_name"]);
    			if($check !== false) 
    			{
        			//echo "File is an image - " . $check["mime"] . ".";
        			$uploadOk = 1;
    			}
				else 
				{
        			$uploadOk = 0;
        			 return TAG_FILE_NOT_IMG; 
    			}

				/*if(file_exists($target_file)) 
				{
    				$uploadOk = 0;
    				return TAG_ALREADY_EXISTS;
				}
				*/
				// Check file size
				if ($file["size"] > 500000) {
    				$uploadOk = 0;
    				return TAG_TOO_LARGE;
				}

				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" ) {
    				//"Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    				$uploadOk = 0;
    				return TAG_FILETYPE_NOT_ALLOW; 
				}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
    			//echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				return TAG_UPLOAD_ERROR;
			} 
			else 
			{
    			if (move_uploaded_file($file["tmp_name"],$rename_file)) {
        			//echo "The file ". basename($file["name"]). " has been uploaded.";
        			return $autogen;

    			}
    			else {
        			return TAG_UPLOAD_ERROR;
    			}
			}	

		}

		#* Image resize
		# * @param int $width
		# * @param int $height
		# */

		public static function uploadResizeImage($file,$imageUploadPath,$width, $height){

		  /* Get original image x y*/
		  list($w, $h) = getimagesize($file['tmp_name']);
		  /* calculate new image size with ratio */
		  $ratio = max($width/$w, $height/$h);
		  $h = ceil($height / $ratio);
		  $x = ($w - $width / $ratio) / 2;
		  $w = ceil($width / $ratio);
		  /* new file name */
		  $path = $imageUploadPath.DIRECTORY_SEPARATOR.$width.'x'.$height.'_'.$file['name'];
		  /* read binary data from image file */
		  $imgString = file_get_contents($file['tmp_name']);
		  /* create image from string */
		  $image = imagecreatefromstring($imgString);
		  $tmp = imagecreatetruecolor($w, $h);
		  imagecopyresampled($tmp, $image,
		    0, 0,
		    $x, 0,
		    $w, $h,
		    $w, $h);
		  /* Save image */
		  switch ($file['type']) {
		    case 'image/jpeg':
		      imagejpeg($tmp, $path, 100);
		      break;
		    case 'image/png':
		      imagepng($tmp, $path, 0);
		      break;
		    case 'image/gif':
		      imagegif($tmp, $path);
		      break;
		    default:
		      exit;
		      break;
		  }
		  return $path;
		  /* cleanup memory */
		  imagedestroy($image);
		  imagedestroy($tmp);
		}

           //Return current date and time
		public static function getCurrentDateTime(){
			return "".date('Y-m-d H:i:s',time());
		}

          //returns encrypted password
		public static function getEncryptedPassword($password){
			require_once 'Security.php'; 
			$security = new Security();
			$encryptedData = $security->encrypt($password, PUBLIC_KEY);
			
			return $encryptedData;
		}

            //returns decrypted password 
		public static function getDecryptedPassword($encryptedData){
			require_once 'Security.php'; 
			$security = new Security();
			$decryptedData = $security->decrypt($encryptedData, PUBLIC_KEY);
			
			return $decryptedData;
		}

		public function toArray( $object )
	    {
	        if( !is_object( $object ) && !is_array( $object ) )
	        {
	            return $object;
	        }
	        if( is_object( $object ) )
	        {
	            $object = get_object_vars( $object );
	        }
	        return array_map( 'toArray', $object );
	    }
	}

?>
