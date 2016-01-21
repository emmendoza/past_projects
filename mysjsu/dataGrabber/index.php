<?php
$homepage = file_get_contents('inputData.txt');
//echo $homepage;
$skuList = explode(PHP_EOL,  $homepage);
//echo "<br>";
//var_dump($skuList);
$total = count($skuList);
$x = 1;/*
file_put_contents('class.txt', "");
file_put_contents('section1.txt', "");
file_put_contents('section2.txt', "");
file_put_contents('days.txt', "");
file_put_contents('start.txt', "");
file_put_contents('end.txt', "");
file_put_contents('room.txt', "");
file_put_contents('instructor.txt', "");
file_put_contents('meeting.txt', "");*/
$class="";
$section1="";
$section2="";
$days="";
$start="";
$end="";
$room="";
$instructor="";
$meeting="";
for($i=0; $i < $total; $i++){
	if(startsWith($skuList[$i], 'Notes:'))
		$x=0;
	if($x == 2)
		$class.=$skuList[$i]."\r\n";
	if($x == 3)
		$section1.=$skuList[$i]."\r\n";
	if($x == 4)
		$section2.=$skuList[$i]."\r\n";
	if($x == 5){
		$daysNtime = explode(" ",  $skuList[$i]);
		$days.=$daysNtime[0]."\r\n";
		$start.=$daysNtime[1]."\r\n";
		$end.=$daysNtime[3]."\r\n";
	}
	if($x == 6)
		$room.=$skuList[$i]."\r\n";
	if($x == 7)
		$instructor.=$skuList[$i]."\r\n";
	if($x == 8)
		$meeting.=$skuList[$i]."\r\n";
	$x++;
	if($x == 12)
		$x=1;
}
echo "Completed";
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
?>
<!DOCTYPE html>
<html>
<body>
	<table>
		<tr>
			<td>
<textarea rows="20" cols="10">
<?php echo $class ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="10">
<?php echo $section1 ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="10">
<?php echo $section2 ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="10">
<?php echo $days ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="10">
<?php echo $start ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="10">
<?php echo $end ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="25">
<?php echo $room ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="25">
<?php echo $instructor ?>
</textarea>
	</td>
				<td>
<textarea rows="20" cols="25">
<?php echo $meeting ?>
</textarea>
	</td>
</tr>
</table>


</body>
</html>