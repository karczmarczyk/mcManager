<?php


namespace App\Service;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;


class CommandService
{

    private $configValues = [];

    /**
     * CommandService constructor.
     * @param $projectDir
     * @throws \Exception
     */
    public function __construct($projectDir)
    {
        $configDirectories = [$projectDir.'/config'];

        $fileLocator = new FileLocator($configDirectories);
        $yamlUserFiles = $fileLocator->locate('commands.yaml', null, false);

        if (isset($yamlUserFiles[0])) {
            $resource = $yamlUserFiles[0];
            $this->configValues = Yaml::parse(file_get_contents($resource));
        } else {
            throw new \Exception("Nie znaleziono żadnego pliku konfiguracji");
        }
    }

    /**
     * @param $src
     * @param $keysValues
     * @return mixed
     */
    private function bind ($src, $keysValues) {
        foreach ($keysValues as $key => $value) {
            $src = str_replace("%".$key."%", $value, $src);
        }
        return $src;
    }

    //===============================================================================================================//
    //================================================== GETTERY ====================================================//
    //===============================================================================================================//

    public function getServerPath ():String
    {
        return $this->configValues['getServerPath'];
    }

    public function getScreenName ():String
    {
        return $this->configValues['getScreenName'];
    }

    public function getCurrentLog ():String
    {
        return $this->bind($this->configValues['getCurrentLog'],[
            'serverPath' => $this->getServerPath()
        ]);
    }

    public function getConsoleCommand (String $command):String
    {
        return $this->bind($this->configValues['getConsoleCommand'],[
            'command' => $command,
            'screen' => $this->getScreenName()
        ]);
    }

    public function getCpuUsage ()
    {
        return $this->configValues['getCpuUsage'];
    }

    public function getMemoryUsage ()
    {
        return $this->configValues['getMemoryUsage'];
    }

    public function getDiscUsage ()
    {
        return $this->configValues['getDiscUsage'];
    }

    public function getUptime ()
    {
        return $this->configValues['getUptime'];
    }

    public function getDate ()
    {
        return $this->configValues['getDate'];
    }
}