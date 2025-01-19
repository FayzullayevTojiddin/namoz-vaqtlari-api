<?php
require('functions.php');

class API {
    private $url;
    private $region;

    use FunctionsAPI;

    public function __construct($region)
    {
        $this->url = "https://islom.uz";
        $this->region = $region;
    }

    public function getRegionList($type){
        return $this->getListRegions($this->url, $this->region, $type);
    }

    public function getDay($day){
        return $this->day($this->url, $this->region, $day);
    }

    public function getWeek(){
        return $this->Week($this->url, $this->region);
    }

    public function getMonth(){
        return $this->month($this->url, $this->region);
    }

}
?>