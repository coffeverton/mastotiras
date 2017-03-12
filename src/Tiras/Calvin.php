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
        preg_match_all('/og:image/', $html, $arr);
        $tmp = $arr[0][0];
        preg_match("/http:.*\"/", $tmp, $src);
        $img = $src[0];
        $img = str_replace('"', '', $img);
        echo $img."\r\n";
        return $img;
    }
}
