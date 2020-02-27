<?php
	$batch = array();
	$email = trim($_POST['email']);
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$batch['status'] = 0;
		$batch['message'] = 'Email is not valid';
		echo json_encode($batch);
		exit;
	}
	
	$error_code = $_FILES['input-file']['error'];
	$fileName = $_FILES['input-file']['name'];
	if($error_code !== 0){
		$batch['status'] = 0;
		$batch['message'] = 'File errors';
		echo json_encode($batch);
		exit;
	}
	
	if($_FILES['input-file']['type'] != 'text/plain' || strtolower(pathinfo($fileName,PATHINFO_EXTENSION)) != 'txt'){
		$batch['status'] = 0;
		$batch['message'] = 'Only txt file is allowed';
		echo json_encode($batch);
		exit;
	}
	
	if(!is_uploaded_file($_FILES['input-file']['tmp_name'])){
		$batch['status'] = 0;
		$batch['message'] = 'File upload error';
		echo json_encode($batch);
		exit;
	}
	//进入数据保存和计算部分
	if(PHP_OS == 'WINNT'){
		define('__ROOT__', str_replace('\\', '/', dirname(__DIR__)));
	}elseif(PHP_OS == 'Linux'){
		define('__ROOT__', dirname(__DIR__));
	}
	
	date_default_timezone_set('PRC');
	$store_path = __ROOT__.'/uploads/'.date('YmdHis').sha1($email);
	mkdir($store_path,0777,TRUE);
	$uploadFile = $store_path.'/'.$fileName;
	touch($store_path.'/drugFitness.txt');
	move_uploaded_file($_FILES['input-file']['tmp_name'], $uploadFile);
	$batch['status'] = 1;
	$batch['message'] = 'File uploaded successfully,check your mailbox for result';
	echo json_encode($batch);
	
	//进行文件处理
	$content = file($uploadFile);
	$drugFitness = array();
	$python_path='python';
	$file_path=__ROOT__.'/drug_fitness/fitness.py';
	foreach ($content as $line) {
		$line = rtrim($line);
		$line = str_replace('，', ',', $line);
		$line = strip_tags($line);
		$line = strtoupper(trim($line,','));
		
		$line = explode("\t", $line);
		$line[0] = intval($line[0]);
		$drugFitness[strval($line[0])] = exec(escapeshellcmd("{$python_path} {$file_path} {$line[0]} {$line[1]}"));
	}
	
	$final_result = '';
	foreach ($drugFitness as $key => $value) {
		$final_result=$final_result.$key."\t".$value.PHP_EOL;
	}
	file_put_contents($store_path.'/drugFitness.txt', $final_result);
	
	require_once __ROOT__.'/predict_script/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->CharSet = 'UTF-8';
	$mail->Port = 25;
	$mail->SMTPSecure = 'SSL';
	$mail->Host = 'smtp.mxhichina.com';
	$mail->IsHTML(false);
	
	$mail->FromName = 'DrugFitness';
	$mail->Username ='';
	$mail->From = '';
	$mail->Password = '';
	$mail->Subject = 'Prediction result from DrugFitness';
	$mail->AddAddress($email);
	$mail->AddAttachment($store_path.'/drugFitness.txt','PredictionResult.txt');
	$mail->Body='Here is your prediction result from DrugFitness,please see the attachment'.PHP_EOL.'Thank your for your support';
	?>
