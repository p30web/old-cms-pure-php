<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include("../../checklogin.php");
$ccode=str_replace("'",'',$_GET['cc']);

if(isset($_GET['slc']))
    $slc=str_replace("'",'',$_GET['slc']);

if($ccode!='')
{
    $db->where("country_code", "%$ccode%", "LIKE");
    $cols = array("code", "name");
    $db->orderBy("sort", "DESC");
    $State = $db->get("state", null, $cols);
    $stateCount = $db->count;

    if($stateCount>0)
    {?>
        <option value="" selected="selected"></option>
        <?php
        foreach ($State as $value) {
            ?>
            <option value="<?php echo $value['code']?>" <?php if($slc==$value['code']) echo 'selected="selected"'; ?>><?php echo $value['name']?></option>
            <?php
        }
    }
}
?>