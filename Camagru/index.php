<?php
	include 'support/nav.php';
	include 'helper/function.php';
	include 'connection/database.php';

	$response = $username = null;

if (isset($_POST['login_submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	if (empty($username) || empty($password))
	{
		$response = "missing input!\n Please Input missing fields";
	}
	else
	{
		require('connection/database.php');
		$sql_query = "SELECT * FROM registration WHERE username = ? OR email = ? LIMIT 1";
		$stmt = $db->prepare($sql_query);
		$stmt->bindParam(1, $username);
		$stmt->bindParam(2, $username);
		if ($stmt->execute())
		{
			$user = $stmt->fetch();
			if (password_verify($password, $user['password']))
			{
				if ($user['status'] == 1)
				{
					if (!isset($_SESSION['login']))
					{
						$_SESSION['login']['id'] = $user['id'];
						$_SESSION['login']['username'] = $user['username'];
						$_SESSION['login']['email'] = $user['user_email'];
						header("location:profile.php");
					}
				}else{
					echo "Please confirm your registration";
				}
			}
			else
			{
				$response = "Incorrect Password!";
			}
		}
	}
}

?>
	<p><?php echo $response; ?></p>
	<div class="container">
	<form action="" method="post">
		<label>Email:</label><br>
		<input type="text" name="username" value="<?php echo $username; ?>"><br>
		<label>Password:</label><br>
		<input type="password" name="password"><br><br>
		<input type="submit" name="login_submit" value="login">
		<div class="form-group">
				<div><a href="forgotpassword.php">Forgotpassword ?</a></div>
			</div>
	</form>
	</div>
	<?php include 'support/footer.php';?>
</body>
</html>