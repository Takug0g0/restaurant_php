#restaurants_searcher.php

<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

# 初期設定
$KEYID = "e89843b5808187b5";
$HIT_PER_PAGE = 100;
$PREF = "Z011";
$FREEWORD = "渋谷駅";
$FORMAT = "json";

$PARAMS = ["key"=> $KEYID, "count"=>$HIT_PER_PAGE, "large_area"=>$PREF, "keyword"=>$FREEWORD, "format"=>$FORMAT];


function write_data_to_csv($params){
    
    $restaurants =[["名称","営業日","住所","アクセス"]];
    $client= new Client();
    try{
        $json_res =$client->request('GET',"http://webservice.recruit.co.jp/hotpepper/gourmet/v1/",['query'=>$params])->getBody();
    }catch(Exception $e){
        return print("エラーが発生しました。APIのURLを確認してください。");
    }
    $response =json_decode($json_res,true);

    if(isset($response["results"]["error"])){
        return(print("エラーが発生しました。APIのパラメータをご確認ください。"));
    }
    foreach($response["results"]["shop"] as $restaurant){
        $rest_info = [$restaurant["name"],$restaurant["open"],$restaurant["address"],$restaurant["access"]];
        $restaurants[] = $rest_info;
    }
    $handle=fopen("restrants_list.csv","wb");
        forEach($restaurants as $values){
    fputcsv($handle, $values);
        
    }
    
    fclose($handle);
    return print_r($restaurants);
}

write_data_to_csv($PARAMS);

?>