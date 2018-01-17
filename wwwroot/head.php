<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<link rel="stylesheet" href="./assets/panel.css">
</head>

<body>
<?php
	require("inc/conn.php");
	if(!isset($_SESSION['uid'])&&$_SERVER['PHP_SELF']!="/index.php"){
		echo "<script>alert('登录超时！');location.href='/';</script>"; 
	}

		echo '<div class="navrole"><h1>携达集团全球邮件群发顶级平台</h1></div>';
	
	
	?>
</body>
</html>