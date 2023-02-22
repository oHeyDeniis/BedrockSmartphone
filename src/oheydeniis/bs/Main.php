<?php

namespace oheydeniis\bs;

use oheydeniis\bs\form\LongForm;
use oheydeniis\bs\texture\CustomUI;
use oheydeniis\bs\texture\data\LongFormData;
use oheydeniis\bs\texture\ServerFormManager;
use oheydeniis\bs\texture\TextureManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{

    private TextureManager $textureManager;



    protected function onEnable(): void
    {
        $this->textureManager = new TextureManager($this);
        $customUI = new CustomUI("test");
        $customUI->loadFrom($this->getDataFolder()."test.json");
        $this->getTextureManager()->getServerFormManager()->getLongFormData()->addUI($customUI);
        $this->getTextureManager()->getServerFormManager()->save();
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if(isset($args[0])){
            switch ($args[0]){
                case "txt":
                    TextureManager::getInstance()->build();
                    return true;
            }
        }
        $form = new LongForm("sla");
        $form->setFormId($args[0] ?? "notID");
        $form->setTitle("sla");
        $form->setFormDescription("aaaaa");
        $form->addButton("aaaa", "textures/items/apple", function (Player $player){
            $player->sendMessage("passou");
        });
        $form->addSimpleButton("slas", "id");
        $form->setCallable(function (Player $p, $id){
            $p->sendMessage("Passou $id");
        });
        /** @var Player $sender */
        $sender->sendForm($form);
        return true;
    }
    /**
     * @return TextureManager
     */
    public function getTextureManager(): TextureManager
    {
        return $this->textureManager;
    }
}