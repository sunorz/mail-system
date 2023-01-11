<meta charset="utf-8">
<script src="../assets/jquery.js"></script>
<style>
	.cls{background: #484848;color: #fff;font-size: 12px;width: 90%;margin: 0 auto;padding: 1em;}
</style>
<?php
if(isset($_POST['before'])&&isset($_POST['after'])&&isset($_POST['verify'])){
	require("conn.php");
	if(strlen($_POST['verify'])!=32){
		if(fmail($_POST['after'])){
			echo '<div class="cls">需要更改的邮箱地址已经存在，如需退订，请到邮件内容中点击退订链接。</div>';
		}
		else{
		//单发
		mysql_query("update custinfo set csmail='".$_POST['after']."' where csmail='".$_POST['before']."'");
		echo '<div class="cls">更新完成！</div>';
		}
	
	}	
	else
	{	
		if(fmail($_POST['after'])){
			echo '<div class="cls">需要更改的邮箱地址已经存在，如需退订，请到邮件内容中点击退订链接。</div>';
		}
		else{
		if(fmail($_POST['before'])){
		//BCC
		$res=mysql_query("select csdate from custinfo where csmail='".$_POST['before']."' limit 1");
		while($rows=mysql_fetch_array($res)){
			if(md5($rows['csdate'])==$_POST['verify']){
				if(fmail($_POST['after']))
				{
					echo '<div class="cls">需要更改的邮箱地址已经存在，如需退订，请到邮件内容中点击退订链接。</div>';
					exit;
				}
				mysql_query("update custinfo set csmail='".$_POST['after']."',csflag=0 where csmail='".$_POST['before']."'");
				echo '<div class="cls">更新完成！</div>';
			}			
		}
		}
			else{
				echo '<div class="cls">没有这个地址。</div>';
			}
		}
		
		
	}
}
else{echo '<div class="cls">参数错误，无法更新。</div>';}


function fmail($mail){
	require("conn.php");
	$query="select csid from custinfo where csmail = '".$mail."' limit 1";
	$result=mysql_query($query);
	if(mysql_num_rows($result)>0){
		return true;
	}
	else
	{
		return false;
	}
}
?>