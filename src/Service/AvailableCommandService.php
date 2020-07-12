<?php


namespace App\Service;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class AvailableCommandService
{
    private $commands = [];

    /**
     * CommandService constructor.
     * @param $projectDir
     * @throws \Exception
     */
    public function __construct($projectDir)
    {
        $configDirectories = [$projectDir.'/config'];
        $fileLocator = new FileLocator($configDirectories);
        $yamlUserFiles = $fileLocator->locate('available_commands.yaml', null, false);

        if (isset($yamlUserFiles[0])) {
            $resource = $yamlUserFiles[0];
            $this->commands = Yaml::parse(file_get_contents($resource));
        } else {
            throw new \Exception("Nie znaleziono żadnego pliku konfiguracji");
        }
    }

    /**
     * @return false|string
     */
    public function getAllKeysAsJson () {
        $t = array_keys($this->commands);
        return json_encode($t, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return false|string
     */
    public function getAllWithDescAsJson () {
        $t = [];
        foreach ($this->commands as $key=>$value) {
            $item = [
                'value' => $key,
                'label' => $key,
                'desc'  => $value,
            ];
            $t [] = $item;
        }
        return json_encode($t, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}