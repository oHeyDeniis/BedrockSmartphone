<?php

namespace oheydeniis\bs\texture\data;

use oheydeniis\bs\texture\CustomUI;
use oheydeniis\bs\texture\TextureManager;
use oheydeniis\bs\texture\UiDefsManager;

class DataUtils
{

    private array $content;


    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function addUI(CustomUI $ui){

        $binding = new BindingCustomData($ui::generateDefaultContent(), $ui->getName());

        $this->content["controls"][][$ui->getNameId()] = $binding->getFormattedContent();

        UiDefsManager::getInstance()->addCustomUI($ui);
        TextureManager::getInstance()->createCustomUI($ui);
    }
    /**
     * @return ControlCustomData[]
     */
    public function getControls() : array{
        return $this->content["controls"];
    }
    public function addControls(string $name, ControlCustomData $control) : void{
        $this->content["controls"][$name] = $control->getformatedContent();
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }
}