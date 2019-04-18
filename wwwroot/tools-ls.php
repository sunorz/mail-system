<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>导出</title>
</head>

<body>
<script src="assets/jquery.js"></script>
<script>
	$(function(){
		$("#dowork").click(function(){
	$.post("tools-ls-inc.php",{mlist:$("#mlist").val()},function(result){$("textarea").val(result);});
});
	});

</script>
	<?php include("head.php");?> 
<input type="number" step="1" value="<?php $res=mysql_query("select MAX(cscate) from custinfo where cscate<>2333");
	$row=mysql_fetch_row($res);
			echo $row[0];
	?>" min="0" id="mlist">
<p><button id="dowork">Go!</button></p>
<p><textarea name="txt" warp="virtual" style="width:200px;height: 200px;resize: none;"></textarea></p>
</body>
</html>