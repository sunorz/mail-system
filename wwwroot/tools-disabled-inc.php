<?php
if(isset($_POST['email'])&&isset($_POST['flag'])){
	require('inc/conn.php');
	$email = $_POST['email'];
	mysql_query("insert ignore into custinfo (csmail) values ('".$email."');");
	mysql_query("UPDATE custinfo set csflag=1 where csmail = '".$email."' LIMIT 1;");
	die('<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">我不仅仅帮你把这个邮件地址输入了数据库，而且我还把它禁用了，开心吗？'.$email.'</p>');
}

if(isset($_POST['email']))
{
	
	require('inc/conn.php');
	$email = $_POST['email'];
ckstr($email);
	
}

function ckstr($mailname){
	require('inc/conn.php');
	$res2 = mysql_query("select * from custinfo where csmail='".$mailname."' limit 1");
	$num2 = mysql_num_rows($res2);
	if($num2>0){
		$row = mysql_fetch_array($res2);
		if($row['csflag']==0){
			//成功禁用balabala
			mysql_query("UPDATE custinfo set csflag=1 where csmail = '".$mailname."' LIMIT 1;");
			echo '<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">成功禁用：'.$mailname.'</p>';
			exit();
		}
		else{
			//已经被禁用，无需重复此操作balabala
			echo '<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">已经被禁用，无需重复此操作：'.$mailname.'</p>';
			exit();
		}
	}
	else{
		//根本就没有这个邮件地址
		echo '<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">根本就没有这个邮件地址：<span id="c_mail">'.$mailname.'</span>。你确认继续禁用吗？<a href="#" id="c_disable">[继续]</a></p>';
		exit();
	}

}

?>