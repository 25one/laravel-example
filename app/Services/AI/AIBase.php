<?php
namespace App\Services\AI;

abstract class AIBase {

    public $variantAI;
    public $variantModel;
    public $prompt;

    public function getVariantAI() {
       return ['variantAI' => $this->variantAI];
    }    

    public function getVariantModel() {
       return ['variantModel' => $this->variantModel];
    } 

	abstract function getApiKey();

    public function getPrompt() {
       return ['prompt' => $this->prompt];
    }	

	public function funcGet() {
        $arrPython = array_merge($this->getVariantAI(), $this->getVariantModel(), $this->getApiKey(), $this->getPrompt());

		$commandPython = escapeshellcmd('python3 ' . base_path() . '/app/python/prompt.py ') . "'". json_encode($arrPython) . "'";
	
		return shell_exec($commandPython);	
	}

}

?>
