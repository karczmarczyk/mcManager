<?php


namespace App\Service;


use App\Entity\Stat;
use App\Repository\PlayerRepository;
use App\Repository\StatDetailRepository;
use App\Repository\StatRepository;
use App\Service\Dto\RankItemDTO;
use App\Service\Dto\StatDTO;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;


class RankService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var StatRepository
     */
    private $statRepository;

    /**
     * @var StatDetailRepository
     */
    private $statDetailRepository;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    private $players = [];

    /**
     * @param EntityManagerInterface $entityManager
     * @param StatRepository $statRepository
     * @param StatDetailRepository $statDetailRepository
     * @param PlayerRepository $playerRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        StatRepository $statRepository,
        StatDetailRepository $statDetailRepository,
        PlayerRepository $playerRepository
    ) {
        $this->em = $entityManager;
        $this->statRepository = $statRepository;
        $this->statDetailRepository = $statDetailRepository;
        $this->playerRepository = $playerRepository;

        $this->fetchPlayers();
    }

    private function fetchPlayers () {
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $this->players[$player->getPlayerUuid()] = $player->getPlayerName();
        }
    }

    public function getLastStat (): Stat {
        return $this->statRepository->findOneBy([], ['id'=>'DESC']);
    }

    public function getBestInCategories ($statId, $categories = []): array
    {
        $rank = [];

        foreach ($categories as $stat) {

            $rankTmp = [
                'category' => $stat->getCategory(),
                'key' => $stat->getKey(),
                'rank' => []
            ];

            $mapper = new ResultSetMapping();
            $mapper->addScalarResult('player', 'player', 'string');
            $mapper->addScalarResult('player_uuid', 'player_uuid', 'string');
            $mapper->addScalarResult('key_value', 'key_value', 'float');

            $sql = "SELECT 
                    sd.player as player,
                    sd.player_uuid as player_uuid,
                    sd.key_value as key_value
                    FROM stat_detail sd
                    WHERE sd.key_category=:keyCategory AND sd.key_name=:keyName
                    AND sd.stat_id=:statId
                    ORDER BY sd.key_value::INTEGER ".$stat->getSort();

            $query = $this->em->createNativeQuery($sql, $mapper);
            $query->setParameter('statId', $statId);
            $query->setParameter('keyCategory', $stat->getCategory());
            $query->setParameter('keyName', $stat->getKey());
            $result = $query->getResult();

            $position = 1;
            $usedPlayers = [];
            $rankCorrectOrder = [];
            $rankWithData = [];

            // ustalam dane użytkowników dla których mam dane
            foreach ($result as $item) {
                $rankItem = new RankItemDTO ();
                $rankItem->setPlayer($item['player']);
                $rankItem->setPlayerUuid($item['player_uuid']);
                $rankItem->setValue($item['key_value']);
                $rankItem->setPosition(0);
                $rankItem->setNoData(false);

                $rankWithData[] = $rankItem;

                $usedPlayers [$item['player_uuid']] = $item['player'];
            }

            if ($stat->getSort() === StatDTO::$ASC) {
                foreach ($this->players as $playerUuid => $playerName) {
                    if (isset($usedPlayers[$playerUuid])) continue;

                    $rankItem = new RankItemDTO ();
                    $rankItem->setPlayer($playerName);
                    $rankItem->setPlayerUuid($playerUuid);
                    $rankItem->setValue(0);
                    $rankItem->setPosition($position);
                    $rankItem->setNoData(true);

                    $rankCorrectOrder[] = $rankItem;

                    $position++;
                }
            }

            foreach ($rankWithData as $rankItem) {
                $rankItem->setPosition($position);
                $rankCorrectOrder[] = $rankItem;
                $position++;
            }

            if ($stat->getSort() === StatDTO::$DESC) {
                foreach ($this->players as $playerUuid => $playerName) {
                    if (isset($usedPlayers[$playerUuid])) continue;

                    $rankItem = new RankItemDTO ();
                    $rankItem->setPlayer($playerName);
                    $rankItem->setPlayerUuid($playerUuid);
                    $rankItem->setValue(0);
                    $rankItem->setPosition($position);
                    $rankItem->setNoData(true);

                    $rankCorrectOrder[] = $rankItem;

                    $position++;
                }
            }

            $rankTmp['rank'] = $rankCorrectOrder;

            $rank[] = $rankTmp;
        }

        return $rank;
    }
}
