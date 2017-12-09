<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<script src="../assets/jquery.js"></script>
	<style>.row-hidden{display:none;}
		.row-hold:hover{background: #3879D9;color: #FFFFFF;cursor: pointer;}
		.line-input{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;width: 100%;}
		#CML div{margin:1em 0 1em 0;}
		</style>
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
		<table class="table row-hover table-condensed table-responsive"><thead><tr><th>序号</th><th>客户分类</th><th>企业名称</th><th>邮件地址</th></tr></thead><tbody>';
				
			$g=0;
		while($row = mysql_fetch_array($q)){
			$g++;
			$items.='<tr class="row-pop row-hold"><th scope="row">'.$g.'</th><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td><td class="row-hidden">'.$row['csid'].'</td></tr>';
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
		//header("Location:/");
	}
	

?>
<script>$(function(){
		var keywords='';//当前关键词
		var groupid=0;//当前的分组
		$("dir:eq(1)").on('click','.row-pop',function(){
			//获取当前缓存
			keywords = $("#searchm").val();
			groupid = $("#selm").val();
			console.log(keywords+groupid);
            $.get("inc/cslist.php",{cmailid:$(this).find(".row-hidden").text()},function(result){$("#CML").html(result);});		
		});
		$("dir:eq(1)").on('click','#goback',function(){
			$.post("inc/cslist.php",{mode:'searchm',skey:keywords,stype:groupid},function(result){$("#CML").html(result);});	
		});		
		
		//删除按钮
		$("#CML").on('click',".fa-trash-o",function(event){
			return false;
			event.preventDefault(); 
			alert("123");
		})		
		//保存按钮
		$("#CML").on('click',".fa-save",function(event){
			event.preventDefault(); 
			alert("123");
		})	
		})</script>
		<?php if(isset($_GET['cmailid'])&&is_numeric($_GET['cmailid'])){
	require('conn.php');
	$cmailid=$_GET['cmailid'];
	$q=mysql_query("select * from custinfo,category where csflag='0' and cscate=cateid and csid='".$cmailid."'");
	while($res=mysql_fetch_array($q)){
		echo '<div><strong>客户名：</strong><input type="text" class="line-input" value="'.$res['csname'].'" maxlength="60"></div><div><strong>客户邮箱：</strong>'.$res['csmail'].'&nbsp;&nbsp;<button class="btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;移除</button></div><div><select>'.select_items($res['cscate']).'</select></div>';
		echo '<div><button class="btn btn-default"><i class="fa fa-save"></i>&nbsp;&nbsp;保存修改</button></div>';
		echo '<p style="text-align:right;"><button type="button" class="btn btn-primary" id="goback"><i class="fa fa-reply"></i>&nbsp;&nbsp;返回</button></p>';
	}
}
	function select_items($cscate){
		$q=mysql_query("select * from category");
		$items='';
		while($row = mysql_fetch_array($q)){
			$items.='<option value ="'.$row['cateid'].'"';
			if($cscate==$row['cateid']){$items.='selected="selected"';}
			$items.='>'.$row['catename'].'</option>';
		}
		return $items;
	}?>
</body>
</html>