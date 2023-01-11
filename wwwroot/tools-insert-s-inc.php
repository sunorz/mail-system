<?php 
if(isset($_POST['keywds']))
{
	
	require('inc/conn.php');
	mysql_query('set names utf8');
	$email = $_POST['keywds'];
	if(strpos($email,'%')=='')
	{	
	$email = str_replace('_','\_',$email);
    $qstr = "select * from custinfo where csmail like '%".$email."%' limit 5";	
	$query = mysql_query($qstr);
	if(mysql_num_rows($query))
	{
	$str = '<div class="result"><div>你可能想输入：</div>';
	while($row = mysql_fetch_array($query)){		
			$str.='<div>'.$row['csmail'].'   <i style="color:orange;padding-right:1em;">'.$row['cscate'].'</i></div>';
		}		
	}
	$str.='</div>';
	echo($str);
		
		
	}
	}
	

?>