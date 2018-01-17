<?php 
if(isset($_POST['mlist']))
{
	require('inc/conn.php');
	$class = $_POST['mlist'];
	$query = mysql_query("select * from eee where class='".$class."'");
	$str = '';
	while($row = mysql_fetch_array($query)){
		$str.= $row['邮件名'].';';
	}
	echo($str);
	
}
?>