<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
    <?php include 'support/nav.php'; ?>
    <h1><i><b>User Profile</b><i></h1>
<?php 
    $arr = $_SESSION['login'];
    $id = $arr['id'];

    if (!$arr)
    {
        include("includes/auth_check.php");
    }
    include 'connection/database.php';
    
    $sql = "SELECT * FROM registration WHERE id=$id";
    $result = $db->query($sql);

    if ($result->rowCount() > 0) {
    // output data of each row
        while($row = $result->fetch()) {
            echo "<br>"."username:  " . $row["username"]. "<br><br>"
            ."email:    " . $row["email"]. "<br><br>"
            ."Password: ". $row["password"]. "<br>";
        }
    } else {
        echo "0 results";
    }
?>
<br>
<?php include 'support/footer.php';?>
</body>
</html>