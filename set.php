<?php
session_start();
require_once('includes/class/MysqlDB/MysqliDb.php');
require_once('Connections/cn.php');
require_once('Connections/cn2.php');

require_once("safeval.php");
include ("includes/file/jdf.php");
include ("includes/file/function.php");


$portalid="0";
mysqli_select_db($cn,$database_cn);
$query_rsset = "select * from settings" ;
$rsset = mysqli_query($cn,$query_rsset) or die(mysqli_error($cn));
$Site_Information = mysqli_fetch_assoc($rsset);

mysqli_select_db($cn,$database_cn);
$query_rssettings_param = "select * from settings_param" ;
$rssettings_param = mysqli_query($cn,$query_rssettings_param) or die(mysqli_error($cn));
$Site_settings_param = mysqli_fetch_assoc($rssettings_param);


$Site_Information_patam=array();
do{
    $Site_Information_patam[$Site_settings_param['code']] = $Site_settings_param['value'];
} while($Site_settings_param = mysqli_fetch_assoc($rssettings_param));

?>