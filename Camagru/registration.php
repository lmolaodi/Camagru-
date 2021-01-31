<?php
session_start();
include_once('connection/setup.php');
include 'helper/function.php';
include 'helper/sendmail.php';

if (isset($_POST['create_account'])){
	$error = '';
	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$confirm = trim($_POST['confirm']);

	if (empty($username) || empty($email) || empty($password) || empty($confirm)){
		$error = "<div class'text-danger'>Please fill all required fields</div>";
	}else{
		$pattern = "/^[a-zA-Z0-9]+$/";
		if (preg_match($pattern, $username)){
			if (strlen($username) > 2){
				if (filter_var($email, FILTER_VALIDATE_EMAIL)){
					if (strlen($password) > 4 && strlen($confirm) > 4){
						if ($password == $confirm){
							$Check_email = $db->prepare("SELECT email FROM registration WHERE email =?");
							$Check_email->execute([$email]);
							if ($Check_email->rowCount() == 1){
								$error = "<div class='text-danger'>Sorry email already exits!</div>";
							}else{
								try{
							$code = rand();
							$status = 0;
							$sql = "INSERT INTO registration (username, email, password, code, status) VALUES (?,?,?,?,?)";
							$stmt = $db->prepare($sql);
							$stmt->execute([$username, $email, password_hash($password,PASSWORD_DEFAULT), $code, $status]);
							ft_sendmail($email, $code);
						}catch (PDOException $e){
							echo "Sorry :".$e->getMessage();
						}
					}
				}else{
					$error = "<div class='text-danger'>Password's do not match!</div>"."<br>";
				}
			}else{
				$error = "<div class='text-danger'>Your password is too weak!</div>"."<br>";
			}
		}else{
			$error = "<div class='text-danger'>Please enter a valid email!</div>"."<br>";
		}
		}else{
			$error = "<div class='text-danger'>Username is too short!..</div>"."<br>";
			}
		}else {
			$error = "<div class='text-danger'>invalid username</div>"."<br>";
		}
	}
	}
?>
<!DOCTYPE HTML>
	<title>Basics</title>
<head>
	<link rel = "stylesheet" type = "text/css" href = "css/styles.css">
</head>
<body>
	<?php include 'support/nav.php'?>
	<h1 align="center"><i>Camagru</i></h1>
	<div class="container" style="margin-top:50px">
	<div class="panel-heading">
		<span id="head">Create Account</span>
	</div>
	<div class="panel-body">
		<form action="" method="POST">
			<?php if(isset($error)): echo $error; endif;?>
			Username:
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Enter username" value="<?php if(isset($username)): echo $username; endif;?>">
			</div><br>
			Email:
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Enter email" value="<?php if(isset($email)): echo $email; endif;?>">
			</div><br>
			Password:
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Enter Password" value="<?php if(isset($password)): echo $password; endif;?>">
			</div><br>
			Confirm Password:
			<div class="form-group">
				<input type="password" name="confirm" class="form-control" placeholder="Confirm Password" value="<?php if(isset($confirm)): echo $confirm; endif;?>">
			</div>
			<div class="form-group"><br>
				<input type="submit" name="create_account" class="form-control" value="Create Account">
			</div>
		</form>
	</div>
</div>
</div>
<?php include 'support/footer.php';?>
</body>
</html>