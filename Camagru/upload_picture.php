<?php 
$arr = $_SESSION['login'];
$username = $arr['username'];
if (!$arr)
{
    include("includes/auth_check.php");
}

include('connection/database.php');

if(isset($_POST['submit'])){
  // Count total files
  $countfiles = count($_FILES['files']['name']);
  // Prepared statement
  $query = "INSERT INTO images (image, username) VALUES (?,?)";
  $statement = $db->prepare($query);
  // Loop all files
  for($i=0;$i<$countfiles;$i++){
    // File name
    $filename = $_FILES['files']['name'][$i];
    // Get extension
    $temp = explode(".", $filename);
    $ext = end($temp);
    // Valid image extension
    $valid_ext = array("png","jpeg","jpg");
    if(in_array($ext, $valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['files']['tmp_name'][$i],'img/'.$filename)){
        // Execute query
        $statement->execute(array($filename, $username));
      }
    }
  }
}
?>