<?php
require_once("inc/smtp-mail.php");
$str="123456";
$code=new ToolUtils();
$token=$code->encry($str);
echo $token;
?>