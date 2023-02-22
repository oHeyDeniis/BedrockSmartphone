<?php

namespace oheydeniis\bs\form;

use JetBrains\PhpStorm\Internal\TentativeType;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class BedrockForm implements Form
{

    const TYPE_LONG_FORM = "form";
    const TYPE_CUSTOM_FORM = "custom_form";

    protected array $formContent = [];
    protected array $formContentIds = [];
    protected array $formContentCallable = [];

    protected string $type = "";

    public string $formId = "";
    public string $title = "";
    /**
     * @var ?callable
     */
    public $callable = null;

    public function handleResponse(Player $player, $data): void
    {
        print_r([
            "player" => $player->getDisplayName(),
            "data" => $data,
            "ids" => $this->formContentIds
        ]);

    }

    public function jsonSerialize(): mixed
    {
        return array_merge([
            "title" => $this->getFormId()." ".$this->getTitle(),
            "type" => $this->type
        ], $this->formContent);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->formId;
    }

    /**
     * @param string $formId
     */
    public function setFormId(string $formId): void
    {
        $this->formId = $formId;
    }

    /**
     * @return callable|null
     */
    public function getCallable(): ?callable
    {
        return $this->callable;
    }

    /**
     * @param callable|null $callable
     */
    public function setCallable(?callable $callable): void
    {
        $this->callable = $callable;
    }

    public function setIdORcallable(string|callable|null $who){
        if(is_null($who)){
            return;
        }
        if(is_string($who)){
            $this->formContentIds[] = $who;
        }else{
            $id = mt_rand(10000, 99999);
            $this->formContentIds[] = $id;
            $this->formContentCallable[$id] = $who;
        }
    }
    public function getImageType(string $image) : string{
        return str_contains("http", $image) ? "url" : "path";
    }
    public function convertImagePath(string $image)  : string{
        if(!str_contains($image, "/")){
            return $image;
        }
        return "textures/custom/$image";
    }
}