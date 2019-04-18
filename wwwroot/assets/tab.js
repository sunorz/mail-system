$(function(){
   //初始化
$("dir").show();
//鼠标悬停   
$(".edui-container").width('90%');

$("#cusmail").click(function(){
	$.post("../inc/cslist.php",{mode:'getcsl'},function(result){$("#CML").html(result);});
});

});