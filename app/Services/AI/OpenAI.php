<?php
namespace App\Services\AI;

use App\Services\AI\AIBase;

class OpenAI extends AIBase {   

    public function getApiKey() {
       return ['api_key' => config('services.ai_api_key.openai')];
    }  

}

?>
