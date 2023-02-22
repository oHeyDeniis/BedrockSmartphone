<?php

namespace oheydeniis\bs\texture;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class UiDefsManager
{

    use SingletonTrait;

    private Config $file;
    private array $content;

    public function __construct(string $filePath)
    {
        self::setInstance($this);
        $this->file = new Config($filePath, Config::JSON);
        $this->content = $this->file->getAll();
    }
    public function addCustomUI(CustomUI $ui){
        $this->content["ui_defs"][] = 'ui'.DIRECTORY_SEPARATOR.'custom/'.$ui->getFileName();
        $this->save();
    }
    public function save(){
        $this->file->setAll($this->content);
        $this->file->save();
        $this->file->reload();
    }
}