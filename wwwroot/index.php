<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email</title>
</head>
<link rel="stylesheet" href="assets/bootstrap.css">
<style>
	.login{margin: 0 auto;width: 80%;max-width: 600px;}
</style>
<script src="assets/jquery.js"></script>
<script src="assets/bootstrap.js"></script>
<body>
<?php include("head.php");?> 
<div class="login">
<form autocomplete="off" class="form-horizontal" action="/" method="post">
  <p class="form-group">
    <label for="textfield" >用户名:</label>
    <input class="form-control" type="text" name="un" id="textfield" maxlength="20">
  </p>
  <p class="form-group">
    <label for="password">密码:</label>
    <input class="form-control" type="password" name="pwd" id="password">
  </p>
  <p class="form-group">
    <button class="btn btn-primary" type="submit" name="submit" id="submit">登录</button>&nbsp;&nbsp;<button class="btn btn-danger" type="button" id="reg">注册</button>
  </p>
</form>

<div id="CML"></div>
<?php 
	if (isset($_POST["pwd"])&&isset($_POST["un"])){
		$un=$_POST["un"];
		$pwd=md5($_POST["pwd"]);
		 $check_query = mysql_query("select * from userinfo where un='$un' and pwd='$pwd' limit 1");
        if($result = mysql_fetch_array($check_query)){
        //登录成功
		$_SESSION['un']=$result['un'];
		$_SESSION['uid']=$result['uid'];
         echo "<script>location.href='panel.php';</script>"; 
         exit;
          } 
          else {
         echo "<script>alert('登录失败！');location.href='index.php';</script>"; 
	      exit;}
	}
	?>
		<a href="tools-insert.php">[开始录入]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tools-ls.php">[导出内容]</a>
</div>
<script>$(function(){
		$("#reg").click(function(event){
			event.preventDefault();
			$.post("reg.php",{mode:'reg'},function(result){
				$(".login").html(result);
			});
		})
	})</script>

</body>
</html>