<?php
// $files = [
//     '/usr/share/nginx/wordpress/wp-content/themes/index.php',
//     '/usr/share/nginx/wordpress/wp-content/themes/mytheme.php',
//     '/usr/share/nginx/wordpress/wp-content/plugins/myplugin.php',
//     '/usr/share/nginx/wordpress/wp-content/plugins/akismet.php',
//     '/usr/share/nginx/wordpress/wp-content/uploads/november.jpg',
// ];
 
 
// $exclude = [
//     '/usr/share/nginx/wordpress/wp-content/uploads',
//     '/usr/share/nginx/wordpress/wp-content/plugins/myplugin.php',
// ];
// $rs = array_filter(array_diff($files, $exclude), function ($item) use ($exclude) {
//     return str_replace($exclude, '', $item) === $item;
// });
// print_r($rs);

function correctImageOrientation($filename) {
  if (function_exists('exif_read_data')) {
    $exif = exif_read_data($filename);
    if($exif && isset($exif['Orientation'])) {
      $orientation = $exif['Orientation'];
      if($orientation != 1){
        $img = imagecreatefromjpeg($filename);
        $deg = 0;
        switch ($orientation) {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }
        if ($deg) {
          $img = imagerotate($img, $deg, 0);        
        }
        // then rewrite the rotated image back to the disk as $filename 
        imagejpeg($img, $filename, 95);
      } // if there is some rotation necessary
    } // if have the exif orientation info
  } // if function exists      
}
?> 