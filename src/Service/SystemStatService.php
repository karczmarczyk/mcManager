<?php

namespace App\Service;


use App\Utils\AppTool;

class SystemStatService
{
    private $commandService;
    private $conn;

    public function __construct(CommandService $commandService, SshService $sshService)
    {
        $this->commandService = $commandService;
        $this->conn = $sshService;
    }

    public function getAll ()
    {
        $stat = [];
        $stat['cpu'] = $this->getCpuUsage();
        $stat['memory'] = $this->getMemoryUsage();
        $stat['disc'] = $this->getDiscUsage();
        $stat['uptime'] = $this->getUptime();
        $stat['date'] = $this->getDate();
        return $stat;
    }

    /**
     * @return mixed
     */
    public function getCpuUsage ()
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getCpuUsage());

        $cpu = [];

        $lines = explode("\n", $result);

        $i = 0;
        foreach ($lines as $line) {
            if ($i>0) {
                $cells = explode(" ", $output = preg_replace('!\s+!', ' ', $line));
                if (count($cells) > 2)
                $cpu['CPU_'.$cells[1]] = AppTool::StringToNumeric($cells[2]);
            }

            $i++;
        }

        return $cpu;
    }

    /**
     *
     */
    public function getMemoryUsage ()
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getMemoryUsage());

        $memory = [];

        $lines = explode("\n", $result);

        foreach ($lines as $line) {
            $cells = explode(" ", $output = preg_replace('!\s+!', ' ', $line));
            if (count($cells) == 3) {
                $memory[str_replace(':','',$cells[0])] = [
                    'value' => $cells[1],
                    'unit' => $cells[2]
                ];
            }
        }

        return $memory;
    }

    /**
     *
     */
    public function getDiscUsage ()
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getDiscUsage());

        $disc = [];

        $lines = explode("\n", $result);

        foreach ($lines as $line) {
            $cells = explode(" ", $output = preg_replace('!\s+!', ' ', $line));
            if (count($cells) >= 6) {
                $disc[$cells[0]] = [
                    'sys' => $cells[1],
                    'full' => $cells[2],
                    'used' => $cells[3],
                    'free' => $cells[4],
                    'percent' => $cells[5],
                    'percent_value' => str_replace('%','', $cells[5])
                ];
            }
        }

    return $disc;
    }

    /**
     *
     */
    public function getDate ()
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getDate());

        $lines = explode("\n", $result);

        return $lines[0];
    }

    /**
     *
     */
    public function getUptime ()
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getUptime());

        $lines = explode("\n", $result);

        return $lines[0];
    }
}