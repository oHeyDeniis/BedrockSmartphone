<?php

namespace oheydeniis\bs\texture\data;

use oheydeniis\bs\texture\ServerFormManager;

class BindingCustomData
{

    private array $content;
    private ?string $bindingID;
    private ?string $bindingName;
    private ?bool $useCustomUiID;


    public function __construct(array $content, ?string $bindingID, ?string $bindingName = "#title_text", ?bool $useCustomUiID = true)
    {

        $this->content = $content;
        $this->bindingID = $bindingID;
        $this->bindingName = $bindingName;
        $this->useCustomUiID = $useCustomUiID;
    }
    public function getFormattedContent() : array{

            $this->content["bindings"][] = [
                "binding_name" => $this->bindingName
            ];
            $id = $this->bindingID;
            if($this->useCustomUiID){
                $id = ServerFormManager::BEDROCK_CUSTOM_UI_ID."@".$this->bindingID;
            }
            $this->content["bindings"][] = [
                "binding_type" =>"view",
                "source_property_name" => "(not (({$this->bindingName} - '{$id}') = {$this->bindingName})",
                "target_property_name" => "#visible"
            ];

        return $this->content;
    }

}