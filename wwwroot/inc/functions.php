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
		//$mail->AddAddress('2975519547@qq.com');
		//$mail->addBCC('cs.j4@jasgo.com');
		//$mail->addBCC('hr.lz@jasgo.com');
		
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
		$key="ENTER_YOUR_KEY";
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
	$key="ENTER_YOUR_KEY";
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

		 function createTemp($mail,$content)
		{



			$str='<div id="jfooter">';
			if($mail!=0){				
				$token=encry($mail);
				$str.='<a class="ursub" href="http://mms.jasgo.com/inc/changemail.php?token='.$token.'">配信メールを変更してください</a>&nbsp;&nbsp;<a class="ursub" href="http://mms.jasgo.com/inc/unsubcribe.php?token='.$token.'">購読を中止</a>';
			}
			else
			{				
				$token=encry(date('Y-m-d').'&'.'bcc');
				$str.='<a class="ursub" href="http://mms.jasgo.com/inc/changemail.php?token='.$token.'">配信メールを変更してください</a>&nbsp;&nbsp;<a class="ursub" href="http://mms.jasgo.com/inc/unsubcribe.php?token='.$token.'">購読を中止</a>';
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
		.ursub{color: #121212;font-size: 0.7em;text-decoration: none;}
		.ursub:hover{text-decoration: underline;}
		#jfooter{text-align: right;padding:20px;}
	</style>
	<div id="jwrap">
	<div id="jtitle">Jasgo</div>
	<div id="jcontent">'.$content.'</div>'.$str.'</div>';
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
