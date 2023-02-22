<?php

namespace oheydeniis\bs\texture;

use pocketmine\utils\Config;

class CustomUI
{

    private string $name;
    private array $content;

    /**
     * @param string $name id of the CustomUI
     * @param array $content json element with main object
     * you can load json file using loadFrom()
     */
    public function __construct(string $name, array $content = [])
    {

        $this->name = $name;
        $this->content = $content;
    }

    public function verify() : void{
        if(!isset($this->content["namespace"])){
            throw new \InvalidArgumentException("'namespace' field is required to custom ui '{$this->name}'");
        }
        if(!isset($this->content["main"])){
            throw new \InvalidArgumentException("'main' field is required to custom ui '{$this->name}'");
        }
    }
    /**
     * Carregar codigo JSON de um arquivo especifico já criado
     * @param string $filePath
     * @return void
     */
    public function loadFrom(string $filePath){
        $json = new Config($filePath, Config::JSON);
        $data = $json->getAll();
        $this->content = $data;
        $this->verify();
    }

    public function getContent() : array{
        $this->verify();
        return $this->content;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getNameId() : string{
        return $this->getName()."@".$this->getName().".main";
    }
    public function getFileName() : string{
        return $this->getName().".json";
    }
    public static function generateDefaultContent() : array{
        return [
            "visible" => false,
            "test" => false,
            "bindings" => []
        ];
    }
}