<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jasgo-Unsubcribe</title>
</head>
<link rel="stylesheet" href="../assets/panel.css">
<link rel="stylesheet" href="../assets/bootstrap.css">
<link rel="stylesheet" href="../assets/fonts/css/font-awesome.min.css">
<style>
	.form-inline{max-width: 800px;width: 90%;margin: 90px auto;text-align: center;}
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 20px auto;padding: 1em;}
	body{margin: 20px;}
	h2{background:#365DB8;color: #fff;padding: 0.5em;}
</style>
<script src="../assets/jquery.js"></script>
<script src="../assets/bootstrap.js"></script>
<body>
	<h2>Jasgo E-mail System - UNSUBRIBE</h2>
<?php
	
if(isset($_GET['token']))
{
	require('conn.php');
	require('functions.php');
	$demail = decry($_GET['token']);
	if(strpos($demail,'@')>0){
		$ress = mysql_query("select * from custinfo  where csmail='".$demail."' limit 1");
		while($rows=mysql_fetch_array($ress)){
			
			if($rows['csflag']==1){
				echo '<div class="cls"><br/>This email address has been unsubscribed!<br/>该邮件地址已经被退订！</div>';
			}
			else{
				unsub($demail);
				echo '<div class="cls"><br/>Unsubscribe successfully.<br/>退订成功。</div>';
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
    <label for="exampleInputEmail2">Enter Your email address</label>
    <input type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">
	<input id="vy" type="hidden" value="'.md5($array[0]).'">
  </div>
  <button type="button" class="btn btn-danger">UNSUBCRIBE</button>
</div><div id="res"></div>';
		}
	}
	else{echo '<div class="cls">无法退订，不正确的退订连接！</div>';}
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