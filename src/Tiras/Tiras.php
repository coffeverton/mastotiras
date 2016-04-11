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
    public $db;
    
    public function __construct() {
        $this->initDb();
        $this->setName();
        $this->generateData();
        if(!$this->validateData())
        {
            return;
        }
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
    
    public function exists()
    {
        $query = "SELECT COUNT(*) AS existentes FROM Tiras WHERE data = '{$this->data}' AND origem = '{$this->name}'";
        $stm = $this->db->query($query);
        $result = $stm->fetchAll();
        $itens = $result[0];
        return $itens->existentes != 0;
    }
    
    public function initDb()
    {
        @mkdir('db', 0777);
        $this->db = new \PDO(
                'sqlite:db/tiras.db'
                ,''
                ,''
                ,array(
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                )
        );
        $query = "CREATE TABLE IF NOT EXISTS Tiras (id INTEGER PRIMARY KEY AUTOINCREMENT, data CHAR(10), origem VARCHAR(255))";
        try{
            $this->db->exec($query);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die;
        }
    }
    
    public function updateDb()
    {
        $query = "INSERT INTO Tiras (data, origem) VALUES ('{$this->data}', '{$this->name}');";
        $this->db->exec($query);
    }
    
    public function validateData()
    {
        if($this->exists() === true)
        {
            return false;
        } else {
            $this->updateDb();
        }
    }
    
    public function sendMail(){
        return ;
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