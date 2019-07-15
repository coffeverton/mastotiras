<?php
namespace Tiras;
class Dilbert extends Tiras{
	public $date_format = 'Y-m-d';
    public function setName(){
        $this->name = 'dilbert';
    }
    
    public function generateData(){
    	$this->data = date($this->date_format);
    }
    
    public function generateUrl(){
        $this->url = 'https://dilbert.com/strip/'.$this->data;
    }
    
    public function process($html){
        preg_match_all('/.* img-comic".*/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/src=\".*\"/", $tmp, $output_array);
        $img = str_replace('src=','', $output_array[0]);
        $img = str_replace('"','', $img);
        $img = str_replace("'",'', $img);
        $img = 'https'.$img;
        
        return $img;
    }
}
