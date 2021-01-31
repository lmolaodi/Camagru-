<?php include 'support/nav.php'?>
<?php
include('connection/database.php');
if(isset($_POST['update']))
{
    $arr = $_SESSION['login'];
    $id = $arr['id'];

    if (!$arr)
    {
        include("includes/auth_check.php");
    }
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "UPDATE registration SET username=?, email=?, password=? WHERE id=$id";
    $stmt= $db->prepare($sql);
    if($stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]))
    {
        echo "Update Successful";
    }else {
        echo "could not update data";
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP UPDATE DATA USING PDO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
      <h1><i>Update Details</i></h1><br>
      <div class="container">
        <form action="update_details.php" method="post">
            Username:<br><input type="text" name="username" required placeholder="Username"><br><br>
            Email:<br><input type="email" name="email" required placeholder="email"><br>
            <br>
            Password:<br><input type="password" name="password" required placeholder="password"><br><br>
            <input type="submit" name="update" required placeholder="Update Data">
        </form>
</div>
<?php include 'support/footer.php';?>
    </body>
</html>