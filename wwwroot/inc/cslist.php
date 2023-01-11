<meta charset="utf-8">
<script src="../assets/jquery.js"></script>
<script src="../assets/jquery.cookie.js"></script>
<style>.row-hidden{display:none;}
		.row-hold:hover{background: #3879D9;color: #FFFFFF;cursor: pointer;}
		.line-input{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;width: 100%;}
		.line-select{border:#000000 solid 1px;border-width: 0 0 1px 0;outline: none;padding: 5px;cursor: pointer;}
		#CML div{margin:1em 0 1em 0;}
		</style>
<?php
//if(isset($_COOKIE)){var_dump($_COOKIE);}
if(!isset($_SESSION))
{
session_start(); 
}
if(isset($_SESSION['uid'])&&isset($_POST['mode'])){
	
	require('conn.php');
	$curpage=1;
	


	if($_POST['stype']==null&&!strpos($_POST['skey'],"%")&&trim($_POST['skey'])!=""){

			$query_a=" and csid>=(select csid from custinfo where (csname like '%".$_POST['skey']."%' or csmail like '%".$_POST['skey']."%') and csflag=0 limit ".(($curpage-1)*20).",1) limit 20";

			//根据关键字
			$query="select * from custinfo,category where cateid=cscate and csflag=0 and (csname like '%".$_POST['skey']."%' or csmail like '%".$_POST['skey']."%')";
			if(($total=mysql_num_rows(mysql_query($query)))>0){
				//echo '<span class="cp">'.$curpage.'</span>/<span class="tp">'.ceil($total/20).'</span>'; 
				 echo '<br/><span class=\'text-success\'>共找到'.$total.'条数据。</span>';
		$items='
		<table class="table row-hover table-condensed table-responsive"><thead><tr><th>客户分类</th><th>企业名称</th><th>邮件地址</th><th>最后发送时间</th></tr></thead><tbody>';}
     	 mysql_query("set names utf8");
			$q=mysql_query($query.$query_a);
			//echo $query.$query_a);
		while($row = mysql_fetch_array($q)){
			$items.='<tr class="row-pop row-hold"><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td><td>'.$row['csdate'].'</td><td class="row-hidden">'.$row['csid'].'</td></tr>';
		}
					 if(mysql_num_rows($query.$query_a)>0){
			$items.='</tbody></table><div class="clearfix"></div>';
					 }
				
	
			
		}
	elseif($POST['skey']==null)
	{
	$query_b=" and csid>=(select csid from custinfo where cscate='".$_POST['stype']."' and csflag=0 limit ".(($curpage-1)*20).",1) limit 20";
		//根据分组
					$query="select * from custinfo,category where cateid=cscate and csflag=0 and cateid='".$_POST['stype']."'";
					if(($total=mysql_num_rows(mysql_query($query)))>0){
				//echo $curpage.'/'.ceil($total/20);
						 echo '<span class=\'text-success\'>共找到'.$total.'条数据。</span>';
		$items='
		<table class="table row-hover table-condensed table-responsive"><thead><tr><th>客户分类</th><th>企业名称</th><th>邮件地址</th><th>最后发送时间</th></tr></thead><tbody>';}

					 mysql_query("set names utf8");
		$q=mysql_query($query.$query_b);

		while($row = mysql_fetch_array($q)){
			$items.='<tr class="row-pop row-hold"><td>'.$row['catename'].'</td><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td><td>'.$row['csdate'].'</td><td class="row-hidden">'.$row['csid'].'</td></tr>';
		}
					 if(mysql_num_rows($q)>0){
			$items.='</tbody></table><div class="clearfix"></div>';
					 }
						
				
			}	

	
	
	
	
		echo $items;
	
	

		

}


	

?>
<script>
	
$(function(){

		$(".row-pop").click(function(){
			$("#s-field").hide();
            $.get("inc/cslist.php",{cmailid:$(this).find(".row-hidden").text()},function(result){$("#CML").html(result);});	
			});
		$("#goback").click(function(event){
			event.preventDefault(); 
			$("#s-field").show();			
	
			
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
	mysql_query("set names utf8");
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