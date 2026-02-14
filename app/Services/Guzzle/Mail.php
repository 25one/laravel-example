<?php
namespace App\Services\Guzzle;

use App\Services\Guzzle\GuzzleBase;

class Mail extends GuzzleBase {

    public $emailTo;
    public $message;

    /*
    public function getHeaders() {
      return ['headers' => 
          [
          //'Authorization' => 'api_token ' . $this->api_token, //???
          'Content-Type' => 'application/json',
          ]
      ];	
    }
    */  

    public function getMethod() {
      return 'GET';
    }

     public function getUrl() {
       return 'http://api.25one.com.ua/api_mail.php';
     }

     public function getParams() {
      return [
        'query' => [
          'email_to' => $this->emailTo,
          'title' => 'Message from https://pilot.25one.com.ua - ' . date('d-m-Y H:i:s'),
          'message' => $this->message,
         ]
       ];
     }

}

?>
