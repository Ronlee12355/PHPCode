<?php
	function get_file($dir,&$res){
		if(is_dir($dir)){
			$handle=opendir($dir);
			while($file=readdir($handle)){
				if($file!="." && $file!=".."){
					$sub_file=$dir."/".$file;
					if(is_file($sub_file)){
						array_push($res,$sub_file);
					}else{
						$res[$sub_file]=array();
						get_file($sub_file,$res[$sub_file]);
					}
				}
			}
			closedir($handle);
			return $res;
		}else{
			die("it is not a dir");
		}
	}
	$d="E:/deep_learing_R";
	$result=array();
	var_dump(get_file($d,$result));
?>
