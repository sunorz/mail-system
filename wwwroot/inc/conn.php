<?php 
if(!isset($_SESSION))
{
session_start(); 
}
$con = mysql_connect("localhost","root","yourpassword");//连接数据库服务器
if (!$con)
  {
  die('无法连接数据库： ' . iconv("gb2312","utf-8//IGNORE",mysql_error()));
  }
 
        mysql_select_db("co_cms", $con);//连接指定的数据库
		return $con;
		?>