<?php
namespace Tiras;
class Garfield extends Tiras{
	public $date_format = 'Y-m-d';
    public function setName(){
        $this->name = 'garfield';
    }
    
    public function generateData(){
    	$this->data = date($this->date_format);
    }
    
    public function generateUrl(){
        $this->url = 'https://d1ejxu6vysztl5.cloudfront.net/comics/garfield/'.date('Y/').$this->data.'.gif';
    }

    public function get(){
        return $this->url;
    }

    public function process($html){
        return $html;
    }
}

//https://d1ejxu6vysztl5.cloudfront.net/comics/garfield/2018/2018-01-06.gif