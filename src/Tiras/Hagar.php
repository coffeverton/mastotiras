<?php

namespace Tiras;

/**
 * Description of Hagar
 *
 * @author everton
 */
class Hagar extends Tiras{
    
    public function setName(){
        $this->name = 'hagar';
    }
    
    public function generateData(){
        $this->data = date('F-d-Y');
    }
    
    public function generateUrl(){
        $this->url = 'http://hagarthehorrible.com/comics/'.$this->data;
    }
    
    public function process($html){
        preg_match_all('/.*screenResUri".*/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/screenResUri\" value=\"[a-zA-Z0-9:\/\.?=]{0,}/", $tmp, $output_array);
        $img = str_replace('screenResUri" value="', '', $output_array[0]);        
        return $img;
    }
}
