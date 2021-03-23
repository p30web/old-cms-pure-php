<?php
mysqli_select_db($cn,$database_cn);
$query_rsset = "select * from settings where id=1" ;
$rsset = mysqli_query($cn,$query_rsset) or die(mysqli_error($cn));
$Site_Information = mysqli_fetch_assoc($rsset);

mysqli_select_db($cn,$database_cn);
$query_rssettings_param = "select * from settings_param WHERE portalid=1 " ;
$rssettings_param = mysqli_query($cn,$query_rssettings_param) or die(mysqli_error($cn));
$Site_settings_param = mysqli_fetch_assoc($rssettings_param);


$Site_Information_param=array();
do{
    $Site_Information_param[$Site_settings_param['code']] = $Site_settings_param['value'];
} while($Site_settings_param = mysqli_fetch_assoc($rssettings_param));