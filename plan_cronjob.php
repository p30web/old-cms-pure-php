<?php
/**
 * Update by P30web.org
 * User: a.ahmadi
 * Date: 12/10/2019
 * Time: 10:04 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('/home/irandogebank/public_html/includes/class/MysqlDB/MysqliDb.php');
require_once('/home/irandogebank/public_html/Connections/cn2.php');
require_once('/home/irandogebank/public_html/includes/file/function.php');
require_once ("/home/irandogebank/public_html/user/lib/file/activity_log.php");

date_default_timezone_set('Asian/Tehran');

$plans = $db->get('active_investment_plan');

if ($db->count > 0) {
    foreach ($plans as $plan) {
        if($plan['status'] == 5){
            $db->where("id", $plan['member_id']);
            $db->where("status", 1);
            $fetch_mem = $db->getOne("members");
            $GetPlanTime = time() - $plan['time'];

            //print_r($plan);

            if($plan['period_type'] == "3month"){
                $m = 2592000 * 3;
            }else {
                $m = 2592000;
            }

            if($fetch_mem != null){

                //print_r($fetch_mem);

                var_dump($GetPlanTime);
                var_dump($m);

                if ($m < $GetPlanTime){

                    $update_plan = array(
                        "status"=> '2'
                    );

                    $db->where("id", $plan['id']);
                    $db->update("active_investment_plan", $update_plan);

                    if(is_null($plan['type'])){

                        $update_member = array(
                            "cash"=> $fetch_mem['cash'] + $plan['price']
                        );

                        $db->where("id", $fetch_mem['id']);
                        $db->update("members", $update_member);

                        activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan", "پایان پلن سرمایه گذاری دوچ کوین و بازگشت مبلغ ".$plan['price']);
                    }

                    if(!is_null($plan['type']) && $plan['type'] == "dollar"){

                        $update_member = array(
                            "dollar_credit"=> $fetch_mem['dollar_credit'] + $plan['price']
                        );

                        $db->where("id", $fetch_mem['id']);
                        $db->update("members", $update_member);

                        activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan", "پایان پلن سرمایه گذاری دلاری و بازگشت مبلغ ".$plan['price']);

                    }


                }else{



                    if(is_null($plan['type'])){
                        $profit = $plan['daily_profit']; // سود رزوانه
                        $profit = round($profit,4); // رند کردن سود روزانه

                        $refProfit = $profit*0.1; // سود زیر مجموعه
                        $refProfit = round($refProfit,4); // رند کردن سود زیر مجموعه

                        // اگر پلن دوج کوین بود این شرط اعنال بشه

                        if($fetch_mem['parent_id'] != null){
                            // اگر زیر مجموعه داشت
                            $update_member = array(
                                "cash"=> $fetch_mem['cash'] + $profit,
                                "refIncome"=> $fetch_mem['refIncome'] + $refProfit,
                                "profit"=> $fetch_mem['profit'] + ($profit)
                            );
                        }else{
                            $update_member = array(
                                "cash"=> $fetch_mem['cash'] + $profit,
                                "profit"=> $fetch_mem['profit'] + $profit
                            );
                        }
                        $db->where("id", $fetch_mem['id']);
                        $db->update("members", $update_member);

                        activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود روزانه دوج کوین به مبلغ".$profit);

                        if($fetch_mem['parent_id'] != null){

                            $db->where("id", $fetch_mem['parent_id']);
                            $db->where("status", "1");
                            $fetch_mem_ref = $db->getOne("members", ["id", "cash", "profit"]);

                            $update_member_ref = array(
                                "cash"=> $fetch_mem_ref['cash'] + $refProfit,
                                "profit"=> $fetch_mem['profit'] + $refProfit

                            );
                            $db->where("id", $fetch_mem_ref['id']);
                            $db->update("members", $update_member_ref);

                            activity_log($fetch_mem_ref['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود زیرمجموعه های دوج کوین به مبلغ ".$refProfit);
                        }
                    }

                    // اگر پلن دولاری بود این شرط باید اعمال بشه :

                    if(!is_null($plan['type']) && $plan['type'] == "dollar"){


                        $profit = $plan['daily_profit']; // سود رزوانه
                        $profit = round($profit,4); // رند کردن سود روزانه

                        $refProfit = $profit*0.1; // سود زیر مجموعه
                        $refProfit = round($refProfit,4); // رند کردن سود زیر مجموعه

                        // اگر پلن دوج کوین بود این شرط اعنال بشه

//                        if($fetch_mem['parent_id'] != null){
//
//                            var_dump(222222222222222);
//
//
//                            $db->where("id", $fetch_mem['parent_id']);
//                            $get_mem_ref = $db->getOne("members");
//
//                            // اگر زیر مجموعه داشت
//                            $update_member_ref = array(
//                                "dollar_credit" => $get_mem_ref['dollar_credit'] + $profit,
//                                "dollar_refIncome" => $get_mem_ref['dollar_refIncome'] + $refProfit,
//                                "dollar_profit"=> $get_mem_ref['dollar_profit'] + $profit
//                            );
//
//                            $db->where("id", $get_mem_ref['id']);
//                            $db->update("members", $update_member_ref);
//
//                            activity_log($get_mem_ref['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود زیرمجموعه های دلاری به مبلغ ".$refProfit);
//                        }
//                        else{
//                            var_dump(11111111111111111);
//
//                            $db->where("id", $fetch_mem['id']);
//                            $get_member = $db->getOne("members");
//
//                            $update_member = array(
//                                "dollar_credit"=> $get_member['dollar_credit'] + $profit,
//                                "dollar_profit"=> $get_member['dollar_profit'] + $profit
//                            );
//
//                            $db->where("id", $get_member['id']);
//                            $db->update("members", $update_member);
//
//                            activity_log($get_member['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود روزانه دلاری به مبلغ ".$profit);
//
//                        }


                        if($fetch_mem['parent_id'] != null){
                            // اگر زیر مجموعه داشت
                            $db->where("id", $fetch_mem['id']);
                            $get_member = $db->getOne("members");

                            // اگر زیر مجموعه داشت
                            $update_member = array(
                                "dollar_credit" => $get_member['dollar_credit'] + $profit,
                                "dollar_refIncome" => $get_member['dollar_refIncome'] + $refProfit,
                                "dollar_profit"=> $get_member['dollar_profit'] + $profit
                            );

                        }else{
                            $db->where("id", $fetch_mem['id']);
                            $get_member = $db->getOne("members");

                            $update_member = array(
                                "dollar_credit"=> $get_member['dollar_credit'] + $profit,
                                "dollar_profit"=> $get_member['dollar_profit'] + $profit
                            );
                        }

                        $db->where("id", $fetch_mem['id']);
                        $db->update("members", $update_member);

                        activity_log($get_member['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود روزانه دلاری به مبلغ ".$profit);



                        if($fetch_mem['parent_id'] != null){
                            $db->where("id", $fetch_mem['parent_id']);
                            $get_mem_ref = $db->getOne("members");

                            $update_member_ref = array(
                                "dollar_credit" => $get_mem_ref['dollar_credit'] + $refProfit,
                                "dollar_profit"=> $get_mem_ref['dollar_profit'] + $refProfit
                            );

                            $db->where("id", $get_mem_ref['id']);
                            $db->update("members", $update_member_ref);

                            activity_log($get_mem_ref['id'], $_SERVER['REQUEST_URI'],1, "active_investment_plan","واریز سود زیرمجموعه های دلاری به مبلغ ".$refProfit);
                        }
                    }
                }
            }
        }else {
            // not ok
        }
    }
}else{
    //echo "<p class='alert alert-danger'>هیچ پلن فعالی وجود ندارد</p>";
    // erorr
}

echo 'Daily profits made by users';