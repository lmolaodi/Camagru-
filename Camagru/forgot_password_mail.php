<?php

function ft_sendmail($email)
{
	$to = $email;
	$subject = "Reset Password";
	$body = "Click link to reset password: ";
	$headers = "From: lmolaodi@student.wethinkcode.co.za" . "\r\n" .
	"CC: somebodyelse@example.com";

	if (mail($to,$subject,$body,$headers))
	{
		$_SESSION['user_email'] = $email;
		header("location:resetPassword.php");
	}
	else
	{
		echo "could not create account";
	}
}

?>