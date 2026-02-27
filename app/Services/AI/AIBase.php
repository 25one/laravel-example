<?php
namespace App\Services\AI;

abstract class AIBase {

    public $variantAI;
    public $variantModel;
    public $prompt;

    public function getVariantAI() {
       return ["variantAI" => $this->variantAI];
    }    

    public function getVariantModel() {
       return ["variantModel" => $this->variantModel];
    } 

	abstract function getApiKey();

    public function getPrompt() {
       return ["prompt" => $this->prompt];
    }	

	public function funcGet() {
         $arrPython = array_merge($this->getVariantAI(), $this->getVariantModel(), $this->getApiKey(), $this->getPrompt());

         $commandPython = escapeshellcmd('python3 ' . base_path() . '/app/python/prompt.py ') . escapeshellarg(json_encode($arrPython));

         $result = shell_exec($commandPython);

         if (is_object(json_decode($result)) && property_exists(json_decode($result), 'errorPython')) {
             $result = response()->json([ //!для js-catch
                'message' => $result,
                'errors' => '500 Internal Server Error'
             ], 500);

             return $result;
         } else {
            $user = auth()->user();

            if ($user && ! count($user->keysActive) && $user->demo_count) {
               $user->demo_count = $user->demo_count - 1;
               $user->save();               
            }

            return $result;
         }  
	}

}

?>
