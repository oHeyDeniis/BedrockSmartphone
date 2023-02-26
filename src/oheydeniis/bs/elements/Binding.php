<?php

namespace oheydeniis\bs\elements;

use oheydeniis\bs\texture\ServerFormManager;

class Binding
{

    const BINDING_TYPE_GLOBAL = "global";
    const BINDING_TYPE_VIEW = "view";
    const BINDING_TYPE_COLLECTION = "collection";
    const BINDING_TYPE_COLLECTION_DETAILS = "collection_details";
    const BINDING_TYPE_NONE = "none";

    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Use this function to generate a binding with conditional rendering
     * @param string|null $bindingID id of the $bindingName contains to enable a view
     * @param string|null $bindingName
     * @param bool|null $useCustomUiID
     * @return void
     */
    public function setConditionalBinding(?string $bindingID, ?string $bindingName = "#title_text", ?bool $useCustomUiID = true){
        $this->setBindingType(self::BINDING_TYPE_VIEW);
        $id = $bindingID;
        if($useCustomUiID){
            $id = ServerFormManager::BEDROCK_CUSTOM_UI_ID."@".$bindingID;
        }
        $this->setSourcePropertyName("(not (({$bindingName} - '{$id}') = {$bindingName})");
        $this->setBindingTargetPropertyName("#visible");
    }
    public function setBindingType(string $type) : self
    {
        $this->data["binding_type"] = $type;
        return $this;
    }
    public function setBindingName(string $value) : self{
        $this->data["binding_name"] = $value;
        return $this;
    }
    public function setBindingNameOverride(string $value) : self{
        $this->data["binding_name_override"] = $value;
        return $this;
    }
    public function setBindingCollectionName(string $value) : self{
        $this->data["binding_collection_name"] = $value;
        return $this;
    }
    public function setBindingCollectionPrefix(string $value) : self{
        $this->data["binding_collection_prefix"] = $value;
        return $this;
    }
    public function setBindingCondition(string $value) : self{
        $this->data["binding_condition"] = $value;
        return $this;
    }
    public function setSourceControlName(string $value) : self{
        $this->data["source_control_name"] = $value;
        return $this;
    }
    public function setSourcePropertyName(string $value) : self{
        $this->data["source_property_name"] = $value;
        return $this;
    }
    public function setBindingTargetPropertyName(string $value) : self{
        $this->data["target_property_name"] = $value;
        return $this;
    }
    public function setResolveSiblingScope(bool $value) : self{
        $this->data["resolve_sibling_scope"] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}