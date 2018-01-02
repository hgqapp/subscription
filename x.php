<?php
function get_total_millisecond()
{
    $time = explode (" ", microtime () );
    $time = $time [1] . ($time [0] * 1000);
    $time2 = explode ( ".", $time );
    $time = $time2 [0];
    return $time;
}

function doCurlPostRequest($url, $data = [], $header = [], $timeout = 5){
 if($url == '' || $timeout <=0){
   return false;
 }
 $curl = curl_init((string)$url);
 curl_setopt($curl, CURLOPT_HEADER, false);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
 curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
 curl_setopt($curl, CURLOPT_POST,true);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
 curl_setopt($curl, CURLOPT_TIMEOUT,(int)$timeout);
 curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //添加自定义的http header
 return curl_exec($curl);
}

$count = 10;
if (is_array($_GET) && count($_GET) > 0) {
    if(isset($_GET["count"])){
        $count=intval($_GET["count"]);
    }
}
$url='https://ss.rohankdd.com/ss.php?_='.get_total_millisecond();

$ch = curl_init();

$data = array();

$header[] = "X-Client-ID:7e43c50781295f35";
$header[] = "X-Access-Token:4dc049e83308fe6c66ee08a1833577f90298bcec3dca66cc1d202";

$lines_string = doCurlPostRequest($url, $data, $header);

echo "请求结果：";
echo $lines_string;

$data = (array)json_decode($lines_string);
$groupName = str_replace('=','',base64_encode("动态节点"));
$index = 0;
foreach ($data['data'] as $item){
    if($index >= $count){
        break;
    }
    if ($item[0] == 100) {
        $ssr = "ssr://".str_replace('/','_',str_replace('=','',base64_encode($item[1].":".$item[2].":origin:".$item[4].":plain:".str_replace('=','',base64_encode($item[3]))."/?obfsparam=&remarks=".str_replace('=','',base64_encode($item[6]."_".$item[5]))."&group=".$groupName)));
        echo $ssr;
        echo '<br>';
        $index++;
    }
}
