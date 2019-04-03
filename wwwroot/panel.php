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
	</script>
</head>
<body>
<?php include('head.php');
	?> 

<div class="login">
<div class="menu">
	<ul>
		<li id="send">发邮件</li>
		<li id="cusmail">客户邮件列表</li>
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
	<div class="form-group"><!--发件人-->
		<label for="from" class="col-sm-2 control-label">发件人：</label>
		<div class="col-sm-10" id="sender">
		<?php echo $sender.'@jasgo.com';?>
		</div>
	</div>
	<div class="form-group"><!--收件人-->
		<label for="to" class="col-sm-2 control-label">密送：</label>
		<div class="col-sm-5">
		<select class="form-control" id="input_rec" name="recvtype">
		<?php echo select_items();?>
		</select>
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
		<input name="recvier" id="recv" type="mail" class="form-control" required="required" placeholder="请填写此字段" maxlength="30" autocomplete="off">
		</div></div>
		<div class="form-group" id="subj"><!--主题-->
		<label for="subject" class="col-sm-2 control-label">主题：</label>
		<div class="col-sm-9" id="subject">
		<input name="subject" id="sub" type="text" class="form-control" required="required" placeholder="请填写此字段" maxlength="30" autocomplete="off">
		</div>
	</div>
	<div class="form-group"><!--内容-->
	<label for="content" class="col-sm-2 control-label">内容：</label>
	<div class="col-sm-10">
		<textarea type="text/plain" id="container" style="height:240px;">
		</textarea>
	</div>
	</div>
	<div class="form-group"><!--发送按钮-->
	<div class="col-sm-2"></div>
		<div class="col-sm-1"><input id="send_submit" class="btn btn-primary form-control" type="button" value="发送" onClick="send()"></div>
		<div class="col-sm-2" id="mails"></div>	
		</div>
	
</form>
<?php 	
		//收件人
		function select_items(){
		mysql_query("set names utf8");
		$q=mysql_query("select * from category");
		$items='';
		while($row = mysql_fetch_array($q)){
			$items.='<option value ="'.$row['cateid'].'">'.$row['catename'].'</option>';
		}
		return $items;
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
    <dir>
    <form class="form-horizontal" method="post" action="panel.php" enctype="multipart/form-data">
		<div class="form-group" id="s-field"><!--主题-->
		<label for="subject" class="col-sm-2 control-label">邮件查询：</label>
		<div class="col-sm-5" id="subject">
		<input name="searchemail" id="searchm" type="text" class="form-control" maxlength="60">
		</div>
		<div class="col-sm-2" id="subject">
		<select class="form-control" id="selm"><option value="0">[--筛选分组--]</option><?php echo select_items();?></select>
		</div>
	</div>
    <div id="CML" style="width: 80%;margin: 0 auto;max-width: 1000px;"></div>
    </form></dir>
<script>
var um = UM.getEditor('container');
	function send(){
		$("#send_submit").attr("disabled","disabled");
		if($("#sub").val().trim()==""){
	      $("#subj").attr("class","form-group has-error");

		}
		else
		{
		$("")
		$("#subj").attr("class","form-group");
		var concon = UM.getEditor('container').getContent();
		$.post("inc/phpmailer.php",{
			from:$("#sender").text(),
			to:$("#input_rec").val(),
			type:$("input[name='sendtype']:checked").val(),
			subject:$("#sub").val(),
			cont:concon,
			attrs:null,//这里是附件暂时留空
			bccto:$("#recv").val()
		},function(result){
				  $("dir").html('<p><a href="panel.php">再写一封</a></p><div style="background:#121212;color:#fff;padding:1em;max-height:300px;overflow-y:scroll;">'+result+'</div>');});	
		}
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

	$("#cusmail").click(function(){
		
		$("#searchm").bind('input propertychange', function() {
//				
			$.post("inc/cslist.php",{mode:'searchm',skey:$("#searchm").val(),stype:$("#selm").val()},function(result){$("#CML").html(result);});
//			
			}); 
		
	});
		$("#selm").bind('change',function(){
				
			$.post("inc/cslist.php",{mode:'searchm',skey:$("#searchm").val(),stype:$("#selm").val()},function(result){$("#CML").html(result);});
		});
		$('input[type=radio][name=sendtype]').on("change",function() {
        if (this.value == 1) {
			$("#recv").removeAttr("disabled");
            $("#rc").slideDown();
		}
        else if(this.value == 0) {
			$("#recv").attr("disabled","disabled");
            $("#rc").slideUp();
        }
    });
		
});	

</script>
</body>
</html>