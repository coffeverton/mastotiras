<?php
namespace Tiras;
abstract class Tiras {

    public $name;
    public $data;
    public $url;
    public $img;
    public $save_folder;
    public $img_local;
    public $url_base;
    
    public function __construct() {
        $this->setName();
        $this->generateData();
        $this->generateUrl();
        $this->generateUrlBase();
        $this->save_folder = "arquivos/{$this->name}/{$this->data}";
        $html = $this->get();
        $this->img = $this->process($html);
        $this->saveImg();
        $this->sendMail();
    }
    
    abstract public function setName();
    
    abstract public function generateData();
        
    abstract public function generateUrl();

    abstract public function process($html);
    
    public function generateUrlBase(){
        $arr = explode('/',$_SERVER['REQUEST_URI']);
        array_pop($arr);
        $this->url_base = "{$_SERVER['REQUEST_SCHEME']}://"
        . "{$_SERVER['SERVER_NAME']}"
        . implode('/', $arr);
    }
    
    public function get(){
        $html = file_get_contents($this->url);
        return $html;
    }
    
    public function saveImg(){
        @mkdir($this->save_folder, 0777, true);
        $this->img_local = $this->save_folder.'/'.uniqid(); 
        file_put_contents($this->img_local, file_get_contents($this->img));
    }
    
    public function sendMail(){
        require_once 'config.php';
//        require 'vendor/autoload.php';
        
        $mail = new \PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = SMTP_USERNAME;                 // SMTP username
        $mail->Password = SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = SMTP_PROTOCOL;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = SMTP_PORT;                                    // TCP port to connect to

        $mail->setFrom(SMTP_USERNAME, 'Tirinhas Diarias');
        $mail->addAddress(SMTP_USERNAME, 'Tirinhas Diarias');

//        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = "Tirinhas {$this->name} - {$this->data}";
        $mail->Body    = "<img src='{$this->url_base}/{$this->img_local}'>";
        $mail->AltBody = 'Tirinha diaria';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo $mail->Subject." has been sent\r\n";
        }
    }
}