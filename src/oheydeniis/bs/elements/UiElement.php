<?php

namespace oheydeniis\bs\elements;

abstract class UiElement implements UiTypes
{



    protected array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    protected function validate() : bool{
        return isset($this->data["type"]);
    }
    public function setEnabled(bool $value) : self{
        $this->data["enabled"] = $value;
        return $this;
    }
    public function setVisible(bool $value) : self{
        $this->data["visible"] = $value;
        return $this;
    }
    public function setSize(int|string $x, int|string $y) : self{
        $this->data["size"] = [$x, $y];
        return $this;
    }

    public function setAnchors(string $from, string $to) : self{
        $this->setAnchorFrom($from);
        $this->setAnchorTo($to);
        return $this;
    }
    public function setAnchorTo(string $value) : self{
        $this->data["anchor_from"] = $value;
        return $this;
    }
    public function setAnchorFrom(string $value) : self{
        $this->data["anchor_from"] = $value;
        return $this;
    }
    public function setOffset(int $x, int $y) : self{
        $this->data["offset"] = [$x, $y];
        return $this;
    }
    public function setVariable(string $name, ?string $defaultValue = null) : self{
        $this->data['$'.$name.'|default'] = $defaultValue;
        return $this;
    }
    public function setCustomValue($key, $value) : self{
        $this->data[$key] = $value;
        return $this;
    }
    public function addElement(string $name, UiElement $element) : self{
        $this->data["controls"][][$name] = $element->getData();
        return $this;
    }
    public function addBinding(Binding $binding) : self{
        $this->data["bindings"][] = $binding->getData();
        return $this;
    }

    public function set() : self{
        $this->data[""] = "";
        return $this;
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}