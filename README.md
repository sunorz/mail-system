# mail-system  
Username:admin  
Password:admin  

- 把tools-encry.php.config重命名为tools-encry.php  
- 将里面的$str修改为发件人的密码  
- 访问tools-encry.php这个页面，你会获得加密后的密码  
- 将加密后的密码插入mailinfo的mapwd内，maaddr填入邮箱地址
- 系统的登录密码经过md5加密后存放于数据库中

- Rename tools-encry.php.config to tools-encry.php  
- Change the $str inside to the sender's password.  
- Go to the tools-encry.php page and you will get the encrypted password.  
- Insert the encrypted password into the mapwd of mailinfo, maaddr fill in the email address. 
- The login password of the system is encrypted by md5 and stored in the database.