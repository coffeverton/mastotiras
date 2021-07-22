<?php
namespace Tiras;
class Garfield extends Tiras{
    public $date_format = 'Y/m/d';
    public function setName(){
        $this->name = 'garfield';
    }
    
    public function generateData(){
    	$this->data = date($this->date_format);
    }
    
    public function generateUrl(){
        $this->url = 'https://www.gocomics.com/garfield/'.$this->data;
    }

    public function process($html){
        preg_match_all('/og:image.*/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/https:.*\"/", $tmp, $src);
        $img = $src[0];
        $img = str_replace('"', '', $img);
        return $img;
    }
}