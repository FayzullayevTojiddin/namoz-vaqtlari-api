<?php
require('api.php');

if(isset($_GET['region'])){
    $input_region = $_GET['region'];
    $API = new API($input_region);
    $list_regions_json_name = $API->getRegionList("name");
    $list_regions = json_decode($list_regions_json_name, true);    
    if(in_array($input_region, $list_regions)){
        $region = $input_region;
        if(isset($_GET['method'])){
            if($_GET['method'] == "day"){
                if(isset($_GET['day'])){
                    print($API->getDay($_GET['day']));
                }else{
                    $return = [
                        "succes" => false,
                        "message" => "Kunni kiriting, day parametrida"
                    ];
                    print(json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                }
            }elseif($_GET['method'] == "week"){
                print($API->getWeek());
            }elseif($_GET['method'] == "month"){
                print($API->getMonth());
            }else{
                $return = [
                    "success" => false,
                    "message" => "Noto'g'ri method"
                ];
                print(json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }  
        else{
            $return = [
                "succes" => false,
                "message" => "Metod kiriting",
                "methods" => [
                    "1" => "day",
                    "2" => "week",
                    "3" => "month",
                ]
            ];
            print(json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }else{
        $list_regions = [
            "succes" => false,
            "message" => "Mavjud bo'lmagan region IDsini kiritdingiz",
            "regions" => $list_regions
        ];
        $list_regions = json_encode($list_regions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        print($list_regions);
    }
}
elseif(isset($_GET['listRegion'])){
    $API = new API(1);
    print($API->getRegionList($_GET['listRegion']));
} 
else{
    $return = [
        "success" => false,
        "message" => "APIdan foydalanishning metodlari api.fayzullaev.uz da"
    ];
    print(json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

?>