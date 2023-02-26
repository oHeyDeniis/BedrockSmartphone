<?php

namespace oheydeniis\bs\elements;

class Button extends InputUiElement
{

    //todo: add mappings
    public function __construct(array $data = [])
    {
        $data["type"] = self::ELEMENT_TYPE_BUTTON;
        parent::__construct($data);
    }
    public function setText(string $text){
        $this->data["text"] = $text;
    }
    public function setDefaultControl(string $control) : self{
        $this->data["default_control"] = $control;
        return $this;
    }
    public function setHoverControl(string $control) : self{
        $this->data["hover_control"] = $control;
        return $this;
    }
    public function setPressedControl(string $control) : self{
        $this->data["pressed_control"] = $control;
        return $this;
    }
    public function setLockedControl(string $control) : self{
        $this->data["locked_control"] = $control;
        return $this;
    }
}