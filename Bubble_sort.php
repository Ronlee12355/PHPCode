<?php
	//冒泡排序算法
	function Bubble_sort($arr){
		$len=count($arr);
		for($i=1;$i<$len;$i++){//第一层循环控制排列数
			for($k=0;$k<$len-$i;$k++){
				if($arr[$k]>$arr[$k+1]){
					$t=$arr[$k+1];
					$arr[$k+1]=$arr[$k];
					$arr[$k]=$t;
				}
			}
		}
		return $arr;
	}
	$arr=array(34,45,23,345,76,1,3,66);
	print_r(Bubble_sort($arr));
?>