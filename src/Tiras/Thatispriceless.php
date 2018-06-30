<?php
namespace Tiras;
class Thatispriceless extends Tiras{
	public $date_format = 'Y/m/d';
    public function setName(){
        $this->name = 'thatispriceless';
    }
    
    public function generateData(){
    	$this->data = date($this->date_format);
    }
    
    public function generateUrl(){
        $this->url = 'http://www.gocomics.com/that-is-priceless/'.$this->data;
    }
    
    public function process($html){
        preg_match_all('/gc-card__image gc-card__image--cropped-strip lazyload__padder lazyload__padder--card.*/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/src=\"https:.*\"/", $tmp, $src);
        $img = $src[0];
        $img = str_replace('src="', '', $img);
        $img = str_replace('"', '', $img);
        return $img;
    }
}
