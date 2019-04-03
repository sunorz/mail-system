<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jasgo Mess Mailing System</title>
</head>
<link rel="stylesheet" href="../assets/panel.css">
<link rel="stylesheet" href="../assets/bootstrap.css">
<link rel="stylesheet" href="../assets/fonts/css/font-awesome.min.css">
<style>
	.form-inline{max-width: 800px;width: 90%;margin: 90px auto;text-align: center;}
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 20px auto;padding: 1em;}
</style>
<script src="../assets/jquery.js"></script>
<script src="../assets/bootstrap.js"></script>
<body>
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
				echo '<div class="cls">(error:0x72000)此邮件已经退订！</div>';
			}
			else{
				echo '<div class="form-inline" style="text-align:left;padding:1em;background:#f1f3f4;">
  <div class="form-group">
  <input id="bmail" type="hidden" value="'.$demail.'">	
    <label for="exampleInputEmail2">新的邮箱地址</label>
    <input id="amail" type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">	
  </div> 
  <button type="button" class="btn btn-success cm">更新邮箱</button>
</div>
<div id="res"></div>';				
			}
		}		
	}
	elseif(strpos($demail,"&")>0){
		//bcc
		//格式：2019-03-07&bcc
		$array = explode("&",$demail);
		if($array[1]=="bcc"){
				echo '<div class="form-inline" style="text-align:left;padding:1em;background:#f1f3f4;">
  <div class="form-group">
    <label for="exampleInputEmail2">原本的邮箱地址</label>
	<input id="vy" type="hidden" value="'.md5($array[0]).'">	
    <input id="bmail" type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">	
  </div>
  <p></p>
  <div class="form-group">
    <label for="exampleInputEmail2">新的邮箱地址&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <input id="amail" type="email" class="form-control" placeholder="jane.doe@example.com" autocomplete="false" maxlength="50">	
  </div> 
  <button type="button" class="btn btn-success cm">更新邮箱</button>
</div>'.$str;
		}
	}
	else{echo $str.'<div class="cls">(error:0x71000)无法退订，不正确的退订连接！</div>';}
}
else{
	header('Location:/');
}	
//处理bcc退订	
?>
<script>
$(function(){
	console.log();
	$(".cm").on("click",function(){
	var mail = $('.form-control').val();
if (mail != '') {//判断
    var reg = /^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-zd]{2,6}$/; 
	if (!reg.test(mail)) {
		$("#res").html('<div class="cls">(error:0x01000)邮箱格式错误！</div>');
		return false;
	}
	else
		{
			var vy=0;
			if($("#vy").length>0){
				bmail=$("#vy").val();
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