<?php
//include '_res/inc_phpfunctions.php'; 
//Images watermark
/*function endsWith($currentString, $target)
  {
    $length = strlen($target);
     if ($length == 0) {
      return true;
    }

  return (substr($currentString, -$length) === $target);
 }
  if ($handle = opendir('images')) {
 while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..") {

        if (endsWith($entry,'.jpg')==0){
          echo   "<br/> $entry: is ignored.\n  ";
          continue;
        }
         echo "<br/> $entry\n  ";
   $image_path = "images/".$entry; 
   $watermark = imagecreatefrompng('wa/ap.png');   
  $watermark_width = imagesx($watermark);
  $watermark_height = imagesy($watermark);  
  $image = imagecreatefromjpeg($image_path);
  if ($image === false) {
     return false;
    }
   $tragetedImageSize = getImageSize($image_path);
  $wmPositionX = $tragetedImageSize[0]- $watermark_width - 6;
  $wmPositionY = $tragetedImageSize[1] - $watermark_height - 6;
   imagealphablending($image, true);
   imagealphablending($watermark, true);
   imagecopy($image, $watermark, $wmPositionX, $wmPositionY, 0, 0, $watermark_width, $watermark_height);
   imagejpeg($image, "images/$entry");
   imagedestroy($image);
   imagedestroy($watermark);

     }
    }
    closedir($handle);
   }
 */

/*
http://biostall.com/php-snippet-deleting-files-older-than-x-days/
$days = 7;  
$path = './logs/';  
$filetypes_to_delete = array("pdf");  
  
// Open the directory  
if ($handle = opendir($path))  
{  
    // Loop through the directory  
    while (false !== ($file = readdir($handle)))  
    {  
        // Check the file we're doing is actually a file  
        if (is_file($path.$file))  
        {  
            $file_info = pathinfo($path.$file);  
            if (isset($file_info['extension']) && in_array(strtolower($file_info['extension']), $filetypes_to_delete))  
            {  
                // Check if the file is older than X days old  
                if (filemtime($path.$file) < ( time() - ( $days * 24 * 60 * 60 ) ) )  
                {  
                    // Do the deletion  
                    unlink($path.$file);  
                }  
            }  
        }  
    }  
} */
date_default_timezone_set("Asia/Kolkata");
echo "Hey";
echo "Last modified: ".date("F d Y h:i:s A.",filemtime("_res/upload/bulk_csv/1505398718_uploaded_by_Narayan Polai_bulk_update_sample.csv"));
?>