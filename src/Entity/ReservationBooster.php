<?php

namespace App\Entity;

use App\Repository\ReservationBoosterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationBoosterRepository::class)]
class ReservationBooster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Oldrank = null;

    #[ORM\Column(length: 255)]
    private ?string $Newrank = null;

    #[ORM\Column]
    private ?int $Prix = null;

    #[ORM\ManyToOne(inversedBy: 'reservationBoosters')]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldrank(): ?string
    {
        return $this->Oldrank;
    }

    public function setOldrank(string $Oldrank): self
    {
        $this->Oldrank = $Oldrank;

        return $this;
    }

    public function getNewrank(): ?string
    {
        return $this->Newrank;
    }

    public function setNewrank(string $Newrank): self
    {
        $this->Newrank = $Newrank;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
