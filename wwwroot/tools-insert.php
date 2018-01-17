<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>富士康流水线</title>
	<style>#dowork{
		width: 100%;
		height: 100px;
		border: none;
		border-radius: 200px;
		cursor: pointer;
		background: #1D75BD;
		color: #fff;
		font-family:"微软雅黑";
		outline: none;
		}
		#dowork:hover{background:#7CB9EA;}
		#mlist{
			font-size: 2em;
			width: 100px;
			border-radius: 10px;
			outline: none;
			border: solid 1px #A3A3A3;
			text-indent: 0.5em;
			color: #E87612;
		}</style>
</head>

<body>
<script src="assets/jquery.js"></script>
<script>
	$(function(){
		var arr=['人生得意须尽欢','古藤老树昏鸦','笑着活下去','做这种事情有多无聊','还是种田适合我','你饿没？','对酒当歌，人生几何','世界上最美的颜色是什么？','你有我有全都有哇~'];
		$("#dowork").click(function(){
	var i = Math.floor(Math.random()*9);
	$(this).text(arr[i]);	
var mail = $('#memail').val();

if (mail != '') {//判断
    var reg = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])/;
    if (!reg.test(mail)) {
        $("#CML").html('邮件格式错误。');
       return false;
  }
	else
		{

			$.post("tools-insert-inc.php",{mlist:$("#mlist").val(),email:$("#memail").val()},function(result){$("#CML").html(result);});
		}
}
	
});
	});
   
</script>
分组编号：<input type="number" step="1" value="" min="0" id="mlist"><br/><br/>
邮箱：<input type="email" id="memail" style="border-bottom: solid #000;border-width: 0 0 1px 0;outline: none;width: 90%;font-size: 2em;">
<p><button id="dowork">开始</button></p>
<div id="CML"></div>
</body>
</html>