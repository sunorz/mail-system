<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email</title>
<link rel="stylesheet" href="assets/bootstrap.css">
<style>
	.login{margin: 0 auto;width: 80%;max-width: 600px;}
</style>
<script src="assets/jquery.js"></script>
<script src="assets/bootstrap.js"></script>
</head>
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
    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="提交">
  </p>
</form>
<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
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
</div>
</body>
</html>