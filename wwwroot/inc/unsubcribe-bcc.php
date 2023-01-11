<?php
if(isset($_POST['addr'])&&isset($_POST['verify'])){
	require("conn.php");
	require('functions.php');
	$query="select * from custinfo where csmail='".$_POST['addr']."'";
	$res=mysql_query($query);
	while($row=mysql_fetch_array($res)){
		if(md5($row['csdate'])==$_POST['verify'])
		{
			unsub($_POST['addr']);
			echo '<div class="cls">退订成功。</div>';
			exit();
		}
		else
		{
			echo '<div class="cls">没有这个地址，或此邮件已经退订！</div>';
			exit();
		}
	}
	echo '<div class="cls">没有这个地址，或此邮件已经退订！</div>';
}
else{echo '<div class="cls">参数错误，无法退订。</div>';}
?>