<?php
require('api/crs/api.php');
header('Content-type: application/json');
if(isset($_GET['reboot'])){
    $API = new API(1);
    $reboot = $_GET['reboot'];
    if($reboot){
        $json = $API->getRegionList('name');
        file_put_contents("api/db/regions.json", $json);
    }
}

if(isset($_GET['region'])){
    $region = $_GET['region'];
    $API = new API($region);
    $json = file_get_contents('api/db/regions.json');
    $jsonArray = json_decode($json, true);
    if(in_array($region, $jsonArray)){
        $API = new API($region);
        $json = $API->getMonth();
        $json = json_decode($json, true);
        $json['update_at'] = (new DateTime())->format('Y-m-d H:i');
        var_dump($json['update_at']);
        $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents("api/db/$region.json", $json);
    }else{
        print('Nomalum id kiritdingiz');
    }
}

if(isset($_GET['getRegion'])){
    $API = new API(1);
    $json = file_get_contents('api/db/regions.json');
    print($json);
}

if(isset($_GET['getTimes'])){
    $region = $_GET['getTimes'];
    $path = "api/db/$region.json";
    if(file_exists($path)){
        $json = file_get_contents("api/db/$region.json");
        print($json);
    }else{
        $json = file_get_contents('api/db/regions.json');
        $jsonArray = json_decode($json, true);
        if(in_array($region, $jsonArray)){
            $API = new API($region);
            $json = $API->getMonth();
            $json = json_decode($json, true);
            $json['update_at'] = (new DateTime())->format('Y-m-d H:i');
            $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            print($json);
            file_put_contents("api/db/$region.json", $json);
        }else{
            print('Nomalum id kiritdingiz');
        } 
    }
}
?>