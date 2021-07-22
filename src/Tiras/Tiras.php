<?php
namespace Tiras;
abstract class Tiras {

    public $name;
    public $data;
    public $url;
    public $img;
    public $url_base;
    public $date_format;
    
    public function __construct($data = null) {
        $this->setName();
        if($data === null)
        {
            $this->generateData();
        } else {
            $this->parseData($data);
        }
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
    
    public function parseData($str_data){
    	$data = new \DateTime($str_data);
    	$this->data = $data->format($this->date_format);
    }
        
    public function salvar()
    {
        if(strlen($this->img) < 3) {
            return false;
        }
        $comando = COMMAND_BASE." '{$this->name} {$this->data} - {$this->url}' '{$this->img}' 'comics_{$this->name}' ";
        echo $comando."\r\n";
        shell_exec($comando);
    }
}