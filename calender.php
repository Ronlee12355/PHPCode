header("content-type:text/html;charset=utf-8");
	//获取用户所需要的年，月，周
    error_reporting(E_ALL^E_NOTICE);
	$currentYear=$_GET['y']?$_GET['y']:date('Y');
	$currentMonth=$_GET['m']?$_GET['m']:date('m');
    $currentday=date('d',time());
	$daysOfMonth=date('t',strtotime("{$currentYear}-{$currentMonth}"));
	$currentWeek=date('w',strtotime("{$currentYear}-{$currentMonth}-1"));
		echo "<center>";
		echo "<h2>{$currentYear}年{$currentMonth}月</h2>";
		echo '<table border="1px" cellspacing="1" cellpadding="1" width="700px">';
		echo '<caption><h3>日历</h3></caption>';
		echo '<tr >';
		echo '<th>周日</th>';
		echo '<th>周一</th>';
		echo '<th>周二</th>';
		echo '<th>周三</th>';
		echo '<th>周四</th>';
		echo '<th>周五</th>';
		echo '<th>周六</th>';
		echo '</tr>';
		for($i=1-$currentWeek;$i<=$daysOfMonth;){
			echo "<tr>";
			for($j=0;$j<7;$j++){
				if($i>$daysOfMonth or $i<1){
					echo "<td>&nbsp;</td>";
				}else{
					echo "<td align='center'>{$i}</td>";
				}
				$i=$i+1;
			}
			echo "</tr>";
			}
			if($currentMonth==1){
				$prey=$currentYear-1;   
				$prem=12;
			}else{
				$prey=$currentYear;
				$prem=$currentMonth-1;
			}
			if($currentMonth==12){
				$aftery=$currentYear+1;
				$afterm=1;
			}else{
				$aftery=$currentYear;
				$afterm=$currentMonth+1;
			}
		echo '</table>';
		echo "<h2><a href='./WanNianLi.php?y={$prey}&m={$prem}'>上一页</a>|<a href='./WanNianLi.php?y={$aftery}&m={$afterm}'>下一页</a></h2>";
		echo '</center>';
?>
