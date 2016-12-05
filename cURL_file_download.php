<?php
	$urlobj=curl_init();
	curl_setopt($urlobj,CURLOPT_URL,'ftp://199.xxxxxx');//设置要访问的发图片地址
	curl_setopt($urlobj,CURLOPT_RETURNTRANSFER,1);//设置不要立即执行
	curl_setopt($urlobj,CURLOPT_HEADER,0);//不显示表头
	curl_setopt($urlobj, CURLOPT_USERPWD,'ronlee:123456');
	curl_setopt($urlobj,CURLOPT_TIMEOUT, 300);
	$outfile=fopen('aaa.txt','wb');
	curl_setopt($urlobj, CURLOPT_FILE, $outfile);
	$rtn=curl_exec($urlobj);
	fclose($outfile);
	if(!curl_errno($urlobj)){
		echo $rtn;
	}else{
		echo 'CURL ERROR:'.curl_error($urlobj);
	}
	curl_close($urlobj);
?>
