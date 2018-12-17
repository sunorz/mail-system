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
<input type="number" step="1" value="93" min="0" id="mlist">
<p><button id="dowork">Go!</button></p>
<p><textarea name="txt" warp="virtual" style="width:200px;height: 200px;resize: none;"></textarea></p>
</body>
</html>