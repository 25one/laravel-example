<?php
namespace App\Services\AI;

use App\Services\AI\AIBase;

class OpenAI extends AIBase {   

    private $apiKey; 

    public function __construct($api_key = null)
    {
        $this->apiKey = $api_key;
    }    

    public function getApiKey() {
       //return ["api_key" => config('services.ai_api_key.openai')]; 
       
       return ["api_key" => $this->apiKey];
    }  

}

?>
