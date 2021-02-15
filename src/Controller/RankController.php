<?php

namespace App\Controller;

use App\Service\Dto\StatDTO;
use App\Service\RankService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RankController extends AbstractController
{
    /**
     * @Route("/rank", name="rank")
     * @param RankService $rankService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RankService $rankService)
    {
        $stat = $rankService->getLastStat();
        $rank = $rankService->getBestInCategories($stat->getId(),[
            new StatDTO("minecraft:custom", "minecraft:play_one_minute"),
            new StatDTO("minecraft:custom", "minecraft:time_since_death"),
            new StatDTO("minecraft:custom", "minecraft:deaths", StatDTO::$ASC),
            new StatDTO("minecraft:custom", "minecraft:sleep_in_bed"),
            new StatDTO("minecraft:custom", "minecraft:mob_kills"),
            new StatDTO("minecraft:mined", "minecraft:diamond_ore"),
            new StatDTO("minecraft:killed", "minecraft:ender_dragon"),
        ]);

        return $this->render('rank/index.html.twig', [
            'rank' => $rank
        ]);
    }
}
