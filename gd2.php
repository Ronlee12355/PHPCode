<?php
	$filename='./001.jpg';
	$fileInfo=getimagesize($filename);
	//创建一个100X100的图像
	$dst_w=200;
	$dst_h=200;
	$src_w=$fileInfo[1];	
	$src_h=$fileInfo[2];
	$dst_image=imagecreatetruecolor($dst_w, $dst_h);//创建目标画布
	$src_image=imagecreatefromjpeg($filename);
	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	header('content-type:image/png');
	imagepng($dst_image);
	imagedestroy($dst_image);
	imagedestroy($src_image);
	/*
	 * getimagesize()获得图像信息，同时检测是不是图像
	 * imagecreatetruecolor()创建一个新的画布
	 * imagecopyresampled()形成缩略图
	 * imagecreatefromjpeg()通过已有图像形成画布
	 * */
?>
