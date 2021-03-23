<?php
/**
 * Update by P30web.org
 * User: a.ahmadi
 * Date: 12/10/2019
 * Time: 10:04 PM
 */

if(isset($_GET['pass']) && !empty($_GET['pass'])){
    if($_GET['pass'] != "nmsd23"){
        exit('No accss');
    }
}else {
    exit('No accss');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/class/MysqlDB/MysqliDb.php');
require_once('../Connections/cn2.php');
require_once('../includes/file/function.php');
require_once ("../user/lib/file/activity_log.php");

date_default_timezone_set('Asian/Tehran');

?>

    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        table#customers a {color: #fff;background: #000;}

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
        #customers th,td {
            text-align: center;
            font-family: Tahoma;
        }
        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        .alert-heading {
            color: inherit;
        }
        .alert .close {
            position: relative;
            top: -2px;
            right: -21px;
            line-height: 18px;
            text-align: right;
            direction: rtl;
        }
        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #468847;
        }
        .alert-danger,
        .alert-error {
            background-color: #f2dede;
            border-color: #eed3d7;
            color: #b94a48;
        }
        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #3a87ad;
        }
        .alert-block {
            padding-top: 14px;
            padding-bottom: 14px;
        }
        .alert-block > p,
        .alert-block > ul {
            margin-bottom: 0;
        }
        .alert-block p + p {
            margin-top: 5px;
        }
    </style>
<?php
$plans = $db->get('active_investment_plan');

if ($db->count > 0) {
    echo "ok : $db->count";
    echo "<table id='customers'>";
    echo "<tr>";
    echo "<th>شناسه</th>";
    echo "<th>عنوان پلن</th>";
    echo "<th>شناسه پلن کاربر</th>";
    echo "<th>شناسه کاربر</th>";
    echo "<th>سود روزانه</th>";
    echo "<th>سود روز اول</th>";
    echo "<th>قیمت پلن</th>";
    echo "<th>شناسه واحد مالی</th>";
    echo "<th>درصد سود</th>";
    echo "<th>دوره خرید</th>";
    echo "<th>دوره</th>";
    echo "<th>تاریخ بروز رسانی</th>";
    echo "<th>زمان</th>";
    echo "<th>وضعیت</th>";
    echo "</tr>";

    foreach ($plans as $plan) {

        echo "<tr>";

        if($plan['status'] == 1){

            $db->where("id", $plan['member_id']);
            $db->where("status", "1");
            $fetch_mem = $db->getOne("members", ["id", "cash", "parent_id", "refIncome", "profit","firstname","lastname"]);

            $time = time() - $plan['time'];
            $m = 2592000;


            //echo "time : $time - t2 : " . $plan['time'] . "  date : " . (date("Y-m-d",$plan['time'])) . "t3 : " . time() ;

//            if($fetch_mem != null){
//                if ($m < $time‬){
//
//                    $update_plan = array(
//                        "status"=> '2'
//                    );
//                    $db->where("id", $plan['id']);
//                    $db->update("active_investment_plan", $update_plan);
//
//                    $update_member = array(
//                        "cash"=> $fetch_mem['cash'] + $plan['price']
//                    );
//                    $db->where("id", $fetch_mem['id']);
//                    $db->update("members", $update_member);
//
//                    activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan", "پایان پلن سرمایه گذاری و بازگشت مبلغ ".$plan['price']);
//                }else{
//
//
//                    $profit = $plan['daily_profit']; // سود رزوانه
//                    $profit = round($profit,4); // رند کردن سود روزانه
//
//                    $refProfit = $profit*0.1; // سود زیر مجموعه
//                    $refProfit = round($refProfit,4); // رند کردن سود زیر مجموعه
//
//                    if($fetch_mem['parent_id'] != null){
//                        // اگر زیر مجموعه داشت
//                        $update_member = array(
//                            "cash"=> $fetch_mem['cash'] + $profit,
//                            "refIncome"=> $fetch_mem['refIncome'] + $refProfit,
//                            "profit"=> $fetch_mem['profit'] + ($profit)
//                        );
//                    }else{
//                        $update_member = array(
//                            "cash"=> $fetch_mem['cash'] + $profit,
//                            "profit"=> $fetch_mem['profit'] + $profit
//                        );
//                    }
//                    $db->where("id", $fetch_mem['id']);
//                    $db->update("members", $update_member);
//
//                    activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود روزانه به مبلغ ".$profit);
//
//                    if($fetch_mem['parent_id'] != null){
//
//                        $db->where("id", $fetch_mem['parent_id']);
//                        $db->where("status", "1");
//                        $fetch_mem_ref = $db->getOne("members", ["id", "cash", "profit"]);
//
//                        $update_member_ref = array(
//                            "cash"=> $fetch_mem_ref['cash'] + $refProfit,
//                            "profit"=> $fetch_mem['profit'] + $refProfit
//
//                        );
//                        $db->where("id", $fetch_mem_ref['id']);
//                        $db->update("members", $update_member_ref);
//
//                        activity_log($fetch_mem_ref['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود زیرمجموعه به مبلغ ".$refProfit);
//                    }
//
//
//                }
//            }


            foreach ($plan as $key => $plan_item){
                if($fetch_mem == null){
                    echo "<td style='background-color: yellow;color:#000;'>";
                    echo $plan_item;
                    echo "</td>";
                }else{
                    echo "<td>";
                    if($key == "member_id"){
                        echo "<a href='https://www.irandogebank.com/api/show-activity-user.php?pass=nmsd23&userid=" . $plan_item .  "'>";
                        echo $fetch_mem['firstname'] . " " . $fetch_mem['lastname'] . "($plan_item)";
                        echo "</a>";
                    }else {
                        echo $plan_item;
                    }
                    echo "</td>";
                }

            }

        }else {

            $db->where("id", $plan['member_id']);
            $db->where("status", "1");
            $fetch_mem = $db->getOne("members",["firstname","lastname"]);

            foreach ($plan as $key => $plan_item){
                echo "<td style='background-color: red;color:#fff;'>";
                if($key == "member_id"){
                    echo "<a href='https://www.irandogebank.com/api/show-activity-user.php?pass=nmsd23&userid=" . $plan_item .  "'>";
                    echo $fetch_mem['firstname'] . " " . $fetch_mem['lastname'] . "($plan_item)";
                    echo "</a>";
                }else {
                    echo $plan_item;
                }
                echo "</td>";
            }
        }

        echo "</tr>";

    }
    echo "</table>";
}else{
    echo "<p class='alert alert-danger'>هیچ پلن فعالی وجود ندارد</p>";
}
