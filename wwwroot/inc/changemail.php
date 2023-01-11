<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jasgo-Account Setting</title>
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
	<h2>Jasgo E-mail System - Account Setting</h2>
<?php
	
	
if(isset($_GET['token']))
{
	require('conn.php');
	require('functions.php');
	$demail = decry($_GET['token']);
	if(strpos($demail,'@')>0){
		$ress = mysql_query("select * from custinfo  where csmail='".$demail."' limit 1");
		if(mysql_num_rows($ress)==0){	
			echo '<div class="cls">参数错误，无法更新。</div>';
		}
		else
		{
				echo '<div class="form-inline" style="text-align:left;padding:1em;background:#f1f3f4;">
  <div class="form-group">
  <input id="bmail" type="hidden" value="'.$demail.'">	
    <label for="exampleInputEmail2">Enter your present email address</label>
    <input id="amail" type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">	
  </div> 
  <button type="button" class="btn btn-success cm">UPDATE</button>
</div>
<div id="res"></div>';				
			
		}		
	}
	elseif(strpos($demail,"&")>0){
		//bcc
		//格式：2019-03-07&bcc
		$array = explode("&",$demail);
		if($array[1]=="bcc"){
				echo '<div class="form-inline" style="text-align:left;padding:1em;background:#f1f3f4;">
  <div class="form-group">
    <label for="exampleInputEmail2">Original e-mail</label>
	<input id="vy" type="hidden" value="'.md5($array[0]).'">	
    <input id="bmail" type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">	
  </div>
  <p></p>
  <div class="form-group">
    <label for="exampleInputEmail2">Present e-mail</label>
    <input id="amail" type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">	
  </div> 
  <button type="button" class="btn btn-success cm">CHANGE</button>
</div>'.$str;
		}
	}
	else{echo $str.'<div class="cls">参数错误，无法更新。</div>';}
}
else{
	header('Location:/');
}	
	?>
	<div id="res"></div>
	<script>
$(function(){
	$(".cm").on("click",function(){
	var amail = $('#amail').val();
	var bmail = $('#bmail').val();
		
if (amail != ''&&bmail !='') {//判断
	amail=amail.replace(/\s+/g, "");
	bmail=bmail.replace(/\s+/g, "");
    var reg = /^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-zd]{2,6}$/; 
	if (!(reg.test(amail)&&reg.test(bmail))) {
		$("#res").html('<div class="cls">输入的电子邮件地址的格式不正确。</div>');
		return;
	}
	else
		{
			var vy=0;
			if($("#vy").length>0){
				vy=$("#vy").val();
			}
		$.post("changemail-bcc.php",{before:$("#bmail").val(),after:$("#amail").val(),verify:vy},function(res){
			$("#res").html(res);
		});
		}
}
	});
	
});
</script>
</body>
</html>