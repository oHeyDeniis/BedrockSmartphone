<?php

namespace oheydeniis\bs\elements;

class Image extends UiElement
{

    public function __construct(array $data = [])
    {
        $data["type"] = self::ELEMENT_TYPE_IMAGE;
        parent::__construct($data);
    }
    public function setImagePath(string $path) : self{
        $this->data["texture"] = $path;
        return $this;
    }

    /**
     * @param string $url
     * @return void
     */
    public function setImageByUrl(string $url){
        //todo: for new version//
    }
    public function setBaseSize(int $x, int $z) : self{
        $this->data["base_size"] = [$x, $z];
        return $this;
    }
    public function setClipDirection(string $direction) : self{
        $this->data["clip_direction"] = $direction;
        return $this;
    }
    public function setUV(int $x, int $z) : self{
        $this->data["uv"] = [$x, $z];
        return $this;
    }
    public function setUVSize(int $x, int $z) : self{
        $this->data["uv_size"] = [$x, $z];
        return $this;
    }
}