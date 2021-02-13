<?php

namespace App\Entity;

use App\Repository\StatDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatDetailRepository::class)
 */
class StatDetail
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
    private $player;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerUuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keyValue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keyCategory;

    /**
     * @ORM\ManyToOne(targetEntity=Stat::class, inversedBy="statDetails", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $stat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(string $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getKeyName(): ?string
    {
        return $this->keyName;
    }

    public function setKeyName(string $keyName): self
    {
        $this->keyName = $keyName;

        return $this;
    }

    public function getKeyValue(): ?string
    {
        return $this->keyValue;
    }

    public function setKeyValue(string $keyValue): self
    {
        $this->keyValue = $keyValue;

        return $this;
    }

    public function getStat(): ?Stat
    {
        return $this->stat;
    }

    public function setStat(?Stat $stat): self
    {
        $this->stat = $stat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getKeyCategory()
    {
        return $this->keyCategory;
    }

    /**
     * @param mixed $keyCategory
     */
    public function setKeyCategory($keyCategory): void
    {
        $this->keyCategory = $keyCategory;
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

    public function __toString()
    {
        return "";
    }


}
