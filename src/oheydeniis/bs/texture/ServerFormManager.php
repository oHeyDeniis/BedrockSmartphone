<?php

namespace oheydeniis\bs\texture;

use oheydeniis\bs\texture\data\CustomFormData;
use oheydeniis\bs\texture\data\LongFormData;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class ServerFormManager
{
    use SingletonTrait;

    /**
     * Identificador padrão para separar a ui padrão e a ui CUSTOM
     * @var string
     */
    const BEDROCK_CUSTOM_UI_ID = "BedrockCustomUI:";


    public Config $file;
    public array $defaultContent;
    public array $content;

    public LongFormData $longFormData;
    public CustomFormData $customFormData;

    public function __construct(string $filePath)
    {
        self::setInstance($this);
        $this->file = new Config($filePath, Config::JSON);
        $this->defaultContent = $this->file->getAll();
        $this->content = $this->file->getAll();
        $this->verify();
        $this->load();
    }
    public function load() : void{
        $this->longFormData = new LongFormData($this->content["long_form"]);
        $this->customFormData = new CustomFormData($this->content["custom_form"]);
    }
    public function save(){

        $this->content["long_form"] = $this->longFormData->getContent();
        //$this->content["custom_form"] = $this->customFormData->getContent();
        $this->file->setAll($this->content);
        $this->file->save();
        $this->file->reload();
    }
    public function verify() : void{
        if(!isset($this->content["namespace"])){
            throw new \InvalidArgumentException("namespace of server_form.json is undefined");
        }
        if($this->content["namespace"] != "server_form"){
            throw new \InvalidArgumentException("namespace of server_form.json not is server_form");
        }
        if(!isset($this->content["long_form"])){
            throw new \InvalidArgumentException("Not is defined 'long_form' in server_form");
        }
    }

    /**
     * @return LongFormData
     */
    public function getLongFormData(): LongFormData
    {
        return $this->longFormData;
    }

    /**
     * @param LongFormData $longFormData
     */
    public function setLongFormData(LongFormData $longFormData): void
    {
        $this->longFormData = $longFormData;
    }
}