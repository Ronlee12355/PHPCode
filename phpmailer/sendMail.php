<?php
	require('path/to/class.phpmailer.php');
	require('path/to/class.smtp.php');
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->CharSet = 'utf-8';
	$mail->Port = 465;
	$mail->SMTPSecure = 'ssl';//'tls';
	$mail->Host = '';//'smtp-mail.outlook.com';
	$mail->IsHTML(FALSE);
	
	$mail->FromName = "=?utf-8?B?".base64_encode("XXXXX")."?=";
	$mail->Username = '';//'Ronlee12355@outlook.com';
	$mail->From = '';
	$mail->Password = '';
	$mail->Subject = '';
	$mail->AddAddress($email);
	$mail->AddAttachment($store_path.'/xxxxxxx.txt','xxxxxxx.txt');
	$mail->Body='XXXXXX'.PHP_EOL.'XXXXXXX';
	$mail->Send();
