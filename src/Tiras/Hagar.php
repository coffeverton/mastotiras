<?php

namespace Tiras;

/**
 * Description of Hagar
 *
 * @author everton
 */
class Hagar extends Tiras{
	public $date_format = 'Y-m-d';
    public function setName(){
        $this->name = 'hagar';
    }
    
    public function generateData(){
    	$this->data = date($this->date_format);
    }
    
    public function generateUrl(){
        $this->url = 'https://www.comicskingdom.com/hagar-the-horrible/'.$this->data;
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
