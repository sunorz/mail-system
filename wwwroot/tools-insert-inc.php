<?php 
if(isset($_POST['mlist'])&&isset($_POST['email']))
{
	require('inc/conn.php');
	$class = $_POST['mlist'];
	$email = $_POST['email'];
	mysql_query("insert into eee (邮件名,class) values ('".$email."','".$class."')");
	$query = mysql_query("select * from eee where class='".$class."'");
	$str = '<ul>';
	while($row = mysql_fetch_array($query)){
		if($row['邮件名']==$email){
			$str.= '<li><mark>'.$row['邮件名'].'</mark></li>';
		}
		else
		{
		$str.= '<li>'.$row['邮件名'].'</li>';
		}
	}
	$str.='</ul>';
	if(ckstr($email,$class)){
		$str='[error:'.ckstr($email,$class).']这个邮箱之前已经输入过了~';
	}
	echo($str);
	
}

function ckstr($mailname,$classname){
	require('inc/conn.php');
	$query = mysql_fetch_array(mysql_query("select count(*) as num,class from eee where 邮件名='".$mailname."' and class<>'".$classname."'"));
	if($query['num']<=0){
		return false;
	}
	else
	{
		return $query['class'];
	}
}

?>