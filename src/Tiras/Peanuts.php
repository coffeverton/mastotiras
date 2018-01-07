<?php
namespace Tiras;
class Peanuts extends Tiras{
	public $date_format = 'Y/m/d';
    public function setName(){
        $this->name = 'peanuts';
    }
    
    public function generateData(){
    	$this->data = date($this->date_format);
    }
    
    public function generateUrl(){
        $this->url = 'http://www.gocomics.com/peanuts/'.$this->data;
    }
    
    public function process($html){
        preg_match_all('/og:image.*/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/http:.*\"/", $tmp, $src);
        $img = $src[0];
        $img = str_replace('"', '', $img);
        return $img;
    }
}
