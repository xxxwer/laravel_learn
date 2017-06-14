<meta charset="utf-8">
排序

<form class="" action="" method="post">
	<input type="number" name="number_1" value="">
	<input type="number" name="number_2" value="">
	<input type="number" name="number_3" value="">
	<input type="submit" value="submit">
</form>

<?php

$number[] = $_POST['number_1'];
$number[] = $_POST['number_2'];
$number[] = $_POST['number_3'];

print_r($number);

$number_s = $number;
$number = array();

while(!empty($number_s)){
	setBiggest($number_s);
	$number[] = array_pop($number_s);
}



function setBiggest(&$number)
{
	foreach ($number as $key1 => $value1) {
		if (empty($number[$key1 + 1])) {
			break;
		}
		if ($number[$key1] > $number[$key1 + 1] ) {
			exchange($number[$key1], $number[$key1 + 1]);
		}
	}
}



function exchange(&$value1, &$value2)
{
	$temp = $value1;
	$value1 = $value2;
	$value2 = $temp;
}
echo $number[2].'<'.$number[1].'<'.$number[0];
