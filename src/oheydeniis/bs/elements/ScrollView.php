<?php

namespace oheydeniis\bs\elements;

class ScrollView extends InputUiElement
{

    public function __construct(array $data = [])
    {
        $data["type"] = self::ELEMENT_TYPE_SCROLL_VIEW;
        parent::__construct($data);
    }

    /**
     * @param string $ui name of ui where the element is existing
     * @param string $elementName element that control the content
     * @return $this
     */
    public function setScrollController(string $ui, string $elementName) : self{
        $this->data["scroll_content"] = "$ui.$elementName";
        return $this;
    }
    public function setScrollSpeed(float $speed) : self{
        $this->data["scroll_speed"] = $speed;
        return $this;
    }


}