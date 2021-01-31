<?php 
   include('connection/database.php');
   $response = null;
   if (isset($_POST["forgot-password"])){
       if (!empty($_POST["user-email"])) {
           $email = trim($_POST["user-email"]);
       }else {
           $response = "<li>Email is required</li>";
       }
       if (empty($response)){
           $query = $db->prepare("SELECT username, email FROM registration WHERE email =?");
           $query->execute(array($email));
           $user = $query->fetchAll(PDO::FETCH_ASSOC);
       }
       if (!empty($user)){
       require_once('sendforgotmail.php');
       $response = "you have recieved an email to reset password!";
       header("Refresh:5; url=index.php");
       }else {
           $response = 'No email found';
       }
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
    <h1><i>Forgot Password</i></h1>
    <?php if (isset($response)) {?>
    <div><?php echo $response ?></div>
    <?php }?>
    <form action="" method="post">
    <table>
    <p><i>Please enter your email below:</i></p>
    <tr><td>Email:</td><td><input type="text" name="user-email" value=""></td></tr>
    <tr><td><br><input type="submit" name="forgot-password" value="Submit"></td></tr>
    </table>
    </form>
    <?php include 'support/footer.php';?>
</body>
</html>