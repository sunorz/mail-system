<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>流水线</title>
	<style>#dowork{
		width: 100%;
		height: 100px;
		border: #cbcbcb solid 1px;
		cursor: pointer;
		background: linear-gradient(to bottom,#d8d8d8,#d0d0d0);
		color: #000;
		font-family:"微软雅黑";
		outline: none;
		}
		#dowork:hover{background: linear-gradient(to bottom,#eeeeee,#ececec);}
		#mlist{
			font-size: 2em;
			width: 100px;
			border-radius: 10px;
			outline: none;
			border: solid 1px #A3A3A3;
			text-indent: 0.5em;
			color: #E87612;
		}
		.result{
			max-height:500px;overflow-y:scroll;display:inline-block;}
		.result div{padding: 0.5em 0 0.5em 0;text-indent: 1em;}
		.b1{background: #1f1f1f !important;color: #767676 !important;}
		.b2{background: #767676 !important;color: #1f1f1f !important;}
		#curp{background: #1f1f1f;color: #fff;}
a,a:link,a:active,a:visited{color:#000;text-decoration:none;}
	</style>
</head>

<body>

<a href="#" id="eye">[睡眠模式]</a>&nbsp;&nbsp;<a href="tools-ls.php" target="_blank">[导出]</a>&nbsp;&nbsp;<a href="/">[返回首页]</a><br/><br/><br/>
分组编号：<input type="number" step="1" value="93" min="0" id="mlist" style="ime-mode:disabled;"><br/><br/>
邮箱：<input type="email" id="memail" style="background-color: transparent !important;ime-mode:disabled;border-bottom: solid #000;border-width: 0 0 1px 0;outline: none;width: 90%;font-size: 2em;">
<p><button id="dowork">开始</button></p>
<div id="CML"></div>
<script src="assets/jquery.js"></script>
<script>
	$(function(){
		var arr=['人生得意须尽欢','古藤老树昏鸦','笑着活下去','做这种事情有多无聊','还是种田适合我','你饿没？','对酒当歌，人生几何','世界上最美的颜色是什么？','你有我有全都有哇~'];
		$("#dowork").click(function(){
	var i = Math.floor(Math.random()*9);
	//$(this).text(arr[i]);	
var mail = $('#memail').val();

if (mail != '') {//判断
    var reg = /^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-zd]{2,6}$/; 
	if (!reg.test(mail)) {
        $("#CML").html('邮件格式错误。');
       return false;
  }
	else
		{

			$.post("tools-insert-inc.php",{mlist:$("#mlist").val(),email:$("#memail").val()},function(result){$("#CML").html(result);$(".result").scrollTop($("#curp").offset().top - $(".result").offset().top + $(".result").scrollTop());});
		
		}
}
	
});
		$("#eye").click(function(){
			$("body").toggleClass("b1");
			$("a").toggleClass("b1");
			$("input").toggleClass("b1");
			$("button").toggleClass("b1");
			$("#curp").toggleClass("b2");
		});	
$("#memail").keyup(function(event){$.post("tools-insert-s-inc.php",{keywds:$("#memail").val()},function(result){$("#CML").html(result);});});});   
</script>
</body>
</html>