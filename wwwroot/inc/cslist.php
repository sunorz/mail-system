<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
	if(!isset($_SESSION))
{
session_start(); 
}
	if(isset($_SESSION['uid'])&&isset($_POST['mode'])){
	 $items='';
	 switch($_POST['mode']){
			 case 'getcsl'://显示全部
				 require('conn.php');

$q=mysql_query("select * from custinfo,category where cscate=cateid and csflag='0' order by cscate");
		$items='
		<table class="table table-hover table-condensed table-responsive"><thead><tr><th>序号</th><th>客户分类</th><th>企业名称</th><th>邮件地址</th></tr></thead><tbody>';
				
			$g=0;
		while($row = mysql_fetch_array($q)){
			$g++;
			$items.='<tr><th scope="row">'.$g.'</th><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td></tr>';
		}
			$items.='</tbody></table><div class="clearfix"></div>';
		echo $items;
				 break;
			 case 'searchm':
				 if(isset($_POST['skey']))
				 {
					 $skey=$_POST['skey'];
					  require('conn.php');


$q=mysql_query("select * from custinfo,category where csflag='0' and cscate=cateid  and (csname like '%".$skey."%' or csmail like '%".$skey."%') and cscate='".$_POST['stype']."' order by cscate");
					 					 if(!isset($_POST['stype'])||$_POST['stype']=='0'){
						$q=mysql_query("select * from custinfo,category where csflag='0' and cscate=cateid  and (csname like '%".$skey."%' or csmail like '%".$skey."%')  order by cscate"); 
					 }
		
	if(mysql_num_rows($q)>0){
		 echo '<span class=\'text-success\'>共找到'.number_format(mysql_num_rows($q)).'条数据。</span>';
		$items='
		<table class="table table-hover table-condensed table-responsive"><thead><tr><th>序号</th><th>客户分类</th><th>企业名称</th><th>邮件地址</th></tr></thead><tbody>';}
			$g=0;
		while($row = mysql_fetch_array($q)){
			$g++;
			$items.='<tr><th scope="row">'.$g.'</th><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td></tr>';
		}
					 if(mysql_num_rows($q)>0){
			$items.='</tbody></table><div class="clearfix"></div>';
					 }
					 else{
						 if(trim($skey)==""){
							 $items.="<span class='text-danger'>这个分组下没有任何邮箱地址。</span><div class=\"clearfix\"></div>";
						 }
						 else
						 $items.="<span class='text-danger'>没有找到与&nbsp;<strong>".$skey."</strong>&nbsp;对应的邮箱地址。</span><div class=\"clearfix\"></div>";
					 }
		echo $items;
				 }
				 break;
			 default:
				 break;
		 }
		
	
	}else{
		header("Location:/");
	}
	

?>
</body>
</html>