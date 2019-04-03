<?php 
ini_set("display_errors", "On");
if(isset($_POST['cont']))
				{
				//开始提交
				//1.发件人
					$fr = substr($_POST["from"],0,strpos($_POST["from"],"@"));
				//2.收件人分类
					$to = $_POST["to"];					
				//3.内容
					$ct = $_POST["cont"];
				//4.附件
					$at = $_POST["attrs"];
	//			    foreach(upattachment() as $value)
	//				{
	//				  echo $value.'<br/>';
	//				}
				//5.方式
					$type = $_POST["type"];
				//6.主题
					$sub = $_POST["subject"];
				//7.BCC收件人
					$bccto = $_POST["bccto"];
						require("conn.php");
						$getCust=mysql_query("select csmail from custinfo where cscate=".$to." and csflag=0");
					require("functions.php");
						if($type==0){
						while($row_getCust=mysql_fetch_array($getCust)){
							echo sendMail($fr,$row_getCust['csmail'],$ct,$at,$sub,0);
							}	
					}
					else{
						echo sendMail($fr,$to,$ct,$at,$sub,$bccto);
					}
											
						
					
					

				}
?>