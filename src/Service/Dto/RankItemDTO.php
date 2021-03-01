<?php

namespace App\Service\Dto;

class RankItemDTO
{
    private $player;
    private $playerUuid;
    private $value;
    private $position;
    private $noData = false;

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player): void
    {
        $this->player = $player;
    }

    /**
     * @return mixed
     */
    public function getPlayerUuid()
    {
        return $this->playerUuid;
    }

    /**
     * @param mixed $playerUuid
     */
    public function setPlayerUuid($playerUuid): void
    {
        $this->playerUuid = $playerUuid;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return bool
     */
    public function isNoData(): bool
    {
        return $this->noData;
    }

    /**
     * @param bool $noData
     */
    public function setNoData(bool $noData): void
    {
        $this->noData = $noData;
    }




}