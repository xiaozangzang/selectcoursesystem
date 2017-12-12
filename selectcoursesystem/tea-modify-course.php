<?php require_once('check.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE course SET coursename=%s, classtime=%s,classroom=%s, credit=%s, shangketime=%s,shiyantime=%s WHERE courseid=%s",
                       GetSQLValueString($_POST['coursename'], "text"),
                       GetSQLValueString($_POST['classtime'], "text"),
                       GetSQLValueString($_POST['classroom'], "text"),
                       GetSQLValueString($_POST['credit'], "int"),
                       GetSQLValueString($_POST['shangketime'], "int"),
                       GetSQLValueString($_POST['shiyantime'], "int"),
                       GetSQLValueString($_POST['courseid'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($updateSQL, $selectcoursesystem) or die(mysql_error());

  $updateGoTo = "course-tea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['courseid'])) {
  $colname_Recordset1 = $_GET['courseid'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = sprintf("SELECT * FROM course WHERE courseid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改信息</title>
<script LANGUAGE="JavaScript">

function validate()
{
var tag = confirm('确定修改吗?');
if( tag == true )
dc();
else
return false;
}
</script>
</head>

<body>
<div align="center" width="1000">
    <p><a href="course-tea.php">返回</a></p>
    <label >请进行课程信息的修改并保存：</label>
</div>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="1000" border="1" align="center">
    <tr>
      <td align="center">课程编号</td>
      <td align="center">课程名称</td>
      <td align="center">上课时间</td>
      <td align="center">上课地点</td>
      <td align="center">讲授学时</td>
      <td align="center">实验学时</td>
      <td align="center">学分</td>
      <td align="center">操作</td>
    </tr>
    <tr>
      <td align="center"><label for="courseid"></label>
      <input name="courseid" type="text" id="courseid" readonly="readonly" value="<?php echo $row_Recordset1['courseid']; ?>" size="10"/></td>
      <td align="center"><input name="coursename" type="text" id="coursename" value="<?php echo $row_Recordset1['coursename']; ?>" size="10" /></td>
      <td align="center"><input name="classtime" type="text" id="classtime" value="<?php echo $row_Recordset1['classtime']; ?>" size="10" /></td>
      <td align="center"><input name="classroom" type="text" id="classroom" value="<?php echo $row_Recordset1['classroom']; ?>" size="10" /></td>
      <td align="center"><input name="credit" type="text" id="credit" value="<?php echo $row_Recordset1['credit']; ?>" size="10" /></td>
      <td align="center"><input name="shangketime" type="text" id="shangketime" value="<?php echo $row_Recordset1['shangketime']; ?>" size="10" /></td>
      <td align="center"><input name="shiyantime" type="text" id="shiyantime" value="<?php echo $row_Recordset1['shiyantime']; ?>" size="10" /></td>
      <td align="center"><input type="submit" name="submit" id="submit" onclick="validate();return false" value="保存" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
