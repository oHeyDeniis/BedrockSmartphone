<?php

namespace oheydeniis\bs\elements;

class Panel extends UiElement
{

    public function __construct(array $data = [])
    {
        $data["type"] = self::ELEMENT_TYPE_PANEL;
        parent::__construct($data);
    }
}