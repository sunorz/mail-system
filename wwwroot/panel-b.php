<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>携达集团全球邮件群发顶级平台</title>
<link rel="stylesheet" href="assets/panel.css">
<link rel="stylesheet" href="assets/bootstrap.css">
<link rel="stylesheet" href="assets/fonts/css/font-awesome.min.css">
<style>
	.login{margin: 20px auto;width: 80%;min-width: 600px;}
	.form-control-feedback{right:10px;}
	.row-hidden{display:none;}
		.row-hold:hover{background: #3879D9;color: #FFFFFF;cursor: pointer;}
		.line-input{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;width: 100%;}
		.line-select{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;padding: 5px;cursor: pointer;}
		#CML div{margin:1em 0 1em 0;}
	.fa{cursor:pointer;}
</style>
<script src="assets/jquery.js"></script>
<script src="assets/jquery.cookie.js"></script>
<script src="assets/bootstrap.js"></script>
<script src="./assets/tab.js"></script>
</head>
<body>
<?php include('head.php');	?> 
<div class="login">
<div class="menu">
	<ul>
		<li id="send" onClick="window.location.href='panel.php';">发邮件</li>
		<li id="cusmail" class="curclick">客户邮件列表</li>
	</ul>
</div>
<div class="content">
    <dir>
    <form class="form-horizontal" method="post" action="panel.php" enctype="multipart/form-data">
			<div class="form-group col-sm-12"><a href="tools-insert.php">录入</a>|<a href="tools-disabled.php">禁用</a>|<a href="tools-ls.php">导出</s>|<a href="/">退出</a></div>
		<div class="form-group" id="s-field"><!--主题-->
		<label for="subject" class="col-sm-2 control-label">邮件查询：</label>
		<div class="col-sm-5" id="subject">
		<input name="searchemail" id="searchm" type="text" class="form-control" maxlength="60" autocomplete="off">
		</div>
	</div>

    <div id="CML" style="width: 80%;margin: 0 auto;max-width: 1000px;"></div>
			
    </form></dir>
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
</div><!--end-->
<script>
	$(function(){    
		
		$("#searchm").bind('input propertychange', function() {
			$.post("inc/cslist.php",{mode:'searchm',skey:$("#searchm").val(),stype:null},function(result){$("#CML").html(result);$(".cp").val($(".tp").text());});
//			
			}); 			
});	

</script>
	
</body>
</html>