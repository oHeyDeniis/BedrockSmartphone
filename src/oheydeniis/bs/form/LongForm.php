<?php

namespace oheydeniis\bs\form;

use pocketmine\player\Player;

class LongForm extends BedrockForm
{

    public function __construct(string $formId, ?callable $response = null)
    {
        $this->setCallable($response);
        $this->setFormId($formId);
        $this->type = self::TYPE_LONG_FORM;
    }
    public function setFormDescription(string $message) : void{
        $this->formContent["content"] = $message;
    }
    public function addButton(string $text, ?string $image, string|callable|null $callableORid = null){
        if(is_null($image)) {
            $this->addSimpleButton($text, $callableORid);
            return;
        }
        $button = [
            "text" => $text,
            "image" => [
                "type" => $this->getImageType($image),
                "data" => $this->convertImagePath($image)
            ]
        ];
        $this->formContent["buttons"][] = $button;
        $this->setIdORcallable($callableORid);
    }
    public function addSimpleButton(string $text, string|callable|null $callableORid = null){
        $button =  [
            "text" => $text
        ];
        $this->formContent["buttons"][] = $button;
        $this->setIdORcallable($callableORid);
    }

    /**
     * @param Player $player
     * @param ?int $data
     * @return void
     */
    public function handleResponse(Player $player, $data): void
    {
        if(is_null($data)) return;
        $contentId = $this->formContentIds[$data] ?? -1;
        if(isset($this->formContentCallable[$contentId])){
            $callable = $this->formContentCallable[$contentId];
            $callable($player);
        }else{
            if(($callable = $this->getCallable()) != null){
                $callable($player, $contentId);
            }
        }
    }
    public function send(Player $player){
        $player->sendForm($this);
    }

}