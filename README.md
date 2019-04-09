# mail-system  
`表category`

|字段名|数据类型|备注|
|:---:|:---:|:---:|
|cateid|int|分组ID|
|catename|varchar(20)|分组名称|

`表custinfo`

|字段名|数据类型|备注|
|:---:|:---:|:---:|
|csname|text|客户名|
|csid|int|客户ID|
|csmail|varchar(100)|客户邮箱地址|
|cscate|int|分组ID|
|csflag|bit|停用标记（1停用\|0启用）|
|csdate|date|最后发送日期|

`表eee` 
**此表单纯用于导入导出，暂时不参与邮件群发**

|字段名|数据类型|备注|
|:---:|:---:|:---:|
|公司名|text|公司名|
|姓名|text|人名|
|mailname|varchar(50)|邮箱地址|
|class|varchar(30)|分类编号|

`表mailinfo`

`表userinfo`

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
