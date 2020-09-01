<?php


namespace App\Controller;


use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayersController extends AbstractController
{
    /**
     * @Route("/players/index", name="players")
     * @param PlayerService $playerService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction (PlayerService $playerService)
    {
        $players = $playerService->getPlayers();
        // sortowanie po aktywności
        usort($players, function($a, $b) {return strcmp($b->getLastActivity(), $a->getLastActivity());});
        return $this->render('players/index.html.twig', [
            'players' => $players
        ]);
    }

    /**
     * @Route("/players/{uuid}/stats", name="player_stats")
     */
    public function getPlayerStatsAction (PlayerService $playerService, $uuid)
    {
        $stats = $playerService->getStats($uuid);

        return $this->render('players/_stats.html.twig', [
            'uuid' => $uuid,
            'stats' => $stats
        ]);
    }
}