<?PHP
$ServerName = "localhost";
$DatabaseName = "clinic";
$User = "root"; 
$Password = "";

$Conn = mysql_connect($ServerName,$User,$Password) or die ("ไม่สามารถติดต่อกับเซิร์ฟเวอร์ได้ ");
mysql_select_db($DatabaseName,$Conn) or die ("ไม่สามารถติดต่อกับฐานข้อมูลได้");

mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
$add_complete="บันทึกข้อมูลเรียบร้อยแล้ว";
$edit_complete="แก้ไขข้อมูลเรียบร้อยแล้ว";
?>