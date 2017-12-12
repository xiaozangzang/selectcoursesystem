<?php require_once('check.php'); ?>
<?php
header("Content-Type:text/html;charset=UTF-8");
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/selectcoursesystem.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
  if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //查询所有课程时间
  $query= sprintf("select classtime from stucourse where stuid = %s",
                GetSQLValueString($_POST['stuid'], "int")
                );
  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result3 = mysql_query($query, $selectcoursesystem) or die(mysql_error());
  $row_Recordset3 = mysql_fetch_assoc($Result3);
  //课程冲突则跳转至alert.html
  if(in_array($_POST['classtime'],$row_Recordset3)){
      //header("location:alert.html");
      echo "当前课程已选，请重新选课！";
      echo "<a href='course-stu.php'>返回</a>";
      exit();
  }
  $insertSQL = sprintf("INSERT INTO stucourse (stuid, stuname, collegename, major, `class`, teaid,teaname, courseid,coursename, classtime) VALUES (%s,%s,%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['stuid'], "int"),
                       GetSQLValueString($_POST['stuname'], "text"),
                       GetSQLValueString($_POST['collegename'], "text"),
                       GetSQLValueString($_POST['major'], "text"),
                       GetSQLValueString($_POST['class'], "text"),
                       GetSQLValueString($_POST['teaid'], "int"),
                       GetSQLValueString($_POST['teaname'], "text"),
                       GetSQLValueString($_POST['courseid'], "int"),
                       GetSQLValueString($_POST['coursename'], "text"),
                       GetSQLValueString($_POST['classtime'], "text"));
  //更新选课人数               
  $updateSQL = sprintf("UPDATE course SET selected = %s where courseid = %s",
                        GetSQLValueString($_POST['selected'] + 1, "int"),
                        GetSQLValueString($_POST['courseid'], "int")
                        );
  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($insertSQL, $selectcoursesystem) or die(mysql_error());
  $Result2 = mysql_query($updateSQL, $selectcoursesystem) or die(mysql_error());
  $insertGoTo = "welcome-stu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['STU_Username'])) {
  $colname_Recordset1 = $_SESSION['STU_Username'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = sprintf("SELECT * FROM student WHERE stuid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['courseid'])) {
  $colname_Recordset2 = $_GET['courseid'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset2 = sprintf("SELECT * FROM course WHERE courseid = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $selectcoursesystem) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>请确认是否选课？</title>
</head>
<body>
<div align="center">
<p><a href="welcome-stu.php">返回</a></p>
<p>选课前请确认您的个人信息：</p>
</div>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  
  <table width="400" border="1" align="center">
    <tr>
      <td align="center">学号：</td>
      <td align="center"><label for="stuid"></label>
      <input name="stuid" type="text" id="stuid" value="<?php echo $_SESSION['STU_Username']; ?>" size="15" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="center">姓名：</td>
      <td align="center"><input name="stuname" type="text" id="stuname" value="<?php echo $row_Recordset1['stuname']; ?>" size="15" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="center">学院名称：</td>
      <td align="center"><input name="collegename" type="text" id="collegename" value="<?php echo $row_Recordset1['collegename']; ?>" size="15" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="center">所在专业：</td>
      <td align="center"><input name="major" type="text" id="major" value="<?php echo $row_Recordset1['major']; ?>" size="15" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="center">所在班级：</td>
      <td align="center"><input name="class" type="text" id="class" value="<?php echo $row_Recordset1['class']; ?>" size="15" readonly="readonly" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="1000" border="1" align="center">
    <tr>
      <td align="center">课程代码</td>
      <td align="center">课程名称</td>
      <td align="center">教师编号</td>
      <td align="center">教师姓名</td>
      <td align="center">已选人数</td>
      <td align="center">总人数</td>
      <td align="center">上课时间</td>
      <td align="center">地点</td>
      <td align="center">学分</td>
      <td align="center">讲授学时</td>
      <td align="center">实验学时</td>
    </tr>
    <tr>
      <td align="center"><label for="courseid"></label>
      <input name="courseid" type="text" id="courseid" value="<?php echo $row_Recordset2['courseid']; ?>" size="10" readonly="readonly" /></td>
      <td align="center"><input name="coursename" type="text" id="coursename" value="<?php echo $row_Recordset2['coursename']; ?>" size="10" readonly="readonly" /></td>
      <td align="center"><input name="teaid" type="text" id="teaid" value="<?php echo $row_Recordset2['teaid']; ?>" size="10" readonly="readonly" /></td>
      <td align="center"><input name="teaname" type="text" id="teaname" value="<?php echo $row_Recordset2['teaname']; ?>" size="10" readonly="readonly" /></td>
      <td align="center"><input name="selected" type="text" id="selected" value="<?php echo $row_Recordset2['selected']; ?>" size="5" readonly="readonly" /></td>
      <td align="center"><?php echo $row_Recordset2['total']; ?></td>
      <td align="center"><input name="classtime" type="text" id="classtime" value="<?php echo $row_Recordset2['classtime']; ?>" size="10" readonly="readonly" /></td>
      <td align="center"><?php echo $row_Recordset2['classroom']; ?></td>
      <td align="center"><?php echo $row_Recordset2['credit']; ?></td>
      <td align="center"><?php echo $row_Recordset2['shangketime']; ?></td>
      <td align="center"><?php echo $row_Recordset2['shiyantime']; ?></td>
    </tr>
    <tr>
      <td colspan="12" align="center"><input type="submit" name="submit" id="submit"  onclick="return confirm('确定选该课程吗？')" value="提交" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
