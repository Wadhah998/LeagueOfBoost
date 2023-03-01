<?php

namespace App\Entity;

use App\Repository\ReservationBRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationBRepository::class)]
class ReservationB
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booster $booster =null;

    #[ORM\Column(length: 255)]
    private ?string $oldrank = null;

    #[ORM\Column(length: 255)]
    private ?string $newrank = null;

    #[ORM\Column(length: 255)]
    private ?string $newprice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooster(): ?Booster
    {
        return $this->booster;
    }

    public function setBooster(?Booster $booster): self
    {
        $this->booster = $booster;

        return $this;
    }

    public function getOldrank(): ?string
    {
        return $this->oldrank;
    }

    public function setOldrank(string $oldrank): self
    {
        $this->oldrank = $oldrank;

        return $this;
    }

    public function getNewrank(): ?string
    {
        return $this->newrank;
    }

    public function setNewrank(string $newrank): self
    {
        $this->newrank = $newrank;

        return $this;
    }

    public function getNewprice(): ?string
    {
        return $this->newprice;
    }

    public function setNewprice(string $newprice): self
    {
        $this->newprice = $newprice;

        return $this;
    }
}
