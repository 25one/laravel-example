<?php
namespace App\Services;

use App\Services\GuzzleBase;

class Pilot extends GuzzleBase {

    public $api_token;
	public $type;
	public $token;
	public $prompt;

	public function getHeaders() {
		return ['headers' => 
		    [
			   //'Authorization' => 'api_token ' . $this->api_token, //???
			   'Content-Type' => 'application/json',
		    ]
		];	
	}

	public function getMethod() {
		return 'POST';
	}

	public function getUrl() {
       return 'http://192.168.33.10:8080/api/prompt-execute?api_token=' . $this->api_token;
	}

	public function getParams() {
		return ['body' => json_encode(
				  [
					'type' => $this->type,
					'token' => $this->token,
					'prompt' => $this->prompt,
				  ]
		       )];
	}

}

?>
