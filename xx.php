<?php
function get_total_millisecond()
{
    $time = explode (" ", microtime () );
    $time = $time [1] . ($time [0] * 1000);
    $time2 = explode ( ".", $time );
    $time = $time2 [0];
    return $time;
}
$count = 10;
if (is_array($_GET) && count($_GET) > 0) {
    if(isset($_GET["count"])){
        $count=intval($_GET["count"]);
    }
}
$url='https://free-ss.site/ss.json?_='.get_total_millisecond();
$ch = curl_init();
$timeout = 5; 
curl_setopt ($ch, CURLOPT_URL, 'http://www.ccvita.com');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$lines_string = curl_exec($ch);
curl_close($ch);
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
