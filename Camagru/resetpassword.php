<?php include 'support/nav.php'?>
<?php
include('connection/database.php');
include("forgot-password-mail.php");

$arr = $_SESSION['login'];
$name = $arr['username'];

if (!$arr)
{
    include("includes/auth_check.php");
}

if(isset($_POST['rest-password']))
{
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm_password"]);

   if (strlen($password) > 4 && strlen($confirm) > 4)
   {
       if ($password === $confirm){
           $password = password_hash($password, PASSWORD_DEFAULT);
           $stmt = $db->prepare("UPDATE registration SET password = ? WHERE username= ?");
           $stmt->execute(array($password, $name));
           $row = $stmt->rowCount();
           if($row){
               echo "password reset successfully!";
               header("Refresh:5; url=index.php");
               header("location: logout.php");
            }else {
                echo "Error:- could not reset your password!";
            }
        }else {
            echo "Error:- Passwords do not match";
        }
    }else {
       echo "Password is to weak!...";
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
    <div id="container">
        <form action="" id="restPassword" name="resetPassword" method="post">
            <h1><i>Reset Password</i></h1>
            <?php if(!empty($success_message)) {?>
                <div class="success_message"> <?php echo $success_message ?></div>
            <?php }?>
            <?php if(!empty($error_message)) {?>
                <div class="error_message"> <?php echo $error_message ?></div>
            <?php }?>
            <h5>New Password:</h5><input type="password" name="password" id="password" placeholder="Enter new Password">
            <h5>Confirm Password:</h5><input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"><br><br>
            <input type="submit" value="Reset Password" name="rest-password" id="reset-password">
        </form>
    </div>
    <?php include 'support/footer.php';?>
</body>
</html>