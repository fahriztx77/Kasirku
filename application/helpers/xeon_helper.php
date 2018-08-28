<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

function time_before($timestamp)
{
    $selisih = time() - strtotime($timestamp) ;

    $detik = $selisih ;
    $menit = round($selisih / 60 );
    $jam = round($selisih / 3600 );
    $hari = round($selisih / 86400 );
    $minggu = round($selisih / 604800 );
    $bulan = round($selisih / 2419200 );

    if ($detik <= 60) {
        $waktu = $detik.'//detik';
    } else if ($menit <= 60) {
        $waktu = $menit.'//menit';
    } else if ($jam <= 24) {
        $waktu = $jam.'//jam';
    } else if ($hari <= 7) {
        $waktu = $hari.'//hari';
    } else if ($minggu <= 4) {
        $waktu = $minggu.'//minggu';
    } else if ($bulan <= 12) {
        //$waktu = $bulan.' bulan yang lalu ';
    	$waktu = tgl_indo($timestamp);
    } 
    return $waktu;
}

if(!function_exists("utf8ize")){
	function utf8ize($d) {
	    if (is_array($d)) {
	        foreach ($d as $k => $v) {
	            $d[$k] = utf8ize($v);
	        }
	    } else if (is_string ($d)) {
	        return utf8_encode($d);
	    }
	    return $d;
	}
}

function encrypt($string){
	$data = '1$2793'.md5(base64_encode(md5($string)));
	return $data;
}

function torp($price){
	$total = strlen($price);
	switch ($total) {
		case '6':
			$a3 = substr($price,0,3);
			$b3 = substr($price,3);
			$h	= $a3.".".$b3;
			break;
		
		case '7':
			$a3 = substr($price,0,1);
			$b3 = substr($price,1,3);
			$c3 = substr($price,4,3);
			$h	= $a3.".".$b3.".".$c3;
			break;

		case '8':
			$a3 = substr($price,0,2);
			$b3 = substr($price,2,3);
			$c3 = substr($price,5,3);
			$h	= $a3.".".$b3.".".$c3;
			break;

		case '9':
			$a3 = substr($price,0,3);
			$b3 = substr($price,3,3);
			$c3 = substr($price,6,3);
			$h	= $a3.".".$b3.".".$c3;
			break;
	}
	return $h;
}

function dateResource($type){
	switch ($type) {
		case 'day':
			$data 	= [
							[
								'key' 	=> '1',
								'value'	=> 'Senin',
							],
							[
								'key' 	=> '2',
								'value'	=> 'Selasa',
							],
							[
								'key' 	=> '3',
								'value'	=> 'Rabu',
							],
							[
								'key' 	=> '4',
								'value'	=> 'Kamis',
							],
							[
								'key' 	=> '5',
								'value'	=> 'Jumat',
							],
							[
								'key' 	=> '6',
								'value'	=> 'Sabtu',
							],
							[
								'key' 	=> '7',
								'value'	=> 'Minggu',
							],
					   ];
			return json_decode(json_encode($data));
			break;
		case 'month':
			$data 	= [
							[
								'key' 	=> '1',
								'value'	=> 'Januari',
							],
							[
								'key' 	=> '2',
								'value'	=> 'Februari',
							],
							[
								'key' 	=> '3',
								'value'	=> 'Maret',
							],
							[
								'key' 	=> '4',
								'value'	=> 'April',
							],
							[
								'key' 	=> '5',
								'value'	=> 'Mei',
							],
							[
								'key' 	=> '6',
								'value'	=> 'Juni',
							],
							[
								'key' 	=> '7',
								'value'	=> 'July',
							],
							[
								'key' 	=> '8',
								'value'	=> 'Augustus',
							],
							[
								'key' 	=> '9',
								'value'	=> 'September',
							],
							[
								'key' 	=> '10',
								'value'	=> 'Oktober',
							],
							[
								'key' 	=> '11',
								'value'	=> 'November',
							],
							[
								'key' 	=> '12',
								'value'	=> 'Desember',
							],
					   ];
			return json_decode(json_encode($data));
			break;
		default:
			return false;
			break;
	}
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }

    return $token;
}

function getInvoice($length)
{
    $invoice = "";
    $code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $code.= "0123456789";
    $max = strlen($code);

    for ($i=0; $i < $length; $i++) {
        $invoice .= $code[crypto_rand_secure(0, $max)];
    }

    return $invoice;
}

function getSubdomain(){
	return array_shift((explode(".",$_SERVER['HTTP_HOST'])));
}

function urlRedirect($url){
	echo '<script>window.location.href="'.$url.'"</script>';
	return;
}


if ( ! function_exists('read_more'))
{
	/**
	 * Site URL
	 *
	 * Create a local URL based on your basepath. Segments can be passed via the
	 * first parameter either as a string or an array.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function read_more($string,$limit=100)
	{
		$string = trim(preg_replace('/\s+/', ' ', $string));
		$string = trim(preg_replace('/\t+/', '', $string));
		$string = str_replace('&nbsp;','',$string);
		$length = strlen(strip_tags($string));
		if ($length>$limit){
			return substr(strip_tags($string),0,$limit).' ... ';
		}
		else {
			return strip_tags($string);
		}
	}
}

if ( ! function_exists('gRecaptcha'))
{

	function gRecaptcha($type=null)
	{

		if($type=="show"){
			$show = '<div class="g-recaptcha" data-sitekey="'.getenv('GOOGLE_RECAPTCHA_SITE').'"></div>';
			return $show;
		}
		$secret = getenv('GOOGLE_RECAPTCHA_SECRET');
	    $gRecaptcha = $_POST['g-recaptcha-response'];
	    $gRecaptcha = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response'];
	    $response = file_get_contents($gRecaptcha);
	    $responseData = json_decode($response);

	    if(!isset($_POST['g-recaptcha-response'])){
	    	return false;
	    }


	    if($responseData->success){
	        return true;
	    }else{
	        return false;
	    }
	}
}

if (! function_exists('showApiKey')){
	function showApiKey(){
		$key = getenv('API_KEY');

		return DefuseLib::encrypt($key);
	}
}




if (! function_exists('goResult')){

	function goResult($def,$msg){
    	$data['auth'] 	= $def;
			$data['msg'] 	= $msg;
			return toJson($data);
    }
}

if ( ! function_exists('youtube_preview'))
{
	
	function youtube_preview($url)
	{
		//https://www.youtube.com/watch?v=3p4MZJsexEs
		//https://img.youtube.com/vi/3p4MZJsexEs/mqdefault.jpg
		$bodytag = str_replace("https://www.youtube.com/watch?v=", "https://img.youtube.com/vi/", $url);
		return $bodytag.'/mqdefault.jpg';
	}
}

if ( ! function_exists('youtube_iframe'))
{
	function youtube_iframe($url)
	{
		$bodytag = str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $url);
		return $bodytag.'?rel=0&amp;controls=0&amp;showinfo=0';
	}
}



if ( ! function_exists('find_replace'))
{
	/**
	 * Site URL
	 *
	 * Create a local URL based on your basepath. Segments can be passed via the
	 * first parameter either as a string or an array.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function find_replace($string,$find)
	{
		$bodytag = str_replace($find, "<b><u>".$find."</u></b>", strtolower($string));
		return $bodytag;
	}
}

if ( ! function_exists('toJson'))
{
	function toJson($var) {
	    header('Content-Type: application/json');
	    return json_encode($var);
	}
}


if ( ! function_exists('goExplode'))
{
	function goExplode($string,$delimiter="-",$result=0) {
	    $var 	= explode($delimiter, $string);
	    if($result==0){
	    	return $var[0];
	    }

	    if(!isset($var[$result])){
	    	return;
	    }

	    return $var[$result];
	}
}



if ( ! function_exists('seo'))
{
	function seo($s) {
	    $c = array (' ');
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
	    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
	    $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	    return $s;
		}
}

if ( ! function_exists('match'))
{
	function match($val,$val2,$return,$return_2=null){

		if($return_2==null){
			if ($val==$val2){
				return $return;
			}	
		}
		else {
			if ($val==$val2){
				return $return;
			}else{
				return $return_2;
			}		
		}
		
	}
}

if ( ! function_exists('daysLeft'))
{
	function daysLeft($date,$day){
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = Date('Y-m-d');
		$now 	= new DateTime($tanggal);
		$date 	= new DateTime($date);
		$result = $now->diff($date);

		return (($day - $result->days)<=0) ? 0 : $day - $result->days ;
	}
}

if ( ! function_exists('dateLeft') ) {

	function dateLeft($date){
		$tanggal 	= Date('Y-m-d');
		$date1 		= new DateTime($tanggal);
		$date2 		= new DateTime($date);
		if($date2<$date1){
			return 0;
		}
		$diff 		= $date1->diff($date2);
		return $diff->days;
	}
}


if ( ! function_exists('zero'))
{
	function zero($data,$url){
		if(count($data)<=0){
			redirect($url);
			exit;
		}
	}
}


if ( ! function_exists('remFile'))
{
	function remFile($path){
		if(file_exists($path)){
			if(unlink($path)){
				return true;	
			}
			return false;
		}

		return false;
	}
}



if (!function_exists('img_holder')){
	function img_holder($type=null){
		switch ($type) {
			case 'food':
				return '/images/placeholder/food.png';
				break;
			case 'profile':
			    return '/images/placeholder/avatar.png';
				break;
			case 'women':
			    return '/images/placeholder/women.png';
			break;
			case 'long-ads':
			    return '/images/placeholder/long-ads.png';
			break;
			case 'box-ads':
			    return '/images/placeholder/box-ads.png';
			break;
			case 'camera':
			    return '/images/placeholder/camera.jpg';
			break;
			case 'video':
			    return '/images/placeholder/video.jpg';
			break;
			case 'flat':
			    return '/images/placeholder/flat.jpg';
			break;
			case 'folder':
			    return '/images/placeholder/folder.png';
			break;
			default:
				return '/images/placeholder/basic.png';
				# code...
				break;
		}
	}
}


if (!function_exists('notif_type')){
	function notif_type($data,$type=null){

		switch ($data) {
			case 'restaurant':
				$hasil 		= ($type==null) ? '<span class="label label-danger  label-icon"><i class="fa fa-cutlery"></i></span>' : '<span class="label label-danger  label-icon"><i class="fa fa-cutlery"></i></span>';
				break;
			case 'users':
			    $hasil 		= ($type==null) ? '<span class="label label-primary  label-icon"><i class="fa fa-users"></i></span>' : '<span class="label label-primary  label-icon"><i class="fa fa-users"></i></span>';
				break;
			case 'preorder':
			    $hasil 		= ($type==null) ? '<span class="label label-success  label-icon"><i class="fa fa-truck"></i></span>' : '<span class="label label-success  label-icon"><i class="fa fa-truck"></i></span>';
				break;
			case 'promo':
			    $hasil 		= ($type==null) ? '<span class="label label-warning  label-icon"><i class="fa fa-gift"></i></span>' : '<span class="label label-warning  label-icon"><i class="fa fa-gift"></i></span>';
				break;
			case 'review':
			    $hasil 		= ($type==null) ? '<span class="label label-info  label-icon"><i class="fa fa-newspaper-o"></i></span>' : '<span class="label label-info  label-icon"><i class="fa fa-newspaper-o"></i></span>';
				break;
			case 'message':
			    $hasil 		= ($type==null) ? '<span class="label bg-purple  label-icon"><i class="fa fa-envelope-o"></i></span>' : '<span class="label bg-inverse  label-icon"><i class="fa fa-envelope-o"></i></span>';
				break;
			default:
				$hasil 		= ($type==null) ? '<span class="label label-default  label-icon"><i class="fa fa-question"></i></span>' : '<span class="label label-default  label-icon"><i class="fa fa-question"></i></span>';
				# code...
				break;
		}

		return $hasil;
	}
}

if ( ! function_exists('toTime'))
{
	function toTime($date){
		$time=strtotime($date);
		return date("H:i A",$time);
	}
}

// ------------------------------------------------------------------------
if (!function_exists('tgl_indo')){
	function tgl_indo($tgl){
     	$tanggal = substr($tgl,8,2);
     	switch (substr($tgl,5,2)){
					case '01': 
						$bulan= "Januari";
						break;
					case '02':
						$bulan= "Februari";
						break;
					case '03':
						$bulan= "Maret";
						break;
					case '04':
						$bulan= "April";
						break;
					case '05':
						$bulan= "Mei";
						break;
					case '06':
						$bulan= "Juni";
						break;
					case '07':
						$bulan= "Juli";
						break;
					case '08':
						$bulan= "Agustus";
						break;
					case '09':
						$bulan= "September";
						break;
					case '10':
						$bulan= "Oktober";
						break;
					case '11':
						$bulan= "November";
						break;
					case '12':
						$bulan= "Desember";
						break;
				}

		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
     }
}

if (!function_exists('tgltobulan_indo')){
	function goObject($var){
		return json_decode(json_encode($var));
	}
}

if (!function_exists('tgltobulan_indo')){
	function tgltobulan_indo($tgl){
		if($tgl==null){
			return false;
		}
     	$tanggal = substr($tgl,8,2);
     	switch (substr($tgl,5,2)){
					case '01': 
						$bulan= "Januari";
						break;
					case '02':
						$bulan= "Februari";
						break;
					case '03':
						$bulan= "Maret";
						break;
					case '04':
						$bulan= "April";
						break;
					case '05':
						$bulan= "Mei";
						break;
					case '06':
						$bulan= "Juni";
						break;
					case '07':
						$bulan= "Juli";
						break;
					case '08':
						$bulan= "Agustus";
						break;
					case '09':
						$bulan= "September";
						break;
					case '10':
						$bulan= "Oktober";
						break;
					case '11':
						$bulan= "November";
						break;
					case '12':
						$bulan= "Desember";
						break;
				}

		$tahun = substr($tgl,0,4);
		return $bulan.' '.$tahun;
     }
}

if (!function_exists('bln_indo')){
	function bln_indo($bln){
     	switch ($bln){
			case '1': 
				$bulan= "Januari";
				break;
			case '2':
				$bulan= "Februari";
				break;
			case '3':
				$bulan= "Maret";
				break;
			case '4':
				$bulan= "April";
				break;
			case '5':
				$bulan= "Mei";
				break;
			case '6':
				$bulan= "Juni";
				break;
			case '7':
				$bulan= "Juli";
				break;
			case '8':
				$bulan= "Agustus";
				break;
			case '9':
				$bulan= "September";
				break;
			case '10':
				$bulan= "Oktober";
				break;
			case '11':
				$bulan= "November";
				break;
			case '12':
				$bulan= "Desember";
				break;
		}
		return $bulan;
     }
}

if (!function_exists('dateRange')){
	function dateRange($strDateFrom,$strDateTo)
	{
	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}
}

if (!function_exists('matchArray')){
	function matchArray($array,$value,$rule=false,$response='hidden')
	{
		if($rule==false){
			if(!in_array($value, $array)){
				return $response;
			}
			return;
		}
		else {
			if(in_array($value, $array)){
				return $response;
			}
			return;
		}
	    
	}
}

if (!function_exists('mineAccess')){
	function mineAccess($array,$value)
	{
		if(in_array('all', $array)){
			return;
		}

		if(!in_array($value, $array)){
			return 'hidden';
		}
	}
}

if (!function_exists('courier_name')){
	function courier_name($code)
	{	
		$code 			= strtoupper($code);
		switch ($code) {
			case 'JNE':
				return '(JNE) Jalur Nugraha Ekakurir';
				break;
			case 'POS':
				return '(POS) POS Indonesia';
				break;
			case 'TIKI':
				return '(TIKI) Citra Van Titipan Kilat';
				break;
			case 'PCP':
				return '(PCP) Priority Cargo and Package';
				break;
			case 'ESL':
				return '(ESL) Eka Sari Lorena';
				break;
			case 'RPX':
				return '(RPX) RPX Holding';
				break;
			case 'PANDU':
				return '(PANDU) Pandu Logistics';
				break;
			case 'WAHANA':
				return '(WAHANA) Wahana Prestasi Logistik';
				break;
			case 'SICEPAT':
				return '(SICEPAT) SiCepat Express';
				break;
			case 'J&T':
				return '(J&T) J&T Express';
				break;
			case 'PAHALA':
				return '(PAHALA) Pahala Kencana Express';
				break;
			case 'CAHAYA':
				return '(CAHAYA) Cahaya Logistik';
				break;
			case 'SAP':
				return '(SAP) SAP Express';
				break;
			case 'JET':
				return '(JET) JET Express';
				break;
			case 'INDAH':
				return '(INDAH) Indah Logistic';
				break;
			case 'SLIS':
				return '(SLIS) Solusi Ekspres';
				break;
			case 'DSE':
				return '(DSE) 21 Express';
				break;
			default:
				return 'Uknown Courier';
				break;
		}
	}
}


