<?php
namespace App\Services\Guzzle;

abstract class GuzzleBase {

    //abstract function getHeaders();

    abstract function getMethod();

	abstract function getUrl();

	abstract function getParams();

	public function funcGet() {
	    //$client = new \GuzzleHttp\Client($this->getHeaders());
		$client = new \GuzzleHttp\Client();
	    $response = $client->request($this->getMethod(), $this->getUrl(), $this->getParams());

	    return $response->getBody()->getContents();
	}

}

?>
