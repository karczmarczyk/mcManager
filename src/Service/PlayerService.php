<?php


namespace App\Service;


use App\Repository\PlayerRepository;
use App\Service\Dto\Enchantment;
use App\Service\Dto\InventoryItem;
use App\Service\Dto\Player;
use App\Service\Dto\PlayerDetails;
use App\Utils\FileTool;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService
{
    /**
     * @var SshService
     */
    private $conn;
    /**
     * @var FileManagerService
     */
    private $fileManager;
    /**
     * @var CommandService
     */
    private $command;
    /**
     * @var MinecraftServerService
     */
    private $minecraftServerService;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * PlayerService constructor.
     * @param SshService $conn
     * @param FileManagerService $fileManagerService
     * @param CommandService $commandService
     * @param MinecraftServerService $minecraftServerService
     * @param EntityManagerInterface $entityManager
     * @param PlayerRepository $playerRepository
     */
    public function __construct(SshService $conn, FileManagerService $fileManagerService,
                                CommandService $commandService, MinecraftServerService $minecraftServerService,
                                EntityManagerInterface $entityManager, PlayerRepository $playerRepository)
    {
        $this->conn = $conn;
        $this->fileManager = $fileManagerService;
        $this->command = $commandService;
        $this->minecraftServerService = $minecraftServerService;
        $this->em = $entityManager;
        $this->playerRepository = $playerRepository;
    }

    /**
     * Return players list
     * @return array
     */
    public function getPlayers ()
    {
        $userPath = $this->getUserFilesPath();
        $files = $this->fileManager->getFileList($userPath, true);
        $players = [];
        $activePlayers = $this->minecraftServerService->getPlayersOnlineList();
        foreach ($files as $file) {
            // only dat file
            if (!FileTool::hasExtension($file->getFileName(), 'dat')) {
                continue;
            }
            $player = new Player();
            $player->setUuid($this->_fetchPlayerUuidFromFileName($file->getFileName()));
            $player->setName($this->_fetchPlayerNameFromContent($this->fileManager->getFileContent($file->getFileAbsoluteName())));
            $player->setLastActivityH($file->getModifyTimeH());
            $player->setLastActivity($file->getModifyTime());
            $player->setPlayNow(in_array($player->getName(), $activePlayers));
            $players [] = $player;
        }
        return $players;
    }

    private function getUserFilesPath ()
    {
        return $this->command->getServerPath()
            .DIRECTORY_SEPARATOR."world".DIRECTORY_SEPARATOR."playerdata".DIRECTORY_SEPARATOR;
    }

    /**
     *
     */
    public function getStats ($uuid)
    {
        $userStatsPath = $this->command->getServerPath()
            .DIRECTORY_SEPARATOR."world".DIRECTORY_SEPARATOR."stats".DIRECTORY_SEPARATOR.$uuid.'.json';
        $fileJsonContent = $this->fileManager->getFileContent($userStatsPath);
        $playerStats = json_decode( $fileJsonContent , true );
//        print_r($playerStats); exit;
        return $playerStats;
    }

    /**
     * @param $uuid
     * @return \PlayerDetails
     */
    public function getPlayerDetails ($uuid): PlayerDetails
    {
        $content = $this->getUserFileContentByUuid($uuid);

        $nbtService = new \Nbt\Service(new \Nbt\DataHandler());
        $tree = $nbtService->readString($content);

        $playerDetails = new PlayerDetails ();
        $playerDetails->setInventory($this->getInventory($tree));

        return $playerDetails;
    }

    /**
     * @param $tree
     * @return array
     */
    public function getInventory ($tree): array
    {
        $inventoryList = [];

        $Inventory = $tree->findChildByName('Inventory');
        foreach ($Inventory->getChildren() as $child) {

            $inventory = new InventoryItem();

            foreach($child->getChildren() as $item) {

                if ($item->getName() == 'Slot') {
                    $inventory->setSlot($item->getValue());
                }
                else if ($item->getName() == 'id') {
                    $inventory->setId($item->getValue());
                }
                else if ($item->getName() == 'Count') {
                    $inventory->setCount($item->getValue());
                }
                else if ($item->getValue()==NULL) {
                    foreach($item->getChildren() as $tag) {
                        if ($tag->getName() == 'Enchantments') {
                            // enchant - lista
                            $tagT = [];
                            foreach ($tag->getChildren() as $ttKey=>$t) {
                                $enchantment = new Enchantment();
                                foreach ($t->getChildren() as $tt) {
                                    if ($tt->getName() == "id") {
                                        $enchantment->setId($tt->getValue());
                                    }
                                    else if ($tt->getName() == "lvl") {
                                        $enchantment->setLvl($tt->getValue());
                                    }
                                    $tagT[$ttKey] = $enchantment;
                                }
                            }
                            $inventory->addTag($tag->getName(), $tagT);
                        } else {
                            // inne jednowymiarowe
                            $inventory->addTag($tag->getName(), $tag->getValue());
                        }
                    }
                }
            }

            $inventoryList[$inventory->getSlot()] = $inventory;
        }

        return $inventoryList;
    }

    /**
     * @param $uuid
     * @param bool $gzdecode
     * @return false|String|null
     */
    public function getUserFileContentByUuid ($uuid, $gzdecode = true)
    {
        $userPath = $this->getUserFilesPath();
        $file = $userPath . DIRECTORY_SEPARATOR . $uuid . ".dat";
        $content = $this->fileManager->getFileContent($file);
        if ($gzdecode) {
            $content = gzdecode($content);
        }
        return $content;
    }

    /**
     * Uzupełnia / aktualizuje listę w bazie danych
     */
    public function fillDb () {
        foreach ($this->getPlayers() as $player) {
            $this->addOrUpdate($player);
        }
    }

    /**
     * @param Player $player
     * @return \App\Entity\Player
     */
    public function addOrUpdate (Player $player):\App\Entity\Player {
        $playerDb = $this->playerRepository->findOneBy([
            'playerUuid' => $player->getUuid()
        ]);

        if (is_null($playerDb)) {
            $playerDb = new \App\Entity\Player();
            $playerDb->setPlayerUuid($player->getUuid());
        }

        $playerDb->setPlayerName($player->getName());
        $this->em->persist($playerDb);
        $this->em->flush();

        return $playerDb;
    }

    /**
     * @param $fileName
     * @return mixed
     */
    private function _fetchPlayerUuidFromFileName ($fileName)
    {
        return str_replace(".dat","", $fileName);
    }

    /**
     * @param $content
     * @return mixed
     */
    private function _fetchPlayerNameFromContent ($content)
    {
        $content = gzdecode($content);
        preg_match('/lastKnownName\X\X([a-zA-Z0-9\@\!\#\$\%\^\&\*\(\)]*)\X\X/', $content, $matches);
        return $matches[1] ?? null;
    }
}