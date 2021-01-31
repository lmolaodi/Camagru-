<?php 
if (session_status() == PHP_SESSION_NONE)
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel = "stylesheet" type = "text/css" href = "css/styles.css">
</head>
<body>
<div class="menu">
<ul>
    <ul>
        <li><a class="active" href="gallery.php">Home</a></li>
        <?php if (isset($_SESSION['login'])) :?>
        <li style = "float:right"><a href="#"><?php echo $_SESSION['login']['username'];?></a><li>
        <li><a href="profile.php">User Details</a></li>
        <li><a href="camagru.php">Camagru</a></li>
        <li><a href="view.php">User Profile</a></li>
        <li><a href="resetpassword.php">Reset Password</a></li>
        <li><a href="update_details.php">Update Details</a></li>
        <li style="float:right"><a href="logout.php">Logout</a></li>

        <?php else: ?>
        <li><a href="index.php">Login</a></li>
        <li><a href="registration.php">Signup</a></li>
        <?php endif; ?>
    </ul>
</ul>
</div>
</body>
</html>