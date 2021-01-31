<?php 
session_start();
include('helper/function.php');
include('helper/sendmail.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Basics</title>
	<link rel = "stylesheet" type = "text/css" href = "css/styles.css">
</head>
<body>
	<?php include 'support/nav.php'?>
<div class = "container">
<?php
    if (isset($_SESSION['account_create'])):
        echo "<label>".$_SESSION['account_create']."</label>";
    endif;
    unset($_SESSION['account_create']);
?>
<h2>Please confirm your email</h2><hr>
    <form action="" method = "POST">
		<div>
			<input type = "text" name = "confirm_code" placeholder = "Enter code here...">
		</div><br>
		<div>
			<input type = "submit" name = "confirm" value = "confirm">
		</div>
	</form>
	<?php confirm_email(); ?>
</div>
<?php include 'support/footer.php';?>
</body>
</html>