<?php

function ft_resize_image($image, $dst_width, $dst_height)
{
   $width = imagesx($image);
   $height = imagesy($image);
   $new_img = imagecreatetruecolor($dst_width, $dst_height);
   imagealphablending($new_img, false);
   imagesavealpha($new_img, true);
   $transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
   imagefilledrectangle($new_img, 0, 0, $width, $height, $transparent);
   imagecopyresampled($new_img, $image, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);
   return $new_img;
}
//$id_session = $_SESSION['login']['id'];
//$username_session = $_SESSION['login']['username'];
//$email_session = $_SESSION['login']['email'];
$data = file_get_contents("php://input");
$data = json_decode($data, true);
$image = explode(',', $data["image"]);
$string = base64_decode($image[1]);
$dest = imagecreatefromstring($string);
if ($string !== false) {
   //$new_file_name = ft_image_name("jpg");
   $new_file_name = uniqid().".jpg";
   if ($data["sticker"])
   {
       $sticker = "../img/".$data["sticker"];
       $src = imagecreatefrompng($sticker);
       $src_size = getimagesize($sticker);
       $src_width = $src_size[0];
       $src_height = $src_size[1];
       $src_ratio = $src_height / $src_width;
       $dest_width = 640;
       $dest_height = 480;
       $src = ft_resize_image($src, $dest_height / $src_ratio, $dest_height);
       imagecopy($dest, $src, $dest_width / 5, 0, 0, 0, $dest_height / $src_ratio, $dest_height);
       imagejpeg($dest, "../img/$new_file_name");
       imagedestroy($dest);
       imagedestroy($src);
   }
   else
   {
       imagejpeg($dest, "../img/$new_file_name");
       imagedestroy($dest);
   }
   /*
   require("inc.connect.php");
   $sql_query = "INSERT INTO images (user_id, image_name) VALUES (?, ?)";
   $stmt = $conn->prepare($sql_query);
   $stmt->bindParam(1, $id_session);
   $stmt->bindParam(2, $new_file_name);
   $stmt->execute();
   $stmt = null;
   $conn = null;
   */
   echo $new_file_name;
   exit();
}
else
{
   echo 'An error occurred.';
}
header("Location: ../");
?>