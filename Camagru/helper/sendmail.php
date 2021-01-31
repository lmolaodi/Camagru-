<?php 

function ft_sendmail($email,$code)
{
	include 'connection/database.php';
	
	$to = $email;
	$subject = "My subject";
	$body = "Please use this code to verify: ".$code;
	$headers = "From: lmolaodi@student.wethinkcode.co.za" . "\r\n" .
	"CC: somebodyelse@example.com";
	if (mail($to,$subject,$body,$headers))
	{
		$_SESSION['user_email'] = $email;
		$_SESSION['account_create'] = "Your account is created";
		header("location:confirm.php");
	}
	else
	{
		echo "could not create account";
	}
}
?>