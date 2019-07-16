<?php
		require('phpmailer/PHPMailerAutoload.php');
		require_once('phpmailer/class.phpmailer.php');
		require_once("phpmailer/class.smtp.php");
		ini_set('date.timezone','Asia/Shanghai'); // 'Asia/Shanghai' 为上海时区 
//1）发送邮件
function sendMail($fr,$to,$ct,$at,$sub,$bccto){	

		$mail  = new PHPMailer();
		$fr=trim($fr);//处理发件人地址
		$q_getpwd="select * from mailinfo where maaddr='$fr' limit 1";//处理密码
		require('conn.php');
		$rs_getpwd=mysql_fetch_array(mysql_query($q_getpwd));
		$pwd =decry($rs_getpwd['mapwd']);
		if(!is_numeric($bccto)){
			//BCC($type=1,$to=CSCATE)
			require("conn.php");
			$getCust=mysql_query("select csmail from custinfo where cscate=".$to." and csflag=0");
			while($row_getCust=mysql_fetch_array($getCust)){
				$mail->addBCC($row_getCust['csmail']);
				mysql_query("update custinfo set csdate='".date('Y-m-d')."' where csmail='".$row_getCust['csmail']."'");
			}
			$mail->addCC('info@jasgo.com');
			$cta=createTemp(0,$ct);//套入模板
			$mail->addAddress(trim($bccto));//设置指定的收件人
		}
		else
		{
			require("conn.php");
			mysql_query("update custinfo set csdate='".date('Y-m-d')."' where csmail='".$to."'");
			$cta=createTemp($to,$ct);//套入模板
			$mail->addAddress($to);//设置指定的收件人
		}
		
		

		$mail->CharSet    ="UTF-8";                 //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
		$mail->IsSMTP();                            // 设定使用SMTP服务
		$mail->SMTPAuth   = true;                   // 启用 SMTP 验证功能
		$mail->SMTPSecure = "ssl";                  // 启用SSL
		$mail->SMTPDebug = 2;
		$mail->Host       = "smtp.mxhichina.com";       // SMTP 服务器
		$mail->Port       = 465;                    // SMTP服务器的端口号
		$mail->Username   = $fr."@jasgo.com";  // SMTP服务器用户名
		$mail->Password   = $pwd;        // SMTP服务器密码
		$mail->SetFrom($fr.'@jasgo.com', '携达集团');    // 设置发件人地址和名称
		//$mail->AddReplyTo("xxx@xxx.com","xxx@xxx.com");
		// 设置邮件回复人地址和名称
		$mail->isHTML(true);
		$mail->Subject =  $sub; // 设置邮件标题
		$mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";                                         // 可选项，向下兼容考虑
		$mail->Body=$cta;
		//$mail->MsgHTML('<html>人间四月天。</html>');                         // 设置邮件内容

		
		//$mail->AddAttachment("images/phpmailer.gif"); // 附件

		if(!$mail->Send()) {
			return "发送失败：" . $mail->ErrorInfo;
		} else {
			return "恭喜，邮件发送成功！";
		}
	}
	//加密
	 function encry($txt)
	{
		$key="CONFUSED_STRING";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
    $nh = rand(0,64);
    $ch = $chars[$nh];
    $mdKey = md5($key.$ch);
    $mdKey = substr($mdKey,$nh%8, $nh%8+7);
    $txt = base64_encode($txt);
    $tmp = '';
    $i=0;$j=0;$k = 0;
    for ($i=0; $i<strlen($txt); $i++) {
        $k = $k == strlen($mdKey) ? 0 : $k;
        $j = ($nh+strpos($chars,$txt[$i])+ord($mdKey[$k++]))%64;
        $tmp .= $chars[$j];
    }
    return urlencode($ch.$tmp);
	}
	//解密
	 function decry($txt)
	{ 
	$key="CONFUSED_STRING";
    $txt = urldecode($txt);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
    $ch = $txt[0];
    $nh = strpos($chars,$ch);
    $mdKey = md5($key.$ch);
    $mdKey = substr($mdKey,$nh%8, $nh%8+7);
    $txt = substr($txt,1);
    $tmp = '';
    $i=0;$j=0; $k = 0;
    for ($i=0; $i<strlen($txt); $i++) {
        $k = $k == strlen($mdKey) ? 0 : $k;
        $j = strpos($chars,$txt[$i])-$nh - ord($mdKey[$k++]);
        while ($j<0) $j+=64;
        $tmp .= $chars[$j];
    }
    return base64_decode($tmp);
	}	
	//初始化模板
		$token="";
		 function createTemp($mail,$content)
		{
			 $str_jp=$str_en=$str_zh="";
			//$str='<div id="jfooter">';
			if($mail!=0){				
				$token=encry($mail);				
			}
			else
			{				
				$token=encry(date('Y-m-d').'&'.'bcc');				
			}
			 	$str_jp='<p style="font-family:MS UI Gothic;">※今後、当ニュースレターの配信を希望されない場合は、<a class="ursub"  href="http://mms.jasgo.com/inc/unsubcribe.php?token='.$token.'">「配信停止」</a>をクリックし、配信を停止するメールアドレスをご入力ください。<br>メールアドレスの変更を希望される場合は、<a class="ursub" href="http://mms.jasgo.com/inc/changemail.php?token='.$token.'">「メールアドレス変更」</a>をクリックし、旧アドレスと新アドレスをご入力ください。</p>';
				$str_en='<p style="font-family:arial;">※If you don\'t want to receive emails from us anymore, please click <a class="ursub"  href="http://mms.jasgo.com/inc/unsubcribe.php?token='.$token.'">[UNSUBCRIBE]</a>, and enter your old email address.<br>If your email address has been changed, please cilck <a class="ursub" href="http://mms.jasgo.com/inc/changemail.php?token='.$token.'">[Email Address Change]</a>, and enter both your new and old email address.</p>';
				$str_zh='<p style="font-family:宋体, SimSun">※如果今后您不希望接收本邮件，请点击<a class="ursub"  href="http://mms.jasgo.com/inc/unsubcribe.php?token='.$token.'">【停止发送】</a>，并填入旧电子邮件地址。<br>如果您电子邮件地址变更，请点击<a class="ursub" href="http://mms.jasgo.com/inc/changemail.php?token='.$token.'">【邮件地址变更】</a>，并填入旧电子邮件地址和新电子邮件地址 。</p>';
			//$str.='</div>';
			 $content=str_replace("[links_jp]",$str_jp,$content);
			 $content=str_replace("[links_en]",$str_en,$content);
			 $content=str_replace("[links_zh]",$str_zh,$content);
			return '<style>
		body{margin:0;padding: 0;line-height:1;font-size:17px; }
		#jwrap{
			margin: 0;
			padding: 0;
		}
		#jcontent{background:#fff;}	
		.ursub{color: red;font-weight:bolder;text-decoration: none;}
		.ursub:hover{text-decoration: underline;}
	</style><div id="jcontent"><span style="font-family:MS UI Gothic">※この電子版ニュースレターは、日本語、英語、中国語の3言語で配信しており、日本語版、英語版、中国語版の順に掲載しています。</span><br>
<span style="font-family:arial">※This newsletter is released in three languages:Japanese, English, and Chinese. The editions appear in the following order: Japanese, English, and Chinese.</span><br>
<span style="font-family:宋体, SimSun">※本电子邮件新闻信以日文，英文和中文三个语言版本发行。语言版本顺序：日文，英文和中文。</span><br>'.$content.'</div>';
		}

		//退订操作
		 function unsub($mail)
		{
			require_once('conn.php');
			mysql_query('update custinfo set csflag=1 where csmail="'.$mail.'"');
		}
//更新操作
function changeMail($older,$new){
	require_once('conn.php');
			mysql_query("update custinfo set csmail='".$new."' where csmail='".$older);
}

				?>
