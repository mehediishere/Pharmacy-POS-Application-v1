<?php
	function compress_image($source_url, $destination_url, $quality){
		$info = getimagesize($source_url);
		if ($info['mime'] == 'image/jpeg'){$image = imagecreatefromjpeg($source_url);}
		else if ($info['mime'] == 'image/gif'){$image = imagecreatefromgif($source_url);}
		else if ($info['mime'] == 'image/png'){$image = imagecreatefrompng($source_url);}
		imagejpeg($image, $destination_url, $quality);
		return $destination_url;
	}
	

	
	function product_upload($temp,$upload,$folder,$quality){
	
		$compressed = compress_image($temp, $upload, $quality);
		
		$yy=copy($compressed,"../../$folder/$compressed");
		
		if($yy==true){
			unlink($upload);
			//unlink("../$folder/$picname");
		}
	}
	
	function event_pic_upload($temp,$upload,$quality){
		
		$compressed = compress_image($temp, $upload, $quality);
		
		$yy=copy($compressed,"../../event/$compressed");
		
		if($yy==true){
			unlink($upload);
		}
	}
?>