<?php 
if(isset($_POST['mlist'])&&isset($_POST['email']))
{
	require('inc/conn.php');
	$class = $_POST['mlist'];
	$email = $_POST['email'];
	mysql_query("insert into eee (mailname,class) values ('".$email."','".$class."')");
	$query = mysql_query("select * from eee where class='".$class."'");
	$str = '<div class="result">';
	while($row = mysql_fetch_array($query)){
		if($email==$row[2]){
			$str.='<div id="curp">'.$row[2].'</div>';
		}
		else
		{
			$str.='<div>'.$row[2].'</div>';
		}
	}
	$str.='</div>';
	if(ckstr($email,$class)){
		$str='<div style="claer:both;height:2px;"></div><p style="padding:0.3em;">[error:'.ckstr($email,$class).']&nbsp;这个邮箱之前已经输入过了~</p>'.$str;
	}
	echo($str);
	
}

function ckstr($mailname,$classname){
	require('inc/conn.php');
	$query = mysql_fetch_array(mysql_query("select count(*) as num,class from eee where mailname='".$mailname."' and class<>'".$classname."'"));
	if($query['num']<=0){
		return false;
	}
	else
	{
		return $query['class'];
	}
}

?>