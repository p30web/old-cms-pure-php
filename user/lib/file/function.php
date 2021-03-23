<?php 
//require_once('../../checklogin.php');

function ago_time($ptime){
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'کمتر از 1 ثانیه قبل';
    }

    $condition = array(
        12 * 30 * 24 * 60 * 60  =>  'سال',
        30 * 24 * 60 * 60       =>  'ماه',
        24 * 60 * 60            =>  'روز',
        60 * 60                 =>  'ساعت',
        60                      =>  'دقیقه',
        1                       =>  'ثانیه'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return $r . ' ' . $str . ( $r > 1 ? ' ' : '' ) . ' پیش';
        }
    }
}
/////////////////////////////////////////////////////
function active_plan_status($input)
{
    switch($input)
    {
        case '0' : echo "انتظار";break;
        case '1' : echo "فعال";break;
        case '2' : echo "پایان";break;
        case '3' : echo "لغو";break;
        case '4' : echo "مسدود";break;
        default : echo "نامشخص";break;
    }
}



//////////////////////////////////////////////////////////////////////////////



function checkkhstatus($input)
{
	switch($input)
	{
	case 0 : echo "فوت شده";break;
	case 1 : echo "زنده";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function tfstatus($input)
{
	switch($input)
	{
	case 0 : echo "ندارد";break;
	case 1 : echo "دارد";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////
 function random_token() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 20; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}


function checkserialstatus($input)
{
	switch($input)
	{
	case 0 : echo "<span style='color:#990000;'>فروخته نشده</span>";break;
	case 1 : echo "<span style='color:#006600;'>فروخته شده</span>";break;
	default : echo "<span style='color:#990000;'>نامشخص</span>";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function checkgender($input)
{
	switch($input)
	{
	case 0 : return "نامشخص";break;
	case 1 : return "مرد";break;
	case 2 : return "زن";break;
	default : return "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function blocktype($input)
{
	switch($input)
	{
	case 0 : return "متنی";break;
	case 1 : return "مطالب";break;
	case 2 : return "تصاویر";break;
	case 3 : return "گروه مطالب";break;
	case 4 : return "گروه تصاویر";break;
	case 5 : return "لینک ها";break;
	case 6 : return "تبلیغات";break;
	case 7 : return "اسلایدشو";break;
	case 8 : return "ماژول";break;
	case 9 : return "منو";break;
	case 10 : return "نظرسنجی";break;
	default : return "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function blockalign($input)
{
	switch($input)
	{
	case 1 : return "راست";break;
	case 2 : return "چپ";break;
	case 3 : return "وسط";break;
	case 4 : return "بالا";break;
	case 5 : return "پایین";break;
	case 6 : return "راست فرعی";break;
	case 7 : return "چپ فرعی";break;
	default : return "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function blocknoetype($input)
{
	switch($input)
	{
	case 1 : echo "اصلی";break;
	case 2 : echo "فرعی";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function checkdoretype($input)
{
	switch($input)
	{
	case 1 : return "خدمات";break;
	case 2 : return "معرفی نامه";break;
	default : return "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function komitetype($input)
{
	switch($input)
	{
	case 1 : echo "کمیته";break;
	case 2 : echo "سایر";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function checkbedehistatus($input)
{
	switch($input)
	{
	case 0 : echo "پرداخت نشده";break;
	case 1 : echo "پرداخت شده";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function paymentcheckstatus($input)
{
	switch($input)
	{
	case 0 : echo "پرداخت نشده";break;
	case 1 : echo "پرداخت موفق";break;
	case 2 : echo "پرداخت ناموفق";break;
	case 9 : echo "بررسی نشده";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function smssendstatus($input)
{
	switch($input)
	{
	case 0 : echo "نام کاربری و رمز عبور صحیح نمی باشد .";break;
	case 1 : echo "ارسال موفق";break;
	case 2 : echo "اعتبار کافی نمی باشد";break;
	case 3 : echo "محدودیت ارسال روزانه";break;
	case 4 : echo "محدودیت در حجم ارسال";break;
	case 5 : echo "شماره فرستنده معتبر نیست";break;
	case 6 : echo "سامانه در حال به روز رسانی می باشد";break;
	case 7 : echo "متن پیامک شما شامل حروف فیلتر شده می باشد";break;
	case 8 : echo "عدم رسیدن متن به حداقل ارسال";break;
	case 9 : echo "ارسال از خطوط عمومی از طریق وب سرویس مقدور نمی باشد";break;
	case 10 : echo "کاربر مسدود شده است";break;
	case 11 : echo "ارسال نا موفق";break;
	default : echo "ارسال موفق";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function smsdeliverystatus($input)
{
	switch($input)
	{
	case 0 : echo "ارسال شده به مخابرات";break;
	case 1 : echo "رسیده به گوشی";break;
	case 2 : echo "نرسیده به گوشی";break;
	case 3 : echo "خطای مخابراتی";break;
	case 5 : echo "خطای نا مشخص";break;
	case 8 : echo "رسیده به مخابرات";break;
	case 16 : echo "نرسیده به مخابرات";break;
	case 100 : echo "نامشخص";break;
	default : echo "نامشخص";break;
	}
}



//////////////////////////////////////////////////////////////////////////////



function getCategoryTree($cn,$tbl,$code){

		global $categorytree;

		$query_rschecklev = "SELECT * FROM $tbl WHERE code = '$code'";
		$rschecklev = mysqli_query($cn,$query_rschecklev) or die(mysqli_error($cn));
		$row_rschecklev = mysqli_fetch_assoc($rschecklev);
		$totalRows_rschecklev = mysqli_num_rows($rschecklev);

		if($totalRows_rschecklev>0){

			$row_rschecklev['name'] = stripslashes($row_rschecklev['name']);

			$categorytree = $row_rschecklev['name']." : ".$categorytree;

			getCategoryTree($cn,$tbl,$row_rschecklev['level']);

		}else{
			$categorytree = substr($categorytree,0,strrpos($categorytree, ":"));
		}
	}






//////////////////////////////////////////////////////////////////////////////


function encrypt($data, $key)
{
    $encrypt_method = "AES-256-CBC";
    //pls set your unique hashing key
//    $secret_key = 'lyra';
    $secret_key = $key;
    $secret_iv = 'rahaaaa';

    // hash
    $key_ = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number
    $output = openssl_encrypt($data, $encrypt_method, $key_, 0, $iv);
    $output = base64_encode($output);

    return $output;
}


//////////////////////////////////////////////////////////////////////////////


function decrypt($data, $key)
{
    $encrypt_method = "AES-256-CBC";
    //pls set your unique hashing key
//    $secret_key = 'lyra';
    $secret_key = $key;
    $secret_iv = 'rahaaaa';

    // hash
    $key_ = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_decrypt(base64_decode($data), $encrypt_method, $key_, 0, $iv);

    return $output;
}

//////////////////////////////////////////////////////////////////////////////



function checknewstatus($input)
{
	switch($input)
	{
	case 0 : echo "غیرفعال";break;
	case 1 : echo "فعال";break;
	case 2 : echo "در حال بررسی";break;
	case 3 : echo "پیش نویس";break;
	default : echo "نامشخص";break;
	}
}

 

//////////////////////////////////////////////////////////////////////////////



function checkgallerytype($input)
{
	switch($input)
	{
	case 1 : echo "عکس";break;
	case 2 : echo "فیلم";break;
	case 3 : echo "صوت";break;
	default : echo "";break;
	}
}

 


 

//////////////////////////////////////////////////////////////////////////////



function checkadvertisetype($input)
{
	switch($input)
	{
	case 1 : echo "فلش";break;
	case 2 : echo "عکس";break;
	default : echo "";break;
	}
}

 

//////////////////////////////////////////////////////////////////////////////



function checkselecttype($input)
{
	switch($input)
	{
	case 0 : echo "تک انتخابی";break;
	case 1 : echo "چند انتخابی";break;
	default : echo "";break;
	}
}

 

//////////////////////////////////////////////////////////////////////////////



function checkmemtype($input)
{
	switch($input)
	{
	case 0 : echo "همه";break;
	case 1 : echo "اعضاء";break;
	default : echo "";break;
	}
}

 

//////////////////////////////////////////////////////////////////////////////



function checktype($input)
{
	switch($input)
	{
	case 0 : echo "اصلی";break;
	case 1 : echo "فرعی";break;
	default : echo "نامشخص";break;
	}
}

 

//////////////////////////////////////////////////////////////////////////////



function checkexamtype($input)
{
	switch($input)
	{
	case 1 : echo "تصادفی";break;
	case 2 : echo "انتخابی";break;
	default : echo "نامشخص";break;
	}
}

 

//////////////////////////////////////////////////////////////////////////////



function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

 

//////////////////////////////////////////////////////////////////////////////



function sepratenumber($str)
{
	$str=round($str,0);
	if(substr($str , 0,1)=='-')
	{
		$str=abs($str);
		$number .="-";
	}
	
	$cc=strlen($str)%3;
	
	if($cc==2)
		$cc+=2;
	elseif($cc==1)
		$cc++;
	
	
	for($i=0;$i<strlen($str);$i++)
	{
		$cc++;
		$number .= substr($str , $i,1);
		if($str<0 and $i<3 and $cc%3==0)
		$cc--;
		if($cc%3==0 and $i<strlen($str)-1)
		$number .= ",";
	}
	
	return $number;
}

 

//////////////////////////////////////////////////////////////////////////////



function getConvertOneItem($cn,$slct,$tbl,$cond)
{
	mysqli_select_db($cn,$database_cn);
	$query_rsgci = sprintf("SELECT ".$slct." FROM ".$tbl." ".$cond);
	$rsgci = mysqli_query($cn,$query_rsgci) or die(mysqli_error($cn));
	$row_rsgci = mysqli_fetch_assoc($rsgci);
	$totalRows_rsgci = mysqli_num_rows($rsgci);

	if($totalRows_rsgci>0)
		$ret=$row_rsgci[$slct];
	else
		$ret='';

	return $ret;
}

 

//////////////////////////////////////////////////////////////////////////////



function getConvertseconds($seconds)
{
	$s = $seconds % 60;
	// add leading zero to seconds if needed
	$s = $s < 10 ? "0" + $s : $s;
	
	// calculate minutes
	$m = floor($seconds / 60) % 60;
	// add leading zero to minutes if needed
	$m = $m < 10 ? "0" + $m : $m;
	
	// calculate hours
	$h = floor($seconds / 60 / 60);
	
	
	$time = '';
	
	if($h>0) 
	  $time .= $h . " ساعت " ; 

	if($m>0) {
	  if($time) $time.=' و ';
	  $time .= $m . " دقیقه " ; 
	}
	
	if($s>0) {
	  if($time) $time.=' و ';
	  $time .= $s . " ثانیه " ; 
	}
	
	return $time;
}

 

//////////////////////////////////////////////////////////////////////////////



function newscatname($levelcode)
{
	if($levelcode>0) {
		$query_rscheckp = "SELECT name FROM category WHERE code='".GetSQLValueString($levelcode, "text")."'";
		$rscheckp = mysqli_query($query_rscheckp) or die("invalid parametr!");
		$row_rscheckp = mysqli_fetch_assoc($rscheckp); 
	}
	else {
		return 'گروه اصلی';
	}
	
	return $row_rscheckp['cname'];
}


?>