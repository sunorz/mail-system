<?php 
if(isset($_POST['mlist']))
{
	require('inc/conn.php');
	$class = $_POST['class'];
	$kwds = $_POST['email'];
	$query = mysql_query("select * from custinfo where cscate='".$class."'");
	$str = '';
	while($row = mysql_fetch_array($query)){
		$str.= $row['csmail'].';';
	}
	echo($str);
	
}
?>