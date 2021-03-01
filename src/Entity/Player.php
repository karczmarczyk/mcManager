<?php

namespace App\Entity;

use App\Repository\StatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatRepository::class)
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerUuid;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * @param mixed $playerName
     */
    public function setPlayerName($playerName): void
    {
        $this->playerName = $playerName;
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

}