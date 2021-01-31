<?php 
session_start();
include('connection/database.php');
include 'helper/function.php';
$arr = $_SESSION['login'];
$image = $arr['id'];

if (!$arr)
{
    include("includes/auth_check.php");
}

$user = $arr['username'];
$sql = "SELECT * FROM images";
$stmt = $db->prepare($sql);
$stmt->execute(array());
$images = $stmt->fetchAll();

function count_likes($id)
{
   require('connection/database.php');
   $sql = "SELECT * FROM likes WHERE image_id = ?";
   $stmt = $db->prepare($sql);
   $stmt->bindParam(1, $id);
   $stmt->execute();
   return $stmt->rowCount();
}

if (isset($_GET['like'])){
    include('connection/database.php');
    $sql = "INSERT INTO likes (image_id, username) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $user);
    $stmt->bindParam(2, $image);
    $stmt->execute([$image, $user]);
}

if (isset($_POST['like_button']))
{
    $image = $_GET['id'];
    include('connection/database.php');
    $sql = "INSERT INTO likes (image_id, username) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $image);
    $stmt->bindParam(2, $user);
    if ($stmt->execute())
    {
        header("location: view.php");
    }   
}

function display_comments($id)
{
    include('connection/database.php');
    $sql = "SELECT * FROM comments WHERE image_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    if ($stmt->rowCount() > 0)
    {
        foreach($comments as $comment)
        {
            echo "<hr><h5>Username: ".$comment['name']."<hr></h5>";
            echo "<hr><h5>Comments:</h5><hr>";
            echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$comment['comment']."</p><hr>";
        }
    }
}

if (isset($_POST['comment_button']))
{
    $comment = $_POST['comment'];
    $image_id = $_GET['id'];
    include('connection/database.php');
    $sql = "INSERT INTO comments (image_id, name, comment) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $image_id);
    $stmt->bindParam(2, $user);
    $stmt->bindParam(3, $comment);
    if ($stmt->execute())
    {
        header("location: view.php");
    }
}
 if (isset($_POST['delete_btn']))
 {
    $id = $_GET['id'];
    require("connection/database.php");
    $sql_query = "DELETE FROM images WHERE id = ?";
    $stmt = $db->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $sql_query = "DELETE FROM likes WHERE image_id = ?";
    $stmt = $db->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $sql_query = "DELETE FROM comments WHERE id = ?";
    $stmt = $db->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    header("location: view.php");
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" type = "text/css" href = "css/styles.css">
    <title>Document</title>
</head>
<body>
    <?php include 'support/nav.php'?>
   <main>
   <section class="gallery-links">
    <div class="wrapper">
        <?php
        foreach($images as $image): ?>
        <img style="width:250px; height:250px; margin-top: 50px;" src="img/<?php echo $image['image']; ?>"><br>
        likes <?php echo count_likes($image['id']); ?><br>
            <?php if($user == $image['username']): ?>
            <form action="?id=<?php echo $image['id']; ?>" method="post">
            <a href="view.php?id=<?php echo $image['id']; ?>"><button name="delete_btn">Delete</button></a>
                <button name="like_button">like</button> likes <?php echo count_likes($image['id']); ?><br><br>
                <h3><i>Comment here:</i></h3>
                <textarea name="comment" id="" cols="30" rows="10"></textarea><br><br>
                <button name="comment_button">comment</button>
                <a href="gallery.php?id=<?php echo $image['id']; ?>"><button name="delete_comment">Delete comment</button></a>
            </form>
            <?php endif; ?>
    <?php display_comments($image['id']); ?>
    <?php endforeach; ?>
    </div>
    </div>
    </section>
   </main>
</body>
</html>