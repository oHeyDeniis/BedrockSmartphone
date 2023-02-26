<?php

namespace oheydeniis\bs\elements;

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
    public function setNamespace(string $namespace) : self{
        $this->content["namespace"] = $namespace;
        return $this;
    }

    /**
     * Add yours elements like: Panel, Buttons, Images
     * REMEMBER: LongForm and CustomForm custom ui did use name of "main" element to render the first custom ui
     * @param string $name
     * @param UiElement $element
     * @return void
     */
    public function addUiElement(string $name, UiElement $element){
        $this->content[$name] = $element->getData();
    }
    public function verify() : void{
        if(!isset($this->content["namespace"])){
            throw new \InvalidArgumentException("'namespace' field is required to custom ui '{$this->name}'");
        }
       /** if(!isset($this->content["main"])){
            throw new \InvalidArgumentException("'main' field is required to custom ui '{$this->name}'");
        }*/
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
            "bindings" => []
        ];
    }
}