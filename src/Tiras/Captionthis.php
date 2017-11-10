<?php

namespace Tiras;

/**
 * Description of Hagar
 *
 * @author everton
 */
class Captionthis extends Tiras{
    
    public function setName(){
        $this->name = 'captionthis';
    }
    
    public function generateData(){
        $inicio = new \DateTime('2016-12-23');
        $hoje = new \DateTime();
        $diff = $inicio->diff($hoje);
        $this->data = (12330 + $diff->days);
    }
    
    public function generateUrl(){
        $this->url = 'http://www.captionthis.org/image.php?pic_id='.$this->data;
    }
    
    public function get(){
        return $this->url;
    }
    
    public function process($html){
        return $html;
    }
}
