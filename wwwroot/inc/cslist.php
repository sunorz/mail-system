<meta charset="utf-8">
<script src="../assets/jquery.js"></script>
<style>.row-hidden{display:none;}
		.row-hold:hover{background: #3879D9;color: #FFFFFF;cursor: pointer;}
		.line-input{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;width: 100%;}
		.line-select{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;padding: 5px;cursor: pointer;}
		#CML div{margin:1em 0 1em 0;}
		</style>
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

$q=mysql_query("select *,case when csdate is null then '无' else csdate end as ss from custinfo,category where cscate=cateid and csflag=0 order by cscate");
			
		$items='
		<table class="table row-hover table-condensed table-responsive"><thead><tr><th>序号</th><th>客户分类</th><th>企业名称</th><th>邮件地址</th><th>最后发送时间</th></tr></thead><tbody>';
				
			$g=0;
		while($row = mysql_fetch_array($q)){
			$g++;
			$items.='<tr class="row-pop row-hold"><th scope="row">'.$g.'</th><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td><td>'.$row['ss'].'</td><td class="row-hidden">'.$row['csid'].'</td></tr>';
		}
			$items.='</tbody></table><div class="clearfix"></div>';
			  if(mysql_num_rows($q)==0){$items="<span class='text-danger'>没有任何可用的邮箱地址。</span><div class=\"clearfix\"></div>";}
		echo $items;
				 break;
			 case 'searchm':
				 if(isset($_POST['skey']))
				 {
					 $skey=$_POST['skey'];
					  require('conn.php');


$q=mysql_query("select * from custinfo,category where csflag=0 and cscate=cateid  and (csname like '%".$skey."%' or csmail like '%".$skey."%') and cscate='".$_POST['stype']."' order by cscate");
					 					 if(!isset($_POST['stype'])||$_POST['stype']=='0'){
						$q=mysql_query("select * from custinfo,category where csflag=0 and cscate=cateid  and (csname like '%".$skey."%' or csmail like '%".$skey."%')  order by cscate"); 
					 }
		
	if(mysql_num_rows($q)>0){
		 echo '<span class=\'text-success\'>共找到'.number_format(mysql_num_rows($q)).'条数据。</span>';
		$items='
		<table class="table row-hover table-condensed table-responsive"><thead><tr><th>序号</th><th>客户分类</th><th>企业名称</th><th>邮件地址</th></tr></thead><tbody>';}
			$g=0;
		while($row = mysql_fetch_array($q)){
			$g++;
			$items.='<tr class="row-pop row-hold"><th scope="row">'.$g.'</th><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td><td class="row-hidden">'.$row['csid'].'</td></tr>';
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
		
	
	}elseif(!isset($_SESSION['uid'])){
		header("Location:/");
	}
	

?>
<script>
	function reloadp(){$.post("inc/cslist.php",{mode:'getcsl'},function(result){$("#CML").html(result);});	}
	
$(function(){
		$(".row-pop").click(function(){
			$("#s-field").hide();
            $.get("inc/cslist.php",{cmailid:$(this).find(".row-hidden").text()},function(result){$("#CML").html(result);});	
			});
		$("#goback").click(function(event){
			event.preventDefault(); 
			$("#s-field").show();			
			reloadp();	
			
		});		
		//删除按钮
		$(".btn-danger").click(function(event){
			event.preventDefault(); 
			var deleteb  = confirm("确定删除？");
			if(deleteb==true)
				{	
			$.post("inc/db-cusmail.php",{m:'delete'});
			setTimeout(function(){alert('删除成功。');},500);
			$("#s-field").show();
			setTimeout(function(){reloadp();},1000);	
			
				}
			else
				{
					return false;
				}
		})		
		//保存按钮
		$(".btn-default").click(function(event){
			event.preventDefault(); 
			$.post("inc/db-cusmail.php",{m:'edit',cname:$(".line-input").val(),cc:$(".line-select").val()});
			alert("保存成功");
			$("#s-field").show();
			reloadp();
		})	
		
		$(".line-input").bind('input propertychange',function(){
			$(".btn-default").removeAttr('disabled');
		})
				$(".line-select").change(function(){					
			$(".btn-default").removeAttr('disabled');
		})
				
		})</script>
		<?php if(isset($_GET['cmailid'])&&is_numeric($_GET['cmailid'])){
	require('conn.php');
	$cmailid=$_GET['cmailid'];
	$_SESSION['ckey']=$cmailid;
	$q=mysql_query("select * from custinfo,category where csflag=0 and cscate=cateid and csid='".$cmailid."'");
	while($res=mysql_fetch_array($q)){
		echo '<div><strong>客户名：</strong><input type="text" class="line-input" value="'.$res['csname'].'" maxlength="60"></div><div><strong>客户邮箱：</strong>'.$res['csmail'].'</div><div><select class="line-select">'.select_items($res['cscate']).'</select></div>';
		echo '<div><button class="btn btn-default" disabled="disabled"><i class="fa fa-save"></i>&nbsp;&nbsp;保存修改</button>&nbsp;&nbsp;<button class="btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;移除</button>&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="goback"><i class="fa fa-reply"></i>&nbsp;&nbsp;取消编辑并返回</button></div>';
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