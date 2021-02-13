<?php

namespace App\Command;

use App\Service\StatService;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * php bin/console app:fillStats
 *
 * Class FillStatsCommand
 * @package App\Command
 */
class FillStatsCommand extends Command
{
    protected static $defaultName = 'app:fillStats';

    /**
     * @var StatService
     */
    private $statService;

    /**
     * @param StatService $statService
     */
    public function __construct(
        StatService $statService
    ) {
        $this->statService = $statService;
        parent::__construct();
    }

    /**
     *
     * @param \App\Command\InputInterface $input
     * @param \App\Command\OutputInterface $output
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['CREATE STATS', '============']);

        $start = microtime(true);

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
        $end = microtime(true);
        $diff = $end-$start;
        $output->writeln([
            'TIME: ' . \App\Helper\GeneralUtils::udate('i:s.u', $diff)
        ]);

        return 0;
    }

}