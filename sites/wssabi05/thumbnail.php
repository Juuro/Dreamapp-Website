<?
// Truecolorversion ab PHP Version 4.0.6
$bild = $path_img.$img ;
$tmb = $path_cache."t_".$max."_".$gal."_".$img ;
if (!isset($max)) $max = 1 ;  // wenn keine Bildgroesse angegeben, dann 1 Pixel
if (!isset($bild) || empty($bild) || !is_file($bild)) { // wenn kein Bild vorhanden
   $dest_img = imagecreate($max,$max);  //leeres transparentes Bild erzeugen
   $farbe_body=imagecolorallocate($dest_img,0,0,0);
   imagecolortransparent($dest_img,$farbe_body);
   header("Content-type: image/png");
   imagepng($dest_img);
   }
else {  //wenn Bild vorhanden ...
      $src_img = imagecreatefromjpeg($bild);  // Quellbild
      $src_img_width = imageSX($src_img);   // Thumbnailgroesse berechnen
      $src_img_height = imageSY($src_img);
      if ($src_img_width < $src_img_height)  $a = $src_img_height / $max;
      else $a = $src_img_width / $max;
      $thumbnail_width = round($src_img_width / $a);
      $thumbnail_height = round($src_img_height / $a);
      $dest_img = imagecreatetruecolor($thumbnail_width,$thumbnail_height); // Zielbild
      imagecopyresampled($dest_img,$src_img,0,0,0,0,$thumbnail_width,$thumbnail_height,imageSX($src_img),imageSY($src_img));
      header("Content-type: image/jpeg");
      if (!empty($cache)) imagejpeg($dest_img,$tmb,"65");
      imagejpeg($dest_img,"","65");
  }
?>