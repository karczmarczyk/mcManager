<?php


namespace App\Service;


use App\Entity\Stat;
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

    private $statRepository;

    private $statDetailRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param StatRepository $statRepository
     * @param StatDetailRepository $statDetailRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        StatRepository $statRepository,
        StatDetailRepository $statDetailRepository
    ) {
        $this->em = $entityManager;
        $this->statRepository = $statRepository;
        $this->statDetailRepository = $statDetailRepository;
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
            foreach ($result as $item) {
                $rankItem = new RankItemDTO ();
                $rankItem->setPlayer($item['player']);
                $rankItem->setPlayerUuid($item['player_uuid']);
                $rankItem->setValue($item['key_value']);
                $rankItem->setPosition($position);
                $rankTmp['rank'][] = $rankItem;
                $position ++;
            }

            $rank[] = $rankTmp;
        }

        return $rank;
    }
}
