<?php
	$mysqli=new mysqli("localhost","xxxxx",'xxxxx','xxxxx');//your mysql config infomation
	$mysqli->set_charset('utf8');
	$sql="select gene,entrezID,disease from gene_disease limit 0,200";
	$result=$mysqli->query($sql);
	$rows=array();
	$data=array();
	if($result && $result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$rows[]=$row;
			//$rows=array($row['gene'],$row['entrezID'],$row['disease']);
			//array_push($data,$rows);//这样的话后面就不需要进行配置columns了
			
		}
	}
	$result->free();
	$mysqli->close();
	$data=json_encode($rows);
	
?>
<!DOCTYPE html HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="UTF-8">
		<title>Datatable Demo</title>
		<link href="./js/jquery-ui-1.12.1/dataTables.jquery-ui.css" rel="stylesheet" type="text/css" media="all">
		<link href="./js/jquery-ui-1.12.1//dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="./js/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="all">
		
		<meta name="keywords" lang="EN" CONTENT="drug,pridiction,target-genetic,disease,target"/>
		<script type="text/javascript" charset="utf-8" src="./js/jquery-1.12.4.js"></script>
		<script type="text/javascript" charset="utf-8" src="./js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="./js/dataTables.jqueryui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="./js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="./js/buttons.flash.min.js"></script>

		<style type="text/css">
			td{
			    text-align:center;
			}
		</style>
	</head>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#table_1").DataTable({
				dom:'Bfrtip',
				data:<?php echo ($data);?>,
				"paging":true,
				"info":true,
				buttons:['copy','excel','csv'],
				columns: [//使用对象数组，一定要配置columns，告诉 DataTables 每列对应的属性
        					//data 这里是固定不变的，gene,disease 为你数据里对应的属性
			            { data: 'gene' },
			            { data: 'entrezID' },
			            { data: 'disease' }
			        ],
			       
				scrollY: 400
			});
		});
	</script>
	<body>
		<table cellspacing="0" cellpadding="0" id="table_1">
			<thead>
				<tr>
					<th>gene</th>
					<th>entrezID</th>
					<th>disease</th>
				</tr>
				<tbody></tbody>
			</thead>
		</table>
	</body>
</html>
