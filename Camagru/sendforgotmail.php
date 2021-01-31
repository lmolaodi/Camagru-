<?php
include("forgot-password-mail.php");

$email = $email;
$key = password_hash($email, PASSWORD_DEFAULT);
ft_sendmail($email, $key);
?>