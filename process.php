<?php
	//处理基本系统信息
	date_default_timezone_set('PRC');
	set_time_limit(0);
	error_reporting(0);
	if(PHP_OS == 'WINNT'){
		define('__ROOT__', str_replace('\\', '/', dirname(__DIR__)));
	}elseif(PHP_OS == 'Linux'){
		define('__ROOT__', dirname(__DIR__));
	}
	
	//引入文件，生成日期字符串
	$result=array();
	$output=array();
	$date=date('YmdHis',time());
	include('function.php');
	$config=include('config.php');
	
	
	
	if(!isset($_POST['ctl'])){
		$input_url=__ROOT__.'/'.$config['INPUT_URL'].'/'.$date;
		$output_url=__ROOT__.'/'.$config['OUTPUT_URL'].'/'.$date;
		mkdir($input_url,0777,TRUE);
		mkdir($output_url,0777,TRUE);
		touch($output_url.'/'.'output.txt');
		if(!check_upload($_FILES['input_file'])){
			$result['status']=0;
			$result['message']='Upload file error';
			echo json_encode($result);
			exit;
		}
		$destion=$input_url.'/'.$_FILES['input_file']['name'];
		move_uploaded_file($_FILES['input_file']['tmp_name'], $destion);
		exec(escapeshellcmd(sprintf('%s %s "%s" "%s"',$config['PYTHON'],__ROOT__.'/'.$config['PYTHON_SCRIPT'],)));
		$content=fopen($output_url.'/'.'output.txt', 'r');
		while(!feof($content)){
			$line=explode("\t", trim(fgets($content)));
			array_push($output,array('Drug'=>$line[0],'p-value'=>$line[1]));
		}
		fclose($content);
		$result['status']=1;
		$result['content']=$output;
		echo json_encode($result);
		exit;
		
	}elseif($_POST['ctl'] == 'on' && isset($_POST['ctl'])){
		$input_url=__ROOT__.'/'.$config['INPUT_URL'].'/'.$date;
		$output_url=__ROOT__.'/'.$config['OUTPUT_URL'].'/'.$date;
		$control_url=__ROOT__.'/'.$config['CONTROL_URL'].'/'.$date;
		mkdir($input_url,0777,TRUE);
		mkdir($output_url,0777,TRUE);
		mkdir($control_url,0777,TRUE);
		touch($output_url.'/'.'output.txt');
		if(!check_upload($_FILES['input_file']) || !check_upload($_FILES['control_file'])){
			$result['status']=0;
			$result['message']='Upload file error';
			echo json_encode($result);
			exit;
		}
		$destion=$input_url.'/'.$_FILES['input_file']['name'];
		move_uploaded_file($_FILES['input_file']['tmp_name'], $destion);
		move_uploaded_file($_FILES['control_file']['tmp_name'], $control_url.'/'.$_FILES['control_file']['name']);
		exec(escapeshellcmd(sprintf('%s %s "%s" "%s" "%s" "%s"',$config['PYTHON'],__ROOT__.'/'.$config['PYTHON_SCRIPT'],
							$disease,$destion,$control_url.'/'.$_FILES['control_file']['name'],$output_url.'/'.'output.txt')));
											
		$content=fopen($output_url.'/'.'output.txt', 'r');
		while(!feof($content)){
			$line=explode("\t", trim(fgets($content)));
			array_push($output,array('Drug'=>$line[0],'p-value'=>$line[1]));
		}
		fclose($content);
		$result['status']=1;
		$result['content']=$output;
		echo json_encode($result);
		exit;
	}
	