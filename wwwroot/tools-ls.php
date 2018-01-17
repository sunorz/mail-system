<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>再见</title>
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
<input type="number" step="1" value="0" min="0" id="mlist">
<p><button id="dowork">Go!</button></p>
<p><textarea name="txt" clos="100" rows="10" warp="virtual" style="width: 80%;"></textarea></p>
</body>
</html>