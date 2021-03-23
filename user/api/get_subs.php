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
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_members = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_members = $db->getOne("members");
}

if ($db->count > 0) {
    if(
    $_GET['pagination']
    ){

        $db->where("parent_id", $fetch_members['id']);
        $db->get("members", null, "id");
        $totalItems = $db->count;

        $pagination = GetSQLValueString($_GET['pagination'], "def");

        $page = ($pagination['page']) ? $pagination['page'] : 0;
        $perpage = ($pagination['perpage']) ? $pagination['perpage'] : 10;
        $total = $totalItems;



        $offset = $perpage * ($page - 1);

        $limit = array($offset, $perpage);


        $member_cols = array(
            "id",
            "email",
            "img",
            "firstname",
            "lastname",
            "status",
            "create_at",
            "refIncome",
            "dollar_refIncome",
        );

        if(
        $_GET['sort']
        ){
            $sort = $_GET['sort'];
            //            $db->orderBy(GetSQLValueString($sort['field'], "text"), GetSQLValueString($sort['sort'], "text"));
        }


        $db->where("parent_id", $fetch_members['id']);

        if(
        $_GET['query']
        ){
            $query = $_GET['query'];
            //print_r($query);
            if($query['status'] != null){
                $db->where("status", GetSQLValueString($query['status'] , "def"));
            }
            if($query['generalSearch'] != null){
                $db->where("firstname", '%'.GetSQLValueString($query['generalSearch'], "def").'%', "LIKE");
                $db->orWhere("lastname", '%'.GetSQLValueString($query['generalSearch'], "def").'%', "LIKE");
                $db->orWhere("email", '%'.GetSQLValueString($query['generalSearch'], "def").'%', "LIKE");
                $db->where("parent_id", $fetch_members['id']);
            }

        }




        $childes = $db->get("members", $limit, $member_cols);

//        if($_SESSION['member_id'] == 98){
//            print_r($pagination);
//            var_dump($page);
//            var_dump($perpage);
//            var_dump($total);
//            print_r($limit);
//            print_r($childes);
//            exit();
//        }

        $childes_row_count = $db->count;

        $REST->responseArray = array(
            "status" => 200,
            "meta" => array(
                "page" => $page,
                //            "pages" => $pages,
                "perpage" => $perpage,
                "total" => $total,
                "sort" => "desc",
                "field" => "id"
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
