<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('application/libraries/Twilio/autoload.php');
use Twilio\Rest\Client;

class Send_sms extends CI_Model {
	
	public function send($phones,$msg){
		
		//$sid = 'AC24767d645c70789b874167de28217f5b';
		//$token = 'b95880f5c088a90d42779456a0a7615d'; 
		
		$sid = 'AC6c0648f046d876aafb06bbd2c7cea06e';
		$token = '4917643a6ab5c16424fbfe1e9e22d57e'; 
		
		$client = new Client($sid, $token);
		
		$status = true;
		//echo $phones;
		$encoded = rawurlencode("$phones");
		
		try {
			$run = $client->messages->create(
				$phones,
				array(
					'from' => '+18124387190',
					//'from' => '+15136571633',
					'body' => $msg
				)
			);
    } catch (Twilio\Exceptions\RestException $e) {
			//echo '<pre>'; print_r($phones); echo '</pre>';
			//echo '<pre>'; print_r($e); echo '</pre>';
			$status = false;
			
    }
		
		return $status;
	}
	
}