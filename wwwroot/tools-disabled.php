<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>禁用邮箱地址-流水线</title>
	<style>#dowork{
		width: 100%;
		height: 100px;
		border: #cbcbcb solid 1px;
		cursor: pointer;
		background: linear-gradient(to bottom,#E1373A,#B2671A);
		color: #fff;
		font-family:"微软雅黑";
		outline: none;
		font-size:2em;
		}
		#dowork:hover{background: linear-gradient(to bottom,#E1373A,#E1373A);}
		#mlist{
			font-size: 2em;
			width: 100px;
			border-radius: 10px;
			outline: none;
			border: solid 1px #A3A3A3;
			text-indent: 0.5em;
			color: #E87612;
		}
		.result{
			max-height:500px;overflow-y:scroll;display:inline-block;}
		.result div{padding: 0.5em 0 0.5em 0;text-indent: 1em;}
		.b1{background: #1f1f1f !important;color: #767676 !important;}
		.b2{background: #767676 !important;color: #1f1f1f !important;}
		#curp{background: #1f1f1f;color: #fff;}
a,a:link,a:active,a:visited{color:#000;text-decoration:none;}
		#c_disable{color: red;}
	</style>
</head>

<body>
<?php include("head.php");
	if(isset($_SESSION)&&$_SESSION['uid']!=1){
	?>
	<a href="panel.php">首页</a>|
	<?php
		
}?> 
	
<a href="#" id="eye">睡眠模式</a>|<a href="tools-insert.php" target="_blank">录入</a>|<a href="tools-ls.php" target="_blank">导出</a>|<a href="/">退出</a><br/><br/><br/>
<!--分组编号：--><input style="display: none;" type="number" step="1" value="<?php $res=mysql_query("select MAX(cscate) from custinfo where cscate<>2333");
	$row=mysql_fetch_row($res);
			echo $row[0];
	?>" min="0" id="mlist" style="ime-mode:disabled;width: 500px;"><br/><br/>
邮箱：<input type="email" id="memail" style="background-color: transparent !important;ime-mode:disabled;border-bottom: solid #000;border-width: 0 0 1px 0;outline: none;width: 90%;font-size: 2em;">
<p><button  id="dowork">禁用</button></p>
<div id="CML"></div>
<script src="assets/jquery.js"></script>
<script>
$(function(){

		$("#dowork").click(function(){
			var mail = $('#memail').val();
if (mail != '') {//判断
    var reg = /^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-zd]{2,6}$/; 
	if (!reg.test(mail)) {
        $("#CML").html('邮件格式错误。');
  }
	else
		{

			$.post("tools-disabled-inc.php",{email:mail},function(result){$("#CML").html(result);});
		
		}
}
		});

});
				$("#eye").click(function(){
			$("body").toggleClass("b1");
			$("a").toggleClass("b1");
			$("input").toggleClass("b1");
			$("button").toggleClass("b1");
			$("#curp").toggleClass("b2");
	
			});
		$("#CML").on("click","#c_disable",function(){
		$.post("tools-disabled-inc.php",{flag:'disable',email:$("#c_mail").text()},function(result){$("#CML").html(result);});
	});
</script>
</body>
</html>