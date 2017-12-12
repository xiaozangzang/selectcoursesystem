<?php require_once('Connections/selectcoursesystem.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['stuid'])) {
  $loginUsername=$_POST['stuid'];
  $password=$_POST['stupassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "welcome-stu.php";
  $MM_redirectLoginFailed = "loginfailed.php";
  $_SESSION['STU_Username'] = $loginUsername;
  $_SESSION['STU_Userpassword'] = $password;	  
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  
  $LoginRS__query=sprintf("SELECT stuid,stuname, stupassword FROM student WHERE stuid=%s AND stupassword=%s",
    GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "int")); 
   
  $LoginRS = mysql_query($LoginRS__query, $selectcoursesystem) or die(mysql_error());
  $row_Recordset = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    $loginStrGroup = "";
    $_SESSION['stuname'] = $row_Recordset['stuname'];
    setcookie("uid",$row_Recordset['stuid'],0,'/');
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生登录</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div>
    <div >
        <h1><p style="color:blue;" >学生选课子系统</p></h1>
        <p>
        <h3 style="color: red;" >选课通知：<br/></h3>
        新学期选课已经开始，请同学们按规定在指定时间内登录选课<br />
        系统选课！每位同学每学期所选课程总学分不得低于18学分！</p>
    </div>
  <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
    <table width="400" border="1" align="center">
      <tr>
        <td width="200" align="center">学号：</td>
        <td width="200" align="center"><label for="stuid"></label>
        <input name="stuid" type="text" id="stuid" size="15" /></td>
      </tr>
      <tr>
        <td width="200" align="center">学生密码：</td>
        <td width="200" align="center"><input name="stupassword" type="password" id="stupassword" size="15" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="登录" /></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>