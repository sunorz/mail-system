<meta charset="utf-8">
<script src="../assets/jquery.js"></script>
<style>
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 0 auto;padding: 1em;}
</style>
<?php
if(isset($_POST['before'])&&isset($_POST['after'])&&isset($_POST['verify'])){
	require("conn.php");
	require('functions.php');
	if($_POST['verify']==0){
		//单发
		mysql_query("update custinfo set csmail='".$_POST['after']."' where csmail='".$_POST['before']."'");
		echo '<div class="cls">更新完成！</div>';
	
	}	
	else
	{		//BCC
		$res=mysql_query("select * from custinfo where csmail='".$_POST['before']."'");
		while($rows=mysql_fetch_array($res)){
			if(md5($rows['csdate'])==$_POST['verify']){
				mysql_query("update custinfo set csmail='".$_POST['after']."' where csmail='".$_POST['before']."'");
				echo '<div class="cls">更新完成！</div>';
			}			
		}
		
		
	}
}
else{echo 'failure';}
?>