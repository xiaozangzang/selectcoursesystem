<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_selectcoursesystem = "localhost";
$database_selectcoursesystem = "courseselection";
$username_selectcoursesystem = "root";
$password_selectcoursesystem = "root";
$selectcoursesystem = mysql_pconnect($hostname_selectcoursesystem, $username_selectcoursesystem, $password_selectcoursesystem) or trigger_error(mysql_error(),E_USER_ERROR); 
?>