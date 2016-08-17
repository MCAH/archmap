<?php
	

	/*
	 * IMAGE_VIEW asdf
	 *
	 */
	 
	class ImageView extends Model {
	
		function ImageView($arg1=0, $arg2=0) {
			$this->table = "imageview";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		function entityName() {
			return "ImageView";
		}









		
		
		
		// ! IMAGE VIEW THUMBNAILS
		function getFilesystemBWebPath() {
			$IBASE_PATH = "/archmap/media/imageviews";
			$id = $this->get("imageview_id");
			if ("".$id == "")
				$id = $this->get("id");
			$padded = str_pad($id,6,'0',STR_PAD_LEFT);
			// the first folder
			$folder1 = substr($padded,0,3);
			$file_path = $IBASE_PATH."/".$folder1;
			
			return 	$file_path;
		}
		function getFilePath() {
			return 	$_SERVER["DOCUMENT_ROOT"] . $this->getFilesystemBWebPath();
		}
		function makeOneoffPath() {
		 	// need to save changes first
			$IBASE_PATH = $_SERVER["DOCUMENT_ROOT"]."/archmap/media/imageviews";
			$id = $this->get("id");
			$padded = str_pad($id,6,'0',STR_PAD_LEFT);
			
			// the folder
			$folder1 = substr($padded,0,3);
			$file_path = $IBASE_PATH."/".$folder1;
			if(!is_dir($file_path)) {
				mkdir($file_path,0777);
			}
			
			return $file_path;
		}
		
		function makeOneoffIcons($original) {
			logIt("Make one off icons 1: ". $original);
			
		
			$filedims = $this->grab_data_from_imagefile($original);
			
			
			logIt("width".$filedims['width']);
			logIt($filedims['height']);
			logIt($filedims['mimetype']);
				
			$this->set("width", $filedims['width']);
			$this->set("height", $filedims['height']);
			$this->set("mimeytpe", $filedims['mimetype']);
				
				
			//$this->set("width", 300);
			//$this->set("height", 300);
			$this->set("mimeytpe", 2);
					
			
			
			
			$ext = $this->determineFileExtension($this->get("mimetype"));
			
			
			
			logIt("Makeone off icons 2: ". $original);
			
			$path = $this->makeOneoffPath();
			
			logIt("Makeone off icons 3: ". $path);
		 	$newfile = $path."/".$this->get("id")."_full.$ext";
		 	
		 	logIt("Makeone off icons 4: ". $newfile);
			//println('copying to: ' . $newfile);
			copy($original,$newfile);
			//chmod($newfile,0777);
			$max = ($this->get('width') > $this->get('height')) ? $this->get('width') : $this->get('height');
			
			logIt("Makeone off icons 5: ". $max);
			
			
			
			/*
			$files = glob($path.'/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file)) {
				  logit('delete ' . $file . ', ');
				  unlink($file); // delete file
				  
			  }
			    //unlink($file); // delete file
			}
			*/
			
			if ($max >=  300) $this->makeOneoffIcon($original, 300, $path, $ext);
			if ($max >=  100) $this->makeOneoffIcon($original, 100, $path, $ext);
			if ($max >=   50) $this->makeOneoffIcon($original, 50, $path, $ext);
		}
		
		
	



		
		function makeOneoffIcon($original, $size, $path, $ext) {
		
					

			// determine fileending from mimetype
			$newfilename = $path."/".$this->get("id")."_".$size.".".$ext;
			//echo $newfilename."\n";
			
			logIt("Make one off icons: " .$original.', '. $newfilename);
			
			ini_set("max_execution_time", "8000");
			ini_set("memory_limit", "512M");



			$w = $this->get('width');
			$h = $this->get('height');

			if ($w > $h) {
				$nw = $size;
				$nh = $h * ( $nw / $w);
			} else {
				$nh = $size;
				$nw = $w * ( $nh / $h);
			}
			logIt("Make one off icons: nw=". $nw . ', nh='.$nh . ', w='.$w.', h='.$h.', ext='. $ext);
		
			$dest = imagecreatetruecolor($nw,$nh);
			logIt("dest=".$dest);
			
			if($ext == "jpg") {
				
				$src = imagecreatefromjpeg($original);
				logIt('making the image as jpg: src='.$src);
				imagecopyresampled($dest,$src, 0,0, 0,0, $nw,$nh, $w,$h);
				imagejpeg($dest, $newfilename);
			}
			elseif($ext == "gif") {
				$src = imagecreatefromgif($original);
				imagecopyresampled($dest,$src, 0,0, 0,0, $nw,$nh, $w,$h);
				imagegif($dest, $newfilename);
			}
			elseif($ext == "png") {
				$src = imagecreatefrompng($original);
				imagecopyresampled($dest,$src, 0,0, 0,0, $nw,$nh, $w,$h);
				imagepng($dest, $newfilename);
			}
			
		
			chmod($newfilename,0777);
		}





		function determineFileExtension($mimetype) {
			switch($mimetype) {
				case 1:
					return "gif";
				case 2:
					return "jpg";
				case 3:
					return "png";
				default:
					return "jpg";
			}
		}


		function grab_data_from_imagefile($image_path) {
		logIt("grabbing data from ".$image_path);
			$dimens = GetImageSize($image_path);
			$attrs['size'] = filesize($image_path);
			$attrs['width'] = $dimens[0];
			$attrs['height'] = $dimens[1];
			$attrs['mimetype'] = $dimens[2];
			return $attrs;
		}
		
	}

?>