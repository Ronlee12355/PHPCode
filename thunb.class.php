<?php
	class Thumb(){
		private $_fileInfo;
		private $_filename;
		private $_path;
		private $_dst_w;
		private $_dst_h;
		private $_scale;
		private $_pre;
		private $_delOriginalImg;
		public function __construct($filename,$path='./',$dst_w=null,$dst_h=null,$scale=0.5,$pre='thumb_',$delOriginalImg=true){
			if(isset($filename) && is_file($filename) && is_readable($filename)){
				$this->_filename=$filename;
			}else{
				die('该文件不可访问');
			}
			$this->_path=$path;
			$this->_dst_w=$dst_w;
			$this->_dst_h=$dst_h;
			$this->_scale=$scale;
			$this->_pre=$pre;
			$this->_delOriginalImg=$delOriginalImg;
		}
		public function getThumbImg(){
			$this->_fileInfo=$this->_getImgInfo();
			$src_w=$this->_fileInfo['width'];	
			$src_h=$this->_fileInfo['height'];
			if(is_numeric($this->_dst_w) && is_numeric($this->_dst_h)){
				$radio=$src_w/$src_h;
				$this->_dst_w=ceil($this->_dst_w*$radio);
				$this->_dst_h=ceil($this->_dst_h*$radio);
			}else{
				$this->_dst_w=ceil($this->_dst_w*$this->_scale);
				$this->_dst_h=ceil($this->_dst_h*$this->_scale);
			}
			$dst_image=imagecreatetruecolor($this->_dst_w, $this->_dst_h);
			$src_image=$this->_fileInfo['createFun']($this->_filename);
			imagecopyresampled($dst_image, $src_image, 0,0,0,0, $this->_dst_w, $this->_dst_h, $src_w, $src_h);
			if(file_exists($this->_path)){
				mkdir($this->_path,0777,true);
			}
			$num=mt_rand(1000, 9999);
			$dstName=$this->_path.$this->_pre.$num.$this->_fileInfo['ext'];
			$this->_fileInfo['outFun']($dst_image,$dstName);
			if($this->_delOriginalImg){
				unlink($this->_filename);
			}
			imagedestroy($dst_image);
			imagedestroy($src_image);
			return $dstName;
		}
		private function _getImgInfo(){
			if(!$info=getimagesize($this->_filename)){
				die('该文件不是真实的图片');
			}
			$res['width']=$info[0];
			$res['height']=$info[1];
			$mime=image_type_to_mime_type($info[2]);
			$res['createFun']=str_replace('/', 'createfrom', $mime);
			$res['outFun']=str_replace('/', '', $mime);
			$res['ext']=strtolower(image_type_to_extension($info[2],true));
			return $res;
		}
	}
?>
