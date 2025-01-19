<?php

date_default_timezone_set('Asia/tashkent');

trait FunctionsAPI {

    public function fetchSite($url, $region){
        $month_num = date('n');
        // $month_num = 2;
        $link = "$url/vaqtlar/$region/$month_num";
        $result =  file_get_contents($link);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($result);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);
        return $xpath;
    }
    
    public function getListRegions($url, $region = 1, $type){
        $xpath = $this->fetchSite($url, $region);
        $regions = $xpath->query('//select[@name="region"]/option');
        $list_regions = [];
        foreach($regions as $key => $value){
            $name = $regions->item($key)->nodeValue;
            $num = $regions->item($key)->getAttribute('value');
            if($type == "name"){
                $list_regions[$name] = $num;
            }elseif($type == "num"){
                $list_regions[$num] = $name; 
            }else{
                $list_regions = [
                    "success" => false,
                    "message" => "2 xil type bor. ID yoki nomlari",
                    "types" => [
                        "1" => "num",
                        "2" => "name"
                    ]
                ];
            }
        }
        return json_encode($list_regions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function getRegionName($url, $region){
        $xpath = $this->fetchSite($url, $region);
        $select = $xpath->query('//select[@name="region"]/option');
        foreach($select as $key => $value){
            $value = $select->item($key)->getAttribute('value');
            if($value == $region){
                $name = $select->item($key)->textContent;
            }
        }
        return $name;
    }

    public function day($url, $region, $day){
        $xpath = $this->fetchSite($url, $region);
        $select = $xpath->query("//tbody/tr");
        $count = count($select);
        if($day > $count || $day <= 0){
            $return = [
                "success" => false,
                "message" => "Noto'g'ri kun kiritdingiz"
            ];
            return json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
        $result = $select->item($day - 1)->nodeValue;
        $array = explode(" ", $result);
        foreach($array as $key => $value){
            if(empty($array[$key])){
                unset($array[$key]);
            }else{
                $temp = $array[$key];
                $temp = trim($temp);
                $array[$key] = $temp;
            }
        }
        $region_name = $this->getRegionName($url, $region);
        $times = [
            "xijriy" => $array[28],
            "milodiy" => $array[60],
            "hafta_kuni" => $array[116],
            "bomdod" => $array[144],
            "quyosh" => $array[172],
            "peshin" => $array[200],
            "asr" => $array[228],
            "shom" => $array[256],
            "xufton" => $array[284]
        ];

        $return = [
            "success" => true,
            "hudud" => $region_name,
            "id" => $region,
            "vaqtlar" => $times
        ];

        return json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function Week($url, $region){
        $xpath = $this->fetchSite($url, $region);
        $select = $xpath->query('//tbody/tr');
        $select2 = $xpath->query('//select[@name="region"]/option');
        $count = count($select);
        $this_day = date('j');
        if($this_day <= $count - 6){
            $in = $this_day;
        }else{
            $k = $count - $this_day;
            $q = 6 - $k;
            $in = $this_day - $q;
        }
        foreach($select2 as $key => $value){
            $value = $select2->item($key)->getAttribute('value');
            if($value == $region){
                $name = $select2->item($key)->textContent;
            }
        }
        $get_week_list = [
            "success" => true,
            "hudud" => $name,
            "id" => $region
        ];
        for($i = $in; $i <= $in + 6; $i++){
            $data = $select->item($i - 1)->nodeValue;
            $array = explode(" ", $data);
            foreach($array as $key => $value){
                if(empty($array[$key])){
                    unset($array[$key]);
                }else{
                    $temp = $array[$key];
                    $temp = trim($temp);
                    $array[$key] = $temp;
                }
            }
            $get_week_list["vaqtlar"][$array[116]] = [
                "hijriy" => $array[28],
                "milodiy" => $array[60],
                "hafta_kuni" => $array[116],
                "bomdod" => $array[144],
                "quyosh" => $array[172],
                "peshin" => $array[200],
                "asr" => $array[228],
                "shom" => $array[256],
                "xufton" => $array[284]
            ];
        }
        return json_encode($get_week_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function month($url, $region){
        $xpath = $this->fetchSite($url, $region);
        $select = $xpath->query("//tbody/tr");
        $count = count($select);
        $region_select = $xpath->query('//select[@name="region"]/option');
        foreach($region_select as $key => $value){
            $num = $region_select->item($key)->getAttribute('value');
            if($num == $region){
                $name = $region_select->item($key)->nodeValue;
            }
        }
        $month_list = [
            "success" => true,
            "region" => $name,
            "id" => $region
        ];
        for($i = 1; $i <= $count; $i++){
            $data = $select->item($i - 1)->nodeValue;
            $array = explode(" ", $data);
            foreach($array as $key => $value){
                if(empty($array[$key])){
                    unset($array[$key]);
                }else{
                    $temp = $array[$key];
                    $temp = trim($temp);
                    $array[$key] = $temp;
                }
            }
            $month_list["vaqtlar"][$array[60]] = [
                "hijriy" => $array[28],
                "milodiy" => $array[60],
                "hafta_kuni" => $array[116],
                "bomdod" => $array[144],
                "quyosh" => $array[172],
                "peshin" => $array[200],
                "asr" => $array[228],
                "shom" => $array[256],
                "xufton" => $array[284]
            ];
        }
        return json_encode($month_list , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // return $count;
    }
}

?>