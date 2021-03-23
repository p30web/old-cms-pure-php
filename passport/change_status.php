<?php 
require_once('checklogin_root.php');  

if($checkaccc==1)
{//start check access
$colname_rs1 = "-1";
if (isset($_GET['id']) and isset($_GET['table']) and isset($_GET['field'])) {
  $colname_rs1 = trim(decrypt($_GET['id'],session_id()."sts"));
  $field = trim(decrypt($_GET['field'],session_id()."sts"));
  $table = trim(decrypt($_GET['table'],session_id()."sts"));
}
$db->where("id", $colname_rs1);
$cols = array("id", $field);
$row_rs1 = $db->getOne($table, $cols);
$totalRows_rs1 = $db->count;

if($row_rs1[$field]==1)
$newstatus=0;
elseif($row_rs1[$field]==0)
$newstatus=1;

$db->where("id", $colname_rs1);
$uparray = array(
    $field => $newstatus
);
$db->update($table, $uparray);
echo "<script>window.location='".$_SERVER['HTTP_REFERER']."';</script>";


}////check access
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

</body>
</html>

