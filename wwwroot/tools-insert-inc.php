<?php 
if(isset($_POST['mlist'])&&isset($_POST['email']))
{
	require('inc/conn.php');
	$class = $_POST['mlist'];
	$email = $_POST['email'];
	mysql_query("insert ignore into custinfo (csmail) values ('".$email."')");
	$query = mysql_query("select * from custinfo where cscate='".$class."'");
	$str = '<div class="result">';
	while($row = mysql_fetch_array($query)){
		if($email==$row['csmail']){
			$str.='<div id="curp" style="padding-right:1em;">'.$row['csmail'].'</div>';
		}
		else
		{
			$str.='<div style="padding-right:1em;">'.$row['csmail'].'</div>';
		}
	}
	$str.='</div>';
	if(ckstr($email,$class)){
		$str='<div style="clear:both;height:2px;"></div><p style="padding:0.3em;">[error:'.ckstr($email,$class).']&nbsp;这个邮箱之前已经输入过了~</p>'.$str;
	}
	echo($str);
	
}

function ckstr($mailname,$classname){
	require('inc/conn.php');
	$query = mysql_fetch_array(mysql_query("select count(*) as num,cscate from custinfo where csmail='".$mailname."' and cscate<>'".$classname."'"));
	if($query['num']<=0){
		return false;
	}
	else
	{
		return $query['cscate'];
	}
}

?>