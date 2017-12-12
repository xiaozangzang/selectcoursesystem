<?php require_once('check.php'); ?>
<?php require_once('Connections/selectcoursesystem.php'); ?>
<?php
header("Content-Type:text/html;charset=utf-8");
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
//保存学生选课子系统公告
$savestudentinform = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $savestudentinform .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_EDIT1"])) && ($_POST["MM_EDIT1"] == "form1")) {
  $UPDATESTUDENTINFORM = sprintf("UPDATE admin SET studentinform = %s",
                       GetSQLValueString($_POST['studentinform'], "text"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($UPDATESTUDENTINFORM, $selectcoursesystem) or die(mysql_error());

  $insertGoTo = "welcome-admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//保存教师管理子系统公告
if ((isset($_POST["MM_EDIT2"])) && ($_POST["MM_EDIT2"] == "form2")) {
  $UPDATETEACHERINFORM = sprintf("UPDATE admin SET teacherinform = %s",
                       GetSQLValueString($_POST['teacherinform'], "text"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result2 = mysql_query($UPDATETEACHERINFORM, $selectcoursesystem) or die(mysql_error());

  $insertGoTo = "welcome-admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

//查询公告信息
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = "SELECT studentinform,teacherinform FROM admin";
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公告管理</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div>
  <p><a href="welcome-admin.php">返回</a></p>
  <p>编辑公告：</p>
    	<form id="form1" name="form1" method="POST" action="<?php echo $savestudentinform; ?>">
    	  <table width="600" border="1" align="center">
    	    <tr>
    	      <td width="100" align="center">学生选课子系统公告</td>
    	      <td align="center" width="400">
              <textarea name="studentinform" id="studentinform" rows="4" cols="50" ><?php echo $row_Recordset1['studentinform'] ?></textarea>
   	          </td>
    	      <td width="100" align="center"><input type="submit" name="submit" id="submit" onclick="return confirm('确定保存？')" value="保存" /></td>
  	        </tr>
  	    </table>
        <input type="hidden" name="MM_EDIT1" value="form1" />
      </form>
  </div>
  <div>
  	<form id="form2" name="form2" method="post" action="">
  	  <table width="600" border="1" align="center">
  	    <tr>
  	      <td width="100" align="center">教师管理子系统公告</td>
          <td width="400" align="center">
              <textarea name="teacherinform" id="teacherinform" rows="4" cols="50"><?php echo $row_Recordset1['teacherinform'] ?></textarea>
          </td>
          <td width="100" align="center"><input type="submit" name="submit" id="submit" onclick="return confirm('确定保存？')" value="保存" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_EDIT2" value="form2" />
    </form>
  </div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
