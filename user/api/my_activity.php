<?php
include("../checklogin.php");


//include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
//require_once('../includes/classes/mysql/MysqliDb.php');
//require_once('../Connections/cn.php');
//require_once('../includes/file/jdf.php');
//require_once('../includes/file/function.php');
//date_default_timezone_set('Asian/Tehran');

$REST = new \lib\classes\RestService();
$crypto = new \lib\classes\Crypto();

$REST->CorsArray = array(
    "AllowOrigin" => array("*"),
    "MaxAge" => 10,
    "AllowCredentials" => true,
//  "ExposeHeaders"=> array("Cache-Control", "Content-Language"),
    "AllowMethods" => array("GET"),
    "AllowHeaders" => array("Content-Type, charset"),
    "ContentType" => "application/json"
);
$REST->Authorization = false;
$REST->method = array("GET");
$Data = $REST->Processing();


$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id",$fetch_admin[0]['admin_id']);
    $fetch_members = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_members = $db->getOne("members");
}

if ($db->count > 0) {
    if(
    $_GET['pagination']
    ){

        $dbl->where("user_id", $fetch_members['id']);
        $dbl->get("member_activity", null, "id");
        $totalItems = $dbl->count;

        $pagination = GetSQLValueString($_GET['pagination'], "def");

        $page = ($pagination['page']) ? $pagination['page'] : 0;
        $perpage = ($pagination['perpage']) ? $pagination['perpage'] : 10;
        $total = $totalItems;

        $limit = array($page-1, $perpage);

        $member_activity_cols = array(
            "id",
            "user_ip",
            "message",
            "time"
        );

        if(
        $_GET['sort']
        ){
            $sort = $_GET['sort'];
//            $dbl->orderBy(GetSQLValueString($sort['field'], "text"), GetSQLValueString($sort['sort'], "text"));
        }else{
        }


        $dbl->where("user_id", $fetch_members['id']);
        $dbl->orderBy("time", "DESC");
        $childes = $dbl->get("member_activity", $limit, $member_activity_cols);
        $childes_row_count = $dbl->count;
        for ($i = 0; $i < $childes_row_count; $i++){
            $childes[$i]['time'] = jdate("Y/m/d H:i:s", $childes[$i]['time']);
        }
        $REST->responseArray = array(
            "status" => 200,
            "meta" => array(
                "page" => $page,
//            "pages" => $pages,
                "perpage" => $perpage,
                "total" => $total,
                "sort" => "desc",
                "field" => "time"
            ),
            "data"=>$childes
        );
    }

} else {
    $REST->responseArray = array(
        "status" => 403, "msg" => \lib\classes\RestService::$codes['403']

    );
}

echo $REST->RseponseToC();
