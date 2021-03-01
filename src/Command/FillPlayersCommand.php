<?php

namespace App\Command;

use App\Service\PlayerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * php bin/console app:fillStats
 *
 * Class FillPlayersCommand
 * @package App\Command
 */
class FillPlayersCommand extends Command
{
    protected static $defaultName = 'app:fillPlayers';

    /**
     * @var PlayerService
     */
    private $playerService;

    /**
     * @param PlayerService $playerService
     */
    public function __construct(
        PlayerService $playerService
    ) {
        $this->playerService = $playerService;
        parent::__construct();
    }

    /**
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['CREATE PLAYERS', '============']);

        $start = microtime(true);

        $this->playerService->fillDb();

        $output->writeln([
            'PLAYERS successfully generated!'
        ]);

        $end = microtime(true);
        $diff = $end-$start;
        $output->writeln([
            'TIME: ' . \App\Helper\GeneralUtils::udate('i:s.u', $diff)
        ]);

        return 0;
    }

}