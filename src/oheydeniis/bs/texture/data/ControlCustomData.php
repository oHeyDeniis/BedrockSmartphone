<?php

namespace oheydeniis\bs\texture\data;

use oheydeniis\bs\texture\ServerFormManager;

class ControlCustomData
{


    private array $content;
    private ?string $bindingID;
    private ?string $bindingName;
    private ?bool $useSmartphoneID;

    public function __construct(array $content, ?string $bindingID, ?string $bindingName = "#title_text", ?bool $useSmartphoneID = true)
    {

        $this->content = $content;
        $this->bindingID = $bindingID;
        $this->bindingName = $bindingName;
        $this->useSmartphoneID = $useSmartphoneID;
    }
    public function getformatedContent() : array{
        $base = $this->content;
        if(count($this->content["bindings"]) == 0){
            $this->content["bindings"][] = [
                "binding_name" => $this->bindingName
            ];
            $id = $this->bindingID;
            if($this->useSmartphoneID){
                $id = ServerFormManager::BEDROCK_SMARTPHONE_ID."@".$this->bindingID;
            }
            $this->content["bindings"][] = [
                "binding_type" =>"view",
                "source_property_name" => "(not (({$this->bindingName} - '{$id}') = {$this->bindingName})",
                "target_property_name" => "#visible"
            ];
        }
        return $base;
    }
    public static function generateDefaultContent() : array{
        return [
            "visible" => false,
            "bindings" => []
        ];
    }
}