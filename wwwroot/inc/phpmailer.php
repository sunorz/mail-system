<?php
require('PHPMailer\src\PHPMailer.php');
require('PHPMailer\src\SMTP.php');
require('PHPMailer\src\Exception.php');
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\SMTP;
ini_set('date.timezone','Asia/Shanghai'); // 'Asia/Shanghai' 为上海时区 
class ToolUtils 
{
public function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
	   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
	   $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
	}
	protected $_key = "ENTER_KEY_TO_ENCRYPT";
	//加密
	public function encry($str)
	{
		$key=$this->_key;
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0;$i < strlen($str); $i++) {
		   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		   $tmp .= $encrypt_key[$ctr].($str[$i] ^ $encrypt_key[$ctr++]);
		}
		return base64_encode($this->passport_key($tmp, $key));
	}
	//解密
	public function decry($str)
	{   
		$key=$this->_key;
		$str = $this->passport_key(base64_decode($str), $key);
		$tmp = '';
		for($i = 0;$i < strlen($str)-1; $i++) {
		$md5 = $str[$i];
		$tmp .= $str[++$i] ^ $md5;
		}
		return $tmp;
	}	
	//初始化
public function setup($fr,$to,$type=1,$ct,$at,$sub){
	$fr=trim($fr);
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
   //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.example.com';  // Specify main and backup SMTP servers
   $mail->SMTPAuth = true;                               // Enable SMTP authentication
   $mail->Username = $fr.'@example.com';                 // SMTP username
//获取密码
	$q_getpwd="select * from mailinfo where maaddr='$fr' limit 1";
require('conn.php');
	$rs_getpwd=mysql_fetch_array(mysql_query($q_getpwd));
	$pwd = $this -> decry($rs_getpwd['mapwd']);
   $mail->Password = $pwd;   
   $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
   $mail->Port = 465;                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';
   //Recipients
    $mail->setFrom($fr.'@example.com', 'SENDER_NAME');    
$recv=array();
	$q_getcust=mysql_query("select csmail from custinfo where cscate=".$to." and csflag=0");
//拷贝数组，并且清除下标
   while($rs_getcust=mysql_fetch_array($q_getcust)){
		$recv[]=$rs_getcust['csmail'];
	}
	 $mail->isHTML(true);                                  // Set email format to HTML
	if($type==0){
		//循环单发
	for($i=0;$i<count($recv);$i++)
	{
		$cta=$this->createTemp($recv[$i],$ct);//套入模板
		$mail->addAddress($recv[$i]); //设置收件人，多个收件人，调用多次
	$mail->Subject = $sub;
       $mail->Body    = $cta;
   //Attachments
	//for($k=0;$k<count($at);$k++)
//	{
//		$mail->addAttachment($at[$k]); //添加附件，多个附件，调用多次
//	}
	sleep(10);
   $mail->send(); //发送
		}
	
	}
	else
	{
		////BCC
		$mail->addAddress('recipient@example.com','RECIPIENT_NAME');     // Add a recipient
		$cta=$this->createTemp(0,$ct);//套入模板
		for($j=0;$j<count($recv);$j++)
		{
		$mail->addBCC($recv[$j]); //设置秘密抄送，多个秘密抄送，调用多次
		mysql_query("update custinfo set csdate='".date('Y-m-d')."' where csmail='".$recv[$j]."'");
		}
		$mail->Subject = $sub;
        $mail->Body    = $cta;
		   //Attachments
//	for($k=0;$k<count($at);$k++)
//	{
//		
//		//$mail->AddAttachment($at['file']['tmp_name'], $_FILES['file']['name']); //添加附件，多个附件，调用多次
//	}
		$mail->send(); //发送
//		
	}	
    //$mail->addBCC('tech.lz@jasgo.com');
	//$mail->addBCC('cs.j4@jasgo.com');

//    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//    //Content
//    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
// 
   echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
	}
	public function createTemp($mail,$content)
	{
		   
		
		$str='<div id="jfooter">';
		if($mail!=0){
			$code=new ToolUtils();
			$token=$code->encry($mail);
			$str.='<a class="ursub" href="http://YOUR_DOMAINADDRESS/inc/unsubcribe.php?token='.$token.'">UNSUBSCRIBE</a>';
		}
		else
		{
			$code=new ToolUtils();
			$token=$code->encry(date('Y-m-d').'&'.'bcc');
			$str.='<a class="ursub" href="http://YOUR_DOMAINADDRESS/inc/unsubcribe.php?token='.$token.'">UNSUBSCRIBE</a>';
		}
		$str.='</div>';
		return '<style>
	body{margin:0;padding: 0;}
	#jwrap{
		margin: 0;
		padding: 0;
		margin: 0 auto;
		background: #f8f9fa;
		border-radius: 5px;		
	}
	#jtitle{color: #95b7de;top:0;font-size:2em;font-weight: bolder;padding: 0.5em 0 0.5em 0.5em;}
	#jcontent{background:#fff;padding: 2.5em;margin: 0 2em;word-break: break-all;overflow: hidden;color: #121212;}	
	.ursub{color: #1a73e8;font-size: 0.7em;text-decoration: none;}
	.ursub:hover{color:#121212;text-decoration: underline;}
	#jfooter{text-align: right;padding:20px;}
</style>
<div id="jwrap">
<div id="jtitle">YOUR COMPANY NAME</div>
<div id="jcontent">'.$content.'</div>'.$str.'</div>';
	}

	//退订操作
	public function unsub($mail)
	{
		require_once('conn.php');
		mysql_query('update custinfo set csflag=1 where csmail="'.$mail.'"');
	}
}

		if($result=mysql_fetch_array($qry))
				{
				 $sender=$result['maaddr'];

				}
	
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
				$ms = new ToolUtils();				
				$ms->setup($fr,$to,$type,$ct,$at,$sub);

			}
	?>