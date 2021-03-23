<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include("../../checklogin.php");

$ccode=str_replace("'",'',$_GET['cc']);
$ocode=str_replace("'",'',$_GET['oc']);

if(isset($_GET['slc']))
    $slc=str_replace("'",'',$_GET['slc']);

if($ccode!='' && $ocode!='')
{

    $db->where("state_code", "%$ocode%", "LIKE");
    $cols = array("code", "name");
    $db->orderBy("sort", "DESC");
    $city = $db->get("city", null, $cols);
    $cityCount = $db->count;

    if($cityCount>0)
    {?>
        <option value="" selected="selected"></option>
        <?php
        foreach ($city as $value) {
            ?>
            <option value="<?php echo $value['code']?>" <?php if($slc==$value['code']) echo 'selected="selected"'; ?>><?php echo $value['name']?></option>
            <?php
        };
    }
}
?>