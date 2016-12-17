<?php
	$filename='001.jpg';
	$fileInfo=getimagesize($filename);
	$mime=$fileInfo['mime'];
	$createFun=str_replace('/', 'createfrom', $mime);
	$outFun=str_replace('/', '', $mime);
	$image=$createFun($filename);//创建画布资源
	//$red=imagecolorallocate($image, 255, 0, 0);设置颜色
	$red=imagecolorallocatealpha($image, 255, 0, 0, 40);//可以增加虚化
	$fontfile='./TIMESBI.TTF';
	imagettftext($image, 30, 0, 0, 30, $red, $fontfile, 'my first one');
	header('content-type:'.$mime);
	$outFun($image);
	imagedestroy($image);
	/*
	 * imagecolorallocatealpha()可以用来设置文字透明度0~127
	 * imagecopymerge($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)将图片水印到另一个图片上面去
	 * 	$pct代表透明度0~100,0代表完全透明
	 * */
?>
