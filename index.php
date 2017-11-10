<?php
$loader = require 'vendor/autoload.php';

$calvin         = new \Tiras\Calvin();
$dilbert        = new \Tiras\Dilbert();
$hagar          = new \Tiras\Hagar();
$captionthis    = new \Tiras\Captionthis();



$inicio = new DateTime('2017-10-30');
$fim = new DateTime('2017-11-09');

while($inicio < $fim)
{
	$data 			= $inicio->format('Y-m-d');
	$calvin         = new \Tiras\Calvin($data);
	$dilbert        = new \Tiras\Dilbert($data);
	$hagar          = new \Tiras\Hagar($data);
	
	$inicio->add(new DateInterval('P1D'));
}
