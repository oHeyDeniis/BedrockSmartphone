<?php

namespace oheydeniis\bs\elements;

class Text extends UiElement
{
    public function __construct(array $data = [])
    {
        $data["type"] = self::ELEMENT_TYPE_TEXT;
        parent::__construct($data);
    }
    public function setText(string $text){
        $this->data["text"] = $text;
    }
    public function setColor(float $r, float $g, float $b) : self{
        $this->data["color"] = [$r, $g, $b];
        return $this;
    }
    public function setColorWhenDisabled(float $r, float $g, float $b) : self{
        $this->data["locked_color"] = [$r, $g, $b];
        return $this;
    }
    public function setShadow(bool $value) : self{
        $this->data["shadow"] = $value;
        return $this;
    }
    public function setFontSize(int $size) : self{
        $this->data["font_size"] = $size;
        return $this;
    }
    public function setFontType(string $type) : self{
        $this->data["font_type"] = $type;
        return $this;
    }
    public function setTextAlignment(string $alignment) : self{
        $this->data["text_alignment"] = $alignment;
        return $this;
    }

}