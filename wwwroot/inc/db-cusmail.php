<meta charset="utf-8">
<?php
if(!isset($_SESSION))
{
session_start(); 
}
if(!isset($_SESSION['uid'])){
	header('Location:/');
}

  if(isset($_SESSION['ckey'])&&is_numeric($_SESSION['ckey'])){	
	  require('conn.php');
	  //删除
	  if(isset($_POST['m'])&&$_POST['m']=='delete'){
		  mysql_query("update custinfo set csflag=1 where csid='".$_SESSION['ckey']."'");	
	  }
	  //修改
	  if(isset($_POST['m'])&&$_POST['m']=='edit'){
		  if(isset($_POST['cname'])&&isset($_POST['cc']))
		  {
			mysql_query("update custinfo set csname='".$_POST['cname']."',cscate='".$_POST['cc']."' where csflag=0 and csid='".$_SESSION['ckey']."'");	  
		  }		  
	  }
  }
?>