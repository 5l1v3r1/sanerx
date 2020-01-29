<?php
ini_set('memory_limit', '-1');
set_time_limit(0);
header('Content-Type: text/plain; charset=utf-8');
include 'config/config.php';



function getCsrf(){
    $file =  curl_get_file_contents_with_proxy("https://www.instagram.com/data/shared_data/");

    return json_decode($file)->config->csrf_token;

}



function in_string($needle, $haystack, $insensitive = false) { 
    if ($insensitive) { 
        return false !== stristr($haystack, $needle); 
    } else { 
        return false !== strpos($haystack, $needle); 
    } 
} 

function parseString($first, $end, $data){
    @preg_match_all('/' . preg_quote($first, '/') .
        '(.*?)'. preg_quote($end, '/').'/i', $data, $m);
    return $m[1];
}

function generateUUID($keepDashes = true){
    $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 4095) | 16384, mt_rand(0, 16383) | 32768, mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    return $keepDashes ? $uuid : str_replace('-', '', $uuid);
}


function generateU($str, $options = [])
    {
        #$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = [
            'delimiter' => '',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        ];
        $options = array_merge($defaults, $options);
        $char_map = [
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        ];
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        $str = substr($str, 0, ($options['limit'] ? $options['limit'] : strlen($str)));
        $str = trim($str, $options['delimiter']);
        #$characters = ['_', '.', ''];
        $characters = ['',rand(0, 9),rand(0, 99)];
        $randomCharacter = ( count($characters) > 0 ) ? $characters[rand(0, (count($characters) - 1))] : NULL;
        $characters2 = ["_", "", rand(0, 999999) . "_", rand(0, 999) . "y"];
        $randomFirstCharacter = ( count($characters2) > 0 ) ? $characters2[rand(0, (count($characters2) - 1))] : NULL;
        #$firt_or_end = ['first', 'end'];
        $firt_or_end = ['end'];
        $select = ( count($firt_or_end) > 0 ) ? $firt_or_end[rand(0, (count($firt_or_end) - 1))] : NULL;
        if ($select == 'first')
            $str =  $randomFirstCharacter . $str . $randomCharacter. rand(0, 999);
        else
            $str =  $str . $randomCharacter . rand(0, 999);

        return $options['lowercase'] ? strtolower($str) : $str;
    }





$username = isset($_REQUEST["username"]) ? mb_trim($_REQUEST["username"]) : false;
$password = isset($_REQUEST["password"]) ? mb_trim($_REQUEST["password"]) : false;
$token = isset($_REQUEST["token"]) ? mb_trim($_REQUEST["token"]) : false;



if($username && $password && $token){
    $i = new InstagramRegister($username,$password,$token);
}


class InstagramRegister {

    protected $access_token;
    protected $user_agent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3578.98 Safari/537.36";
    protected $user_agent_mobile = "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1";
    protected $csrf_token;
    protected $user;
    protected $status = true;
    protected $proxy = false;
    protected $proxyList = array();


    // Starting...
    function __construct($email,$password,$token)
    {
        if (isset($email) && isset($password))
        {
            $this->email = $email;
            $this->password = $password;
            $this->createTestAccount($email,$password,$token);
            return true;
        } else {
            throw new Exception('Error: __construct() - Sadece yazı(string) ifadeler belirtmek zorundasınız.');
        }
    }





    public function sign_creator($data)
    {
        $sig = "";
        foreach($data as $key => $value){
            $sig .= "$key=$value";
        }
        $sig .= "62f8ce9f74b12f84c123cc23437a4a32";
        $sig = md5($sig);
        $data['sig'] = $sig;
        return $data;
    }

    // upload instagram accounts
    public function createTestAccount($username,$password,$token) {
            
                        $data = array(
                            "api_key" => "882a8490361da98702bf97a021ddc14d",
                            "credentials_type" => "password",
                            "email" => $username,
                            "format" => "JSON",
                            "generate_machine_id" => "1",
                            "generate_session_cookies" => "1",
                            "locale" => "en_US",
                            "method" => "auth.login",
                            "password" => $password,
                            "return_ssl_resources" => "0",
                            "v" => "1.0"
                        );


                        $data = $this->sign_creator($data);
                        $params = [
                            'url'           => "https://api.facebook.com/restserver.php?".http_build_query($data)
                        ];
                        $response = $this->cURL($params);
                        $rJson = json_decode($response);
                        $access_token = isset($rJson->access_token) ? $rJson->access_token : NULL;
                        $uid = isset($rJson->uid) ? $rJson->uid : NULL;
                        $cookie = is_null($access_token) ? NULL : json_encode($rJson->session_cookies);

                        $add = DB::insert("INSERT INTO `sub_fb_cookie` (`main_uid`,`uid`,`username`,`password`,`access_token`,`cookie`,`app_token`) VALUES (?,?,?,?,?,?,?)",[
                            0,
                            $uid,
                            $username,
                            $password,
                            $access_token,
                            $cookie,
                            $token
                        ]);
                        if($add){
                            echo "Eklendi".PHP_EOL;
                        }else {
                            echo "Problem";
                        }
    }



   protected function parseString($first, $end, $data){
        @preg_match_all('/' . preg_quote($first, '/') .
            '(.*?)'. preg_quote($end, '/').'/i', $data, $m);
        return $m[1];
    }

    // General curl func.
    protected function cURL($params)
    {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $params['url'],
            CURLOPT_HEADER => FALSE,
            CURLOPT_ENCODING => "gzip, deflate",
            CURLOPT_FOLLOWLOCATION => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 15
        ];
        if (!empty($params['proxy']))
        {
            $options[CURLOPT_PROXY] = $params['proxy'];
            $options[CURLOPT_PROXYTYPE] = 'HTTP';
        }
        if (!empty($params['interface']))
        {
            $options[CURLOPT_INTERFACE] = $params['interface'];
        }
        if ( is_array(@$params['options']) )
        {
            foreach($params['options'] as $option => $value) {
                $options[$option] = $value;
            }
        }
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        //return json_encode($options);
        return $response;
    }

    protected function cURLValue($filename)
    {
        $image = getimagesize($filename);
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $image['mime'], $filename);
        }
        // Use the old style if using an older version of PHP
        $value = "@{$filename};filename=" . $filename;
        if ($image['mime']) {
            $value .= ';type=' . $image['mime'];
        }
        return $value;
    }
}



