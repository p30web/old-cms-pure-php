<?php
require_once('../../checklogin.php');

if($checkaccc==1)
{//start check access
    $colname_rs1 = "-1";
    if (isset($_GET['id'])) {
        $colname_rs1 = trim(decrypt($_GET['id'],session_id()."red"));
    }
    $db->where("id", $colname_rs1);
    $cols = array("id", "`read`");
    $row_rs1 = $db->getOne("message", $cols);
    $totalRows_rs1 = $db->count;

    if($row_rs1["read"]==1)
        $newstatus=0;
    elseif($row_rs1["read"]==0)
        $newstatus=1;

    $db->where("id", $colname_rs1);
    $uparray = array(
        "read" => $newstatus
    );
    $db->update("message", $uparray);
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

