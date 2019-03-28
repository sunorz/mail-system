<meta charset="utf-8">
<script src="../assets/jquery.js"></script>
<style>
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 0 auto;padding: 1em;}
</style>
<?php
if(isset($_POST['addr'])&&isset($_POST['verify'])){
	require("conn.php");
	require('phpmailer.php');
	$query="select * from custinfo where csmail='".$_POST['addr']."'";
	$res=mysql_query($query);
	while($row=mysql_fetch_array($res)){
		if(md5($row['csdate'])==$_POST['verify'])
		{
			$mail = new ToolUtils();
			$mail->unsub($_POST['addr']);
			echo '<div class="cls">退订成功。</div>';
		}
		else
		{
			echo '<div class="cls">(error:0x72000)此邮件已经退订！</div>';
		}
	}
}
else{echo 'failure';}
?>