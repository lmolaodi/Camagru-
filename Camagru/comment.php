<?php 
session_start();
include('connection/database.php');
$arr = $_SESSION['login'];
$name = $arr['username'];
$comment = $_POST['comment'];

if (!$arr)
{
    include("includes/auth_check.php");
}

$comment_length = strlen($comment);
if ($comment_length > 100)
{
  echo "Your commenting is too big!...";
}else {
  $sql = "INSERT INTO comments (name, comment) VALUES (?,?)";
  $stmt = $db->prepare($sql);
  $stmt->execute([$name, $comment]);
}
?>