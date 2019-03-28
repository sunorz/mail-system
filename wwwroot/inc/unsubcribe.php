<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email</title>
</head>
<link rel="stylesheet" href="../assets/panel.css">
<link rel="stylesheet" href="../assets/bootstrap.css">
<link rel="stylesheet" href="../assets/fonts/css/font-awesome.min.css">
<style>
	.form-inline{max-width: 800px;width: 90%;margin: 90px auto;text-align: center;}
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 0 auto;padding: 1em;}
</style>
<script src="../assets/jquery.js"></script>
<script src="../assets/bootstrap.js"></script>
<body>
<?php
if(isset($_GET['token']))
{
	$token = $_GET['token'];
	require('conn.php');
	require('phpmailer.php');
	$mail = new ToolUtils();
	$demail = $mail->decry($_GET['token']);
	if(strpos($demail,'@')>0){
		$ress = mysql_query("select csmail from custinfo  where csmail='".$demail."' limit 1");
		var_dump($ress);
		while($rows=mysql_fetch_array($ress)){
			
			if($rows['cflag']==1){
				echo '<div class="cls">(error:0x72000)此邮件已经退订！</div>';
			}
			else{
						
				$mail->unsub($demail);
				echo '<div class="cls">退订成功。</div>';
			}
		}		
	}
	elseif(strpos($demail,"&")>0){
		//bcc
		//格式：2019-03-07&bcc
		$array = explode("&",$demail);
		if($array[1]=="bcc"){
			echo '<div class="form-inline">
  <div class="form-group">
    <label for="exampleInputEmail2">Email</label>
    <input type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">
	<input id="vy" type="hidden" value="'.md5($array[0]).'">
  </div>
  <button type="button" class="btn btn-danger">退订</button>
</div><div id="res"></div>';
		}
	}
	else{echo '<div class="cls">(error:0x71000)无法退订，不正确的退订连接！</div>';}
}
else{
	header('Location:/');
}

//处理bcc退订
?>
<script>
$(function(){
	$(".btn-danger").on("click",function(){
	var mail = $('.form-control').val();
if (mail != '') {//判断
    var reg = /^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-zd]{2,6}$/; 
	if (!reg.test(mail)) {
		$("#res").html('<div class="cls">(error:0x01000)邮箱格式错误！</div>');
		return false;
	}
	else
		{
		$.post("unsubcribe-bcc.php",{addr:mail,verify:$("#vy").val()},function(res){
			$("#res").html(res);
		});
		}
}
	});
	
});
</script>
</body>
</html>