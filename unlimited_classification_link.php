<?php
	include('db_inc.php');
	function likeCate(MySQLi $mysqli){
		$sql="select id,path,catename,concat(path,',',id) as fullpath from phonecate order by fullpath";
		$res=$mysqli->query($sql);
		if($res && $res->num_rows>0){
			$result=array();
			while ($row=$res->fetch_assoc()) {
				$deepLength=sizeof(explode(',',trim($row['fullpath'],',')));
				$row['catename']=str_repeat('&nbsp;&nbsp;',$deepLength*4).'|--'.$row['catename'];
				array_push($result,$row);
			}
		}
		return $result;
		$res->free();
		$mysqli->close();
	}
	$res=likeCate($mysqli);
?>
<select name="cate">
	<?php
		foreach($res as $k=>$v){
			echo "<option>{$v['catename']}</option>";
		}
		?>
</select>
<?php 
	echo '<br/>';
	?>
<?php
	function getCateByLink(MySQLi $mysqli,$id,$url='cate.php?cid='){
		$sql_1="select *,concat(path,',',id) as fullpath from phonecate where id=$id";
		$res_1=$mysqli->query($sql_1);
		$row=$res_1->fetch_assoc();
		$ids=@$row['fullpath'];
		$sql_2="select id,catename from phonecate where id in ($ids) order by id asc";
		$res_2=$mysqli->query($sql_2);
		$str='';
		while ($r=$res_2->fetch_assoc()) {
			$str.="<a href='{$url}{$r['id']}'>{$r['catename']}</a>>>";
		}
		$res_1->free();
		$res_2->free();
		$mysqli->close();
		return $str;
	}
	echo getCateByLink($mysqli,4);
	?>
