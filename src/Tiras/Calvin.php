<?php
namespace Tiras;
class Calvin extends Tiras{
    
    public function setName(){
        $this->name = 'calvin';
    }
    
    public function generateData(){
        $this->data = date('Y/m/d');
    }
    
    public function generateUrl(){
        $this->url = 'http://www.gocomics.com/calvinandhobbes/'.$this->data;
    }
    
    public function process($html){
        preg_match_all('/.*"strip".*/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/src=\".*\"/", $tmp, $output_array);
        preg_match("/http:\/\/[a-z0-9\.\/]{0,}/", $output_array[0], $src);
        $img = $src[0];
        return $img;
    }
}
