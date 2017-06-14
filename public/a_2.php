<?php
$number[] = 1;
$number[] = 2;
$number[] = 3;
$number[] = 4;
// $number[] = 5;

$count = 0;
everyNumber($number, $count, -1);

function everyNumber($number, &$count, $unset_key)
{
	$result = array();
	foreach ($number as $key1 => $value1) {
		$temp = $number;
		if ($key1 > $unset_key) {
			unset($temp[$key1]);
			$unset_key = $key1;
		}
		else {
			continue;
		}

		if (count($temp) == 3) {
			// showNumber($result, $temp, $count);
			threeNumber($temp, $result, $count);
		}
		else {
			everyNumber($temp, $count, $unset_key);
		}
	}
}

// threeNumber($number, $result, $count);



function showNumber(&$result, $number, &$count, $number_count)
{
	foreach ($number as $key1 => $value1) {
		$temp = $number;
		$result[] = $temp[$key1];
		unset($temp[$key1]);
		if (empty($temp)) {
			print_r($result);
			// foreach ($result as $key2 => $value2) {
			// 	echo $value2;
			// }
			echo '<hr>';
			$count += 1;
			$result = array();
		}
		else{
			showNumber($result, $temp, $count);
		}
	}
}


function threeNumber($number, &$result, &$count)
{
	foreach ($number as $key1 => $value1) {
		$result[] = $value1;
		$temp = $number;
		unset($temp[$key1]);
		if (empty($temp) && count($result) == 3 ) {
			echo $result[0].$result[1].$result[2];
			echo "<hr>";
			$count += 1;
			echo $result[0].$result[2].$result[1];
			echo "<hr>";
			$count += 1;
			$result = array();
			break;
		}
		else if (count($result) < 3 && empty($temp) ) {
			$result = array();
			break;
		}
		else{
			threeNumber($temp, $result, $count);
		}
	}
}


echo '<hr>total:'.$count;
