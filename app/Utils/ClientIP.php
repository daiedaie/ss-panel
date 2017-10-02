<?php


namespace App\Utils;


class ClientIP
{
    /**
     * @param $ip
     * @param int $time
     * @return int
     */
    public static function getIpRegCount($ip, $time = 3600 * 24)
    {
        return User::where('reg_ip', $ip)->where('reg_date', '>', Tools::toDateTime(time() - $time))->count();
    }



//<script type="text/javascript" src="http://www.google.com/jsapi?key=YOURKEY"></script>
//<script type="text/javascript">
//function geoTest() {
//    if (google.loader.ClientLocation) {
//        var latitude = google.loader.ClientLocation.latitude;
//        var longitude = google.loader.ClientLocation.longitude;
//        var city = google.loader.ClientLocation.address.city;
//        var country = google.loader.ClientLocation.address.country;
//        var country_code = google.loader.ClientLocation.address.country_code;
//        var region = google.loader.ClientLocation.address.region;
//        var text = 'Your Location<br /><br />Latitude: ' + latitude + '<br />Longitude: ' + longitude + '<br />City: ' + city + '<br />Country: ' + country + '<br />Country Code: ' + country_code + '<br />Region: ' + region;
//    } else {
//        var text = 'Google was not able to detect your location';
//    }
//    document.write(text);
//}
//geoTest();
//</script>




/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
private static function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;                                                                                                                                                                              
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
} 
/*
 * http://blackbe.lt/advanced-method-to-obtain-the-client-ip-in-php/
*/
public static function getClientAddress() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}


private static function getrealip() {
  if (isset($_SERVER)){
    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
      $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
      if(strpos($ip,",")){
        $exp_ip = explode(",",$ip);
        $ip = $exp_ip[0];
      }
    } else if(isset($_SERVER["HTTP_CLIENT_IP"])){
      $ip = $_SERVER["HTTP_CLIENT_IP"];
    }else{
      $ip = $_SERVER["REMOTE_ADDR"];
    }
  }else{
    if(getenv('HTTP_X_FORWARDED_FOR')){
      $ip = getenv('HTTP_X_FORWARDED_FOR');
      if(strpos($ip,",")){
        $exp_ip=explode(",",$ip);
        $ip = $exp_ip[0];
      }
    }else if(getenv('HTTP_CLIENT_IP')){
      $ip = getenv('HTTP_CLIENT_IP');
    }else {
      $ip = getenv('REMOTE_ADDR');
    }
  }
  return $ip; 
}


public static function getIpDetail($ip) {
//  $realip = get_ip_address();
//  $realip2 = getrealip();
  // 
  // $connomains = array(
  // "http://yar999.tk/ip.php",
  // "http://ip111cn.appspot.com"
  // );
  // 
  // $mh = curl_multi_init();
  // 
  // foreach ($connomains as $i => $url) {
  //   $conn[$i]=curl_init($url);
  //   curl_setopt($conn[$i],CURLOPT_RETURNTRANSFER,1);
  //   curl_multi_add_handle ($mh,$conn[$i]);
  // }
  // 
  // do {
  //  $mrc = curl_multi_exec($mh,$active);
  // } while ($mrc == CURLM_CALL_MULTI_PERFORM);
  // 
  // while ($active and $mrc == CURLM_OK) {
  //   if (curl_multi_select($mh) != -1) {
  //     do {
  //       $mrc = curl_multi_exec($mh, $active);
  //     } while ($mrc == CURLM_CALL_MULTI_PERFORM);
  //   }
  // }
  // 
  // foreach ($connomains as $i => $url) {
  //       $ip[$i]=curl_multi_getcontent($conn[$i]);
  //       curl_close($conn[$i]);
  // }
  
  $detail = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
  
  return $detail ;
  
  
//  $origin       = isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'';
//  $allowOrigin  = [
//                      'https://www.google.com',
//                      'https://www.google.is',
//                      'https://www.google.ca',
//                      'https://www.facebook.com'
//                  ];
//  if (in_array($origin, $allowOrigin)) {
//      header('Access-Control-Allow-Origin: ' . $origin);
//  }
}   
  
}
  
  


