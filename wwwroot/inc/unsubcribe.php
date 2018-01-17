<meta charset="utf-8">
<style>
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 0 auto;padding: 1em;}
</style>
<?php
if(isset($_GET['token']))
{
	$token = $_GET['token'];
	require('conn.php');
	require('smtp-mail.php');
	$mail = new ToolUtils();
	$demail = $mail->decry($_GET['token']);
	if(strpos($demail,'@')!=null){
		$query = mysql_query("select csmail from custinfo limit 1 where csmail='".$demail."'");
		if($query){
			$res=mysql_fetch_array($query);
			if($res['cflag']==1){
				echo '<div class="cls">(info:0x10000)该邮箱已经退订，请勿重复退订。</div>';
			}
			else{
				$mail->unsub($demail);
				echo '<div class="cls">退订成功。</div>';
			}
		}
		else
		{
			echo '<div class="cls">(error:0x20000)无法退订，请检查地址！</div>';			
		}
	}
	else{echo '<div class="cls">(error:0x71000)无法退订，不正确的退订连接！</div>';}
}
else{
	header('Location:/');
}


?>