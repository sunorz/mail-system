<?php 
if(isset($_POST['keywds']))
{
	
	require('inc/conn.php');
	$email = $_POST['keywds'];
	if(strpos($email,'%')=='')
	{	
	$email = str_replace('_','\_',$email);
    $qstr = "select * from eee where mailname like '%".$email."%'";	
	$query = mysql_query($qstr);
	if(mysql_num_rows($query))
	{
	$str = '<div class="result"><div>你可能想输入：</div>';
	while($row = mysql_fetch_array($query)){		
			$str.='<div>'.$row['mailname'].'['.$row['mailname'].']</div>';
	}
	$str.='</div>';
	echo($str);
		
		
	}
	}
	
}
?>