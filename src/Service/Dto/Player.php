<?php


namespace App\Service\Dto;


class Player
{
    private $uuid;
    private $name;
    private $lastActivity;
    private $lastActivityH;
    private $playNow = false;

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * @param mixed $lastActivity
     */
    public function setLastActivity($lastActivity): void
    {
        $this->lastActivity = $lastActivity;
    }

    /**
     * @return mixed
     */
    public function getLastActivityH()
    {
        return $this->lastActivityH;
    }

    /**
     * @param mixed $lastActivityH
     */
    public function setLastActivityH($lastActivityH): void
    {
        $this->lastActivityH = $lastActivityH;
    }

    /**
     * @return mixed
     */
    public function getPlayNow()
    {
        return $this->playNow;
    }

    /**
     * @param mixed $playNow
     */
    public function setPlayNow($playNow): void
    {
        $this->playNow = $playNow;
    }

}