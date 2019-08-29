<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>携达集团全球邮件群发顶级平台</title>
<link rel="stylesheet" href="assets/panel.css">
<link rel="stylesheet" href="assets/bootstrap.css">
<link href="assets/editor/themes/default/css/umeditor.css" rel="stylesheet">
<link rel="stylesheet" href="assets/fonts/css/font-awesome.min.css">
<style>
	.login{margin: 20px auto;width: 80%;min-width: 600px;}
	.form-control-feedback{right:10px;}
</style>
<script src="assets/jquery.js"></script>
<script src="assets/bootstrap.js"></script>
<script src="./assets/tab.js"></script>
<script src="assets/editor/third-party/template.min.js"></script>
<script  src="assets/editor/umeditor.config.js"></script>
<script  src="assets/editor/umeditor.min.js"></script>
<script src="assets/editor/lang/zh-cn/zh-cn.js"></script>
<script>
		var date = new Date();  
        document.onkeydown = function (e) {
        var ev = window.event || e;
        var code = ev.keyCode || ev.which;
        if (code == 116) {
        ev.keyCode ? ev.keyCode = 0 : ev.which = 0;
        cancelBubble = true;
        return false;
        }
        } //禁止f5刷新
        document.oncontextmenu=function(){return false};//禁止右键刷新
	function upload(){
		$.post("panel.php",{ulfiles:'searchm'},function(result){$("#postcontent").html(result);});
	}
		function appendzero(obj)
    {
        if(obj<10) return "0" +""+ obj;
        else return obj;
	}
</script>
</head>
<body>
<?php include('head.php');
	?> 

<div class="login">
<div class="menu">
	<ul>
		<li id="send" class="curclick">发邮件</li>
		<li id="cusmail" onClick="window.location.href='panel-b.php';">客户邮件列表</li>
	</ul>
</div>
<div class="content">
	<dir>
      <!--Send-->
      <?php
$uid=$_SESSION['uid'];
		$qry=mysql_query("select maaddr from mailinfo as a,userinfo as b where a.maid=b.umid and b.uid='$uid'");
		if($result=mysql_fetch_array($qry))
				{
				 $sender=$result['maaddr'];
				}
			
		
?>
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
	<div class="form-group col-sm-12"><a href="tools-insert.php">录入</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="tools-disabled.php">禁用</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="tools-ls.php">导出</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/">退出</a></div>
	
	<div class="form-group"><!--发件人-->
		<label for="from" class="col-sm-2 control-label">发件人：</label>
		<div class="col-sm-10" id="sender">
		<?php echo $sender.'@jasgo.com';?>
		</div>
	</div>
	<div class="form-group"><!--收件人-->
		<label id="toorbcc" for="to" class="col-sm-2 control-label">密送组：</label>
		<div class="col-sm-5">
<input class="form-control" id="input_rec" name="recvtype" type="number" value="<?php echo select_items();?>" min="0" step="1"/>		
		</div>
		<div class="col-sm-5">
		  <label>
		    <input type="radio" name="sendtype" value="0" id="sendtype_0">
		    循环单发</label>		 
		  <label>
		    <input type="radio" name="sendtype" value="1" id="sendtype_1"  checked="checked">
		    群发BCC</label>
		  <br>
        </div>
	</div>
	<div class="form-group" id="rc"><!--收件人-->
		<label for="recvier" class="col-sm-2 control-label">收件人：</label>
		<div class="col-sm-9" id="recvier">
		<input name="recvier" id="recv" type="mail" class="form-control" required="required" value="pr@jasgo.com" maxlength="30" autocomplete="off">
		</div></div>
		<!--<div class="form-group" id="subj">
		<label for="subject" class="col-sm-2 control-label">主题：</label>
		<div class="col-sm-9" id="subject">
		<input name="subject" id="sub" type="text" class="form-control" required="required" placeholder="请填写此字段" maxlength="140" autocomplete="off">
		</div>
	</div>-->
	<div class="form-group"><!--内容-->
	<label for="chgimg" class="col-sm-2 control-label"></label>
	<div class="col-sm-10"><img src="assets/imgs/bg_chk.png" style="cursor: pointer;margin-right: 0.3em;" id="chgimg">采用模板</div>
	</div>
	<div class="form-group"><!--发送按钮-->
	<div class="col-sm-2"></div>
		<div><input id="send_submit2" class="btn btn-primary" type="button" value="发送" onClick="send()"></div>
		<div class="col-sm-2" id="mails"></div>	
		</div>
	<div class="form-group"><!--内容-->
	<label for="container" class="col-sm-2 control-label">内容：</label>
	<div class="col-sm-10">
		<textarea type="text/plain" id="container" style="height:240px;overflow-y: scroll;">
		</textarea>
	</div>
	</div>
	<div class="form-group"><!--发送按钮-->
	<div class="col-sm-2"></div>
		<div><input id="send_submit" class="btn btn-primary" type="button" value="发送" onClick="send()"></div>
		<div class="col-sm-2" id="mails"></div>	
		</div>
	
</form>
		<div class="col-sm-12 text-danger"><?php tips();?></div>
<?php 	
		//收件人
//		function select_items(){
//		mysql_query("set names utf8");
//		$q=mysql_query("select * from category");
//		$items='';
//		while($row = mysql_fetch_array($q)){
//			if($row['cateid']==2333)
//			{
//				$items.='<option value ="'.$row['cateid'].'" selected="selected">'.$row['catename'].'</option>';
//			}
//			else
//			{
//				$items.='<option value ="'.$row['cateid'].'">'.$row['catename'].'</option>';
//			}
//			
//		}
//		return $items;
//	}
	function select_items(){
		mysql_query("set names utf8");
		$q=mysql_query("select * from custinfo where csdate is null  and csflag=0 LIMIT 1");
		//select cscate from custinfo where csdate=(select min(csdate) from custinfo limit 1) limit 1
		$row = mysql_fetch_array($q);
		return $row['cscate'];
	}
	function tips(){
		$cate=select_items();
		$q2=mysql_query("select * from custinfo where csflag=0 and cscate='".$cate."' and csdate='".date('Y-m-d')."' limit 1");
		//select * from custinfo where csflag=0 and cscate='".$cate."' and (csdate<'2019-08-02')
		if(mysql_num_rows($q2)==1)
		{
			echo '<table class="table table-bordered" style="table-layout:fixed;margin-top:1em;"><tbody>';
			while($rows=mysql_fetch_array($q2)){
				echo '<tr><td>'.$rows['csmail'].'</td></tr>';
			}
			echo '</tbody></table>';
		}
		
	}
	
		//客户邮箱列表
//		function cslist(){
//			
//		$q=mysql_query("select * from custinfo where csflag=0 order by cscate");
//		$items='
//		<table class="table table-hover table-condensed table-responsive"><thead><tr><th>序号</th><th>企业名称</th><th>邮件地址</th></tr></thead><tbody>';
//			$g=0;
//		while($row = mysql_fetch_array($q)){
//			$g++;
//			$items.='<tr><th scope="row">'.$g.'</th><td>'.$row['csname'].'</td><td>'.$row['csmail'].'</td></tr>';
//		}
//			$items.='</tbody></table><div class="clearfix"></div>';
//		return $items;
//	}
		//上传附件
function upattachment(){
	$count = count($_FILES['file']['name']);
		    $arr = array();
		    $err = true;
		    for ($j = 0; $j < $count; $j++)
			{
				if ($_FILES["file"]["error"][$j] > 0 && $_FILES["file"]["error"][$j]<4)
				{
					$err = false;					
				}
			}
		if($err)
		{
            for ($i = 0; $i < $count; $i++) {
				$tmpfile = $_FILES['file']['tmp_name'][$i];
                $filefix = array_pop(explode(".", $_FILES['file']['name'][$i]));
                $dstfile = "upload/".date('Ymd')."/attachment/".mt_rand().".".$filefix;
				if(!file_exists("upload/".date('Ymd')."/attachment"))
				{
					 mkdir("upload/".date('Ymd')."/attachment",0777,true);
				}
                if (move_uploaded_file($tmpfile, $dstfile)) {
                    $arr[$i]=$dstfile;
                } 
            }
			return $arr;
		}
		else{
			echo '文件上传错误';
			return false;
		}
	
}
	if(isset($_POST['ulfiles'])){
		//upattachment();
	}
	
		?>
    </dir>
 <script>
var um = UM.getEditor('container',{initialFrameHeight:250,//设置编辑器高度
scaleEnabled:false//设置不自动调整高度
								  });
	function send(){
		$("#send_submit").attr("disabled","disabled");
		$("#subj").attr("class","form-group");
		var concon = UM.getEditor('container').getContent();
		$.post("inc/phpmailer.php",{
			from:$("#sender").text(),
			to:$("#input_rec").val(),
			type:$("input[name='sendtype']:checked").val(),
			//subject:$("#sub").val(),
			subject:"这是一封固定标题的信件-"+date.getFullYear() + '.' + appendzero(date.getMonth() + 1) + '.' + appendzero(date.getDate()),
			cont:concon,
			attrs:null,//这里是附件暂时留空
			bccto:$("#recv").val()
		},function(result){
				  $("dir").html('<p><a href="panel.php">再写一封</a></p><div style="background:#121212;color:#fff;padding:1em;max-height:300px;overflow-y:scroll;">'+result+'</div>');});	

		//alert(UM.getEditor('container').getContent());
	}
		
</script>
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
</div><!--end-->
<script>

	$(function(){
	if($(".text-danger").text().length>10){
		$(".btn").hide();
		$("form").html('<i>分组'+$("#input_rec").val()+'内数据遗漏。请核查数据库错误之后，再刷新该页面。</i>');
	}
	$('#chgimg').on({  
                    click:function(){ 
					if($('#chgimg').attr('src')=='assets/imgs/bg_chk.png')
					{
	
						 $('#chgimg').attr('src', 'assets/imgs/bg_chkon.png'); 
$(".edui-body-container").html('日文：'+date.getFullYear() + '.' + appendzero(date.getMonth() + 1) + '.' + appendzero(date.getDate())+'英文：'+date.toDateString().split(" ")[1]+ ' ' + date.getDate()+ ',' + date.getFullYear()+'中文：'+date.getFullYear() + '.' + appendzero(date.getMonth() + 1) + '.' + appendzero(date.getDate()));
						
					}
					else if($('#chgimg').attr('src')=='assets/imgs/bg_chkon.png')
					{
						 $('#chgimg').attr('src', 'assets/imgs/bg_chk.png'); 
						$(".edui-body-container").html('');
						
					}  
					}
						 
                }); 
	
	$("#cusmail").click(function(){		
		
		$("#selm").bind('change',function(){
				
			$.post("inc/cslist.php",{mode:'searchm',skey:$("#searchm").val(),stype:$("#selm").val()},function(result){$("#CML").html(result);});
		});
		$('input[type=radio][name=sendtype]').on("change",function() {
        if (this.value == 1) {
			$("#recv").removeAttr("disabled");
            $("#rc").slideDown();
			$("#toorbcc").text('密送组：');
		}
        else if(this.value == 0) {
			$("#recv").attr("disabled","disabled");
            $("#rc").slideUp();
			$("#toorbcc").text('收件组：');
        }
    });
		
});	
	});

</script>
</body>
</html>