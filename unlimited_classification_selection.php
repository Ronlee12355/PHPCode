<?php
	include('db_inc.php');
	function getLists(MySQLi $mysqli,$i=0,&$result=array(),$space=0){
		$space+=2;
		$sql="select * from deepcate where pid=?";
		$smtm=$mysqli->prepare($sql);
		$smtm->bind_param('i',$i);
		$smtm->bind_result($id,$pid,$catename,$cateorder,$catetime);
		if($smtm->execute()){
			$smtm->store_result();
			while ($smtm->fetch()) {
				$catename=str_repeat("&nbsp;&nbsp;", $space).'|--'.$catename;
				$result[]=compact('id','pid','catename','cateorder','catetime');
				getLists($mysqli,$id,$result,$space);
			}
			return $result;
			$smtm->close();
		}else{
			die('查询失败'.$smtm->error);
		}
		$mysqli->close();
	}
	function displayDeep(MySQLi $mysqli,$select=1){
		$res=getLists($mysqli);
		$str='';
		$s='';
		$str.='<select name="cate">';
		foreach($res as $k=>$v){
			if($v['id']==$select){
				$s='selected';
			}
			$str.="<option selected='{$s}'>{$v['catename']}</option>";
		}
		return $str.='</select>';
	}
	echo displayDeep($mysqli,4);
?>
