<?php

namespace App\Service;

use App\Entity\Stat;
use App\Entity\StatDetail;
use App\Repository\StatRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    private $playerService;

    private $statRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param PlayerService $playerService
     * @param StatRepository $statRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PlayerService $playerService,
        StatRepository $statRepository
    ) {
        $this->em = $entityManager;
        $this->playerService = $playerService;
        $this->statRepository = $statRepository;
    }

    public function fill ($date): ?Stat
    {
        // tworzę obiekt wersji
        $stat = new Stat();
        $stat->setDatetime($date);
        foreach ($this->playerService->getPlayers() as $player) {
            $playerStats = $this->playerService->getStats($player->getUuid());
            if (!isset($playerStats['stats'])) {
                continue;
            }
            foreach ($playerStats['stats'] as $statCategoryName => $statCategory) {
                foreach ($statCategory as $key => $value) {
                    $statDetail = new StatDetail();
                    $statDetail->setPlayer($player->getName());
                    $statDetail->setKeyName($key);
                    $statDetail->setKeyValue($value);
                    $statDetail->setKeyCategory($statCategoryName);
                    $statDetail->setStat($stat);
                    $statDetail->setPlayer($player->getName());
                    $statDetail->setPlayerUuid($player->getUuid());

                    $stat->addStatDetail($statDetail);
                }
            }
        }

        $this->em->persist($stat);
        $this->em->flush();
        return $stat;
    }
}