<?php

namespace oheydeniis\bs\texture;

use oheydeniis\bs\Main;
use pocketmine\resourcepacks\ResourcePackManager;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class TextureManager
{

    use SingletonTrait;

    /*
     * Aqui deve ser gerada a textura do plugin
     */

    private string $textureFolder = "";

    private ResourcePackManager $resourcePackManager;
    private \ReflectionProperty $resourcePacksValue;
    private mixed $resourcePacks;
    private mixed $uuidList;
    private \ReflectionProperty $uuidListValue;

    private ServerFormManager $serverFormManager;
    private UiDefsManager $uiDefsManager;

    public function __construct(
        public Main $main
    )
    {
        self::setInstance($this);
        $this->textureFolder = $this->main->getDataFolder()."BedrockTexture/";
        @mkdir($this->textureFolder);
        $this->saveResources();
        $this->load();

    }
    public function load(){
        $this->serverFormManager = new ServerFormManager($this->textureFolder."ui/server_form.json");
        $this->uiDefsManager = new UiDefsManager($this->textureFolder."ui/_ui_defs.json");

        $this->resourcePackManager = $this->main->getServer()->getResourcePackManager();
        $ri = new \ReflectionClass(ResourcePackManager::class);
        $this->resourcePacksValue = $ri->getProperty("resourcePacks");
        $this->resourcePacksValue->setAccessible(true);
        $this->resourcePacks = $this->resourcePacksValue->getValue($this->resourcePackManager);
        $this->uuidListValue = $ri->getProperty("uuidList");
        $this->uuidListValue->setAccessible(true);
        $this->uuidList = $this->uuidListValue->getValue($this->resourcePackManager);

    }
    public function build() : void{
        $this->info("Building ZIP archive!");
        $this->buildZip();
        $this->info("Apply texture in server");
        $this->reloadTextures();
        $this->info("texture update finished!");
    }
    public function buildZip(bool $delete = true){

        if($delete){
            $zipTarget = $this->main->getServer()->getDataPath()."resource_packs" . DIRECTORY_SEPARATOR . "BedrockTexture.zip";
            if (is_file($zipTarget)){
                $this->info("deleting actual zip...");
                @unlink($zipTarget);
            }
        }
        $rootPath = realpath($this->textureFolder);
        $zip = new \ZipArchive();
        $zipTarget = $this->main->getServer()->getDataPath()."resource_packs" . DIRECTORY_SEPARATOR . "BedrockTexture.zip";
        if(($code = $zip->open($zipTarget, \ZipArchive::CREATE|\ZipArchive::OVERWRITE|\ZipArchive::CHECKCONS|\ZipArchive::EXCL)) !== TRUE){
            $this->info("§cError while creating new ZIP code: $code (try again)");

            return;
        }

        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file)
        {
            if (!$file->isDir())
            {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }

    /**
     * Reload resource_packs and apply to new player when yours join
     * @return void
     */
    public function reloadTextures(){
        $resourcePacks = [];
        $uuidList = [];

        $path = $this->main->getServer()->getDataPath() . "resource_packs" . DIRECTORY_SEPARATOR;
        $list = (new Config($path."resource_packs.yml", Config::YAML))->get("resource_stack", []);
        $list[] = "BedrockTexture.zip";
        foreach ($list as $pack){
            $zip = $path.$pack;
            if(is_file($zip)){
                $zipped = new ZippedResourcePack($zip);
                $resourcePacks[] = $zipped;
                $uuidList[strtolower($zipped->getPackId())] = $zipped;
            }
        }
        $this->resourcePacksValue->setValue($this->resourcePackManager, $resourcePacks);
        $this->uuidListValue->setValue($this->resourcePackManager, $uuidList);
    }

    public function saveResources() : void{
        $this->main->saveResource("BedrockTexture/manifest.json");
        $this->main->saveResource("BedrockTexture/ui/server_form.json");
        $this->main->saveResource("BedrockTexture/ui/custom/custom_ui_example.json");
    }

    /**
     * @param CustomUI $ui
     * @return void
     * @throws \JsonException
     * @internal to create you custom ui use LongFormData or CustomFormData and use addUI method!
     */
    public function createCustomUI(CustomUI $ui){
        $file = new Config($this->textureFolder."ui/custom/{$ui->getFileName()}", Config::JSON);
        $file->setAll($ui->getContent());
        $file->save();

    }
    public function info(string $messgae) : void{
        $this->main->getServer()->getLogger()->info("§eBedrockTexture > §6$messgae");
    }

    /**
     * @return ServerFormManager
     */
    public function getServerFormManager(): ServerFormManager
    {
        return $this->serverFormManager;
    }

}