<?php
namespace Tiras;
abstract class Tiras {

    public $name;
    public $data;
    public $url;
    public $img;
    public $url_base;
    
    public function __construct() {
        $this->setName();
        $this->generateData();
        $this->generateUrl();
        $html = $this->get();
        $this->img = $this->process($html);
        $this->salvar();
    }
    
    abstract public function setName();
    
    abstract public function generateData();
        
    abstract public function generateUrl();

    abstract public function process($html);
     
    public function get(){
        $html = file_get_contents($this->url);
        return $html;
    }
        
    public function salvar()
    {
        $comando = "php /home/everton/vhosts/site/bin/console tiras:importar {$this->name} {$this->data} {$this->img}";
        shell_exec($comando);
    }
}