<?php 
include 'support/nav.php';
error_reporting(0);
ini_set('display_errors', 0);
?>
<?php
include('connection/database.php');
$image = $_SESSION['login'];
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
        header("location: gallery.php");
    }   
}

function display_comments($id)
{
    include('connection/database.php');
    $sql = "SELECT * FROM comments WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    if ($stmt->rowCount() > 1)
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
    $sql = "INSERT INTO comments (name, comment) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $user);
    $stmt->bindParam(2, $comment);
    if ($stmt->execute())
    {
        header("location: gallery.php");
    }
}

if (isset($_POST['delete_comment'])){
    $id = $_GET['id'];
    $sql_query = "DELETE FROM comments WHERE id = $id";
    $stmt = $db->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    header("location: gallery.php");
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
    <?php foreach($images as $image): ?>
            <?php if(isset($_SESSION['login'])) : ?>
            <form action="?id=<?php echo $image['id']; ?>" method="post">
            <img style="width:250px; height:250px; margin-top: 50px;" src="img/<?php echo $image['image']; ?>"><br>
                <button name="like_button">like</button> likes <?php echo count_likes($image['id']); ?><br><br>
                <h3><i>Comment here:</i></h3>
                <textarea name="comment" id="" cols="30" rows="10"></textarea><br><br>
                <a href="gallery.php?id=<?php echo $image['id']; ?>"><button name="delete_comment">Delete comment</button></a>
                <button name="comment_button">comment</button>
            </form>
            <?php else : ?>
            <img style="width:250px; height:250px; margin-top: 50px;" src="img/<?php echo $image['image']; ?>"><br>
            <input type="button" value="View" onclick="window.location.href='index.php'"/>
                <?php echo 'likes: '.count_likes($image['id']) ?><br><br>
            <?php endif; ?>
    <?php display_comments($image['id']); ?>
    <?php endforeach; ?>
    </form>
    <?php include 'support/footer.php';?>
</body>
</html>