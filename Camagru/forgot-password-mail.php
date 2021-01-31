<?php 
function ft_sendmail($email, $key)
{
	$subject = "Password Recovery";
	$body = "<a target='_blank' href='http://localhost:8081/php/Camagru/resetpassword.php?email=$email&key=$key'>click link to reset password: </a>";
	$headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: <webmaster@camagru.com>\r\n";
	if (mail($email,$subject,$body,$headers))
	{
		$_SESSION['user_email'] = $email;
	}
	else
	{
        echo "Error: could not send email";
	}
}
?>