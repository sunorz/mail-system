<?php 
if(isset($_POST['email']))
{
	
	require('inc/conn.php');
	$email = $_POST['email'];
	if(!ckstr($email)){
		$str='<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">[error:f404]&nbsp;这个邮箱之前已经被禁用~</p>'.$str;
	}
	else
	{
	mysql_query("UPDATE custinfo set csflag=1 where csmail = '".$email."' LIMIT 1;");
	$str='<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">成功禁用：'.$email.'</p>';		
	}
	echo($str);
	
}

function ckstr($mailname){
	require('inc/conn.php');
	$num = mysql_num_rows(mysql_query("select * from custinfo where csmail='".$mailname."' and csflag=0 limit 1"));
	if($num==0){
		return false;
	}
	else
	{
		return true;
	}
}

?>