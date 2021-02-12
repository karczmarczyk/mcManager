<?php

namespace App\Entity;

use App\Repository\StatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatRepository::class)
 */
class Stat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\OneToMany(targetEntity=StatDetail::class, mappedBy="stat")
     */
    private $statDetails;

    public function __construct()
    {
        $this->statDetails = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return Collection|StatDetail[]
     */
    public function getStatDetails(): Collection
    {
        return $this->statDetails;
    }

    public function addStatDetail(StatDetail $statDetail): self
    {
        if (!$this->statDetails->contains($statDetail)) {
            $this->statDetails[] = $statDetail;
            $statDetail->setStat($this);
        }

        return $this;
    }

    public function removeStatDetail(StatDetail $statDetail): self
    {
        if ($this->statDetails->contains($statDetail)) {
            $this->statDetails->removeElement($statDetail);
            // set the owning side to null (unless already changed)
            if ($statDetail->getStat() === $this) {
                $statDetail->setStat(null);
            }
        }

        return $this;
    }
}
