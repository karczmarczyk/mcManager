<?php
namespace App\Service\Dto;

class PlayerDetails
{
    private $xpLvl;
    private $xpP;
    private $inventory = [];
    private $spawnXYZ;
    private $posXYZ;
    private $health;
    private $firstPlayed;
    private $lastPlayed;
    private $foodExhaustionLvl;
    private $foodLvl;

    /**
     * @return mixed
     */
    public function getXpLvl()
    {
        return $this->xpLvl;
    }

    /**
     * @param mixed $xpLvl
     */
    public function setXpLvl($xpLvl): void
    {
        $this->xpLvl = $xpLvl;
    }

    /**
     * @return mixed
     */
    public function getXpP()
    {
        return $this->xpP;
    }

    public function getXpPHuman()
    {
        return round($this->getXpP()*100, 2);
    }

    /**
     * @param mixed $xpP
     */
    public function setXpP($xpP): void
    {
        $this->xpP = $xpP;
    }

    /**
     * @return array
     */
    public function getInventory(): array
    {
        return $this->inventory;
    }

    /**
     * @param array $inventory
     */
    public function setInventory(array $inventory): void
    {
        $this->inventory = $inventory;
    }

    /**
     * @return mixed
     */
    public function getSpawnXYZ()
    {
        return $this->spawnXYZ;
    }

    /**
     * @param mixed $spawnXYZ
     */
    public function setSpawnXYZ($spawnXYZ): void
    {
        $this->spawnXYZ = $spawnXYZ;
    }

    /**
     * @return mixed
     */
    public function getPosXYZ()
    {
        return $this->posXYZ;
    }

    /**
     * @param mixed $posXYZ
     */
    public function setPosXYZ($posXYZ): void
    {
        $this->posXYZ = $posXYZ;
    }

    /**
     * @return mixed
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @param mixed $health
     */
    public function setHealth($health): void
    {
        $this->health = $health;
    }

    /**
     * @return mixed
     */
    public function getFirstPlayed()
    {
        return $this->firstPlayed;
    }

    /**
     * @param mixed $firstPlayed
     */
    public function setFirstPlayed($firstPlayed): void
    {
        $this->firstPlayed = $firstPlayed;
    }

    /**
     * @return mixed
     */
    public function getLastPlayed()
    {
        return $this->lastPlayed;
    }

    /**
     * @param mixed $lastPlayed
     */
    public function setLastPlayed($lastPlayed): void
    {
        $this->lastPlayed = $lastPlayed;
    }

    /**
     * @return mixed
     */
    public function getFoodExhaustionLvl()
    {
        return $this->foodExhaustionLvl;
    }

    /**
     * @param mixed $foodExhaustionLvl
     */
    public function setFoodExhaustionLvl($foodExhaustionLvl): void
    {
        $this->foodExhaustionLvl = $foodExhaustionLvl;
    }

    /**
     * @return mixed
     */
    public function getFoodLvl()
    {
        return $this->foodLvl;
    }

    /**
     * @param mixed $foodLvl
     */
    public function setFoodLvl($foodLvl): void
    {
        $this->foodLvl = $foodLvl;
    }


}