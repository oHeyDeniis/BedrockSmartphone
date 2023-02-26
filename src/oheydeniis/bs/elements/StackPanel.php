<?php

namespace oheydeniis\bs\elements;

class StackPanel extends Panel
{


    public function __construct(array $data = [])
    {
        $data["type"] = self::ELEMENT_TYPE_STACK_PANEL;
        parent::__construct($data);
    }
    public function setOrientation(string $orientation){
        $this->data["orientation"] = $orientation;
    }
}