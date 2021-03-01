<?php

namespace App\Command;

use DateTime;
use App\Service\PlayerService;
use App\Service\StatService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * php bin/console app:fillAll
 *
 * Class FillAllCommand
 * @package App\Command
 */
class FillAllCommand extends Command
{
    protected static $defaultName = 'app:fillAll';

    /**
     * @var PlayerService
     */
    private $playerService;

    /**
     * @var StatService
     */
    private $statService;

    public function __construct(PlayerService $playerService, StatService $statService)
    {
        $this->playerService = $playerService;
        $this->statService = $statService;
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
        $output->writeln(['CREATE ALL', '============']);
        $start = microtime(true);

        $this->createPlayers($output);
        $this->createStats($output);

        $end = microtime(true);
        $diff = $end-$start;
        $output->writeln([
            'TIME: ' . \App\Helper\GeneralUtils::udate('i:s.u', $diff)
        ]);

        return 0;
    }

    /**
     * @param OutputInterface $output
     */
    private function createPlayers (OutputInterface $output) {
        $output->writeln(['CREATE PLAYERS']);

        $this->playerService->fillDb();

        $output->writeln([
            'PLAYERS successfully generated!'
        ]);
    }

    /**
     * @param OutputInterface $output
     * @throws \Exception
     */
    private function createStats (OutputInterface $output) {
        $output->writeln(['CREATE STATS']);

        $date = new DateTime();

        $statVersion = $this->statService->fill($date);

        if ($statVersion instanceof \App\Entity\Stat) {
            $output->writeln([
                'STATS successfully generated! STATS version ID is '.$statVersion->getId()
            ]);

        } else {
            $output->writeln([
                'STATS generated with ERRORS!',
                '',
            ]);
        }
    }
}