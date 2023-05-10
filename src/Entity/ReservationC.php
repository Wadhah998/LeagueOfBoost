<?php

namespace App\Entity;

use App\Repository\ReservationCRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationCRepository::class)]
class ReservationC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Coach $coach = null;

    #[ORM\Column]
    private ?int $Nbr_heures = null;

    #[ORM\Column]
    private ?int $Prix = null;

    #[ORM\Column(length: 255)]
    private ?string $Langue = null;

    #[ORM\ManyToOne(inversedBy: 'reservationCs')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getNbrHeures(): ?int
    {
        return $this->Nbr_heures;
    }

    public function setNbrHeures(int $Nbr_heures): self
    {
        $this->Nbr_heures = $Nbr_heures;

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

    public function getLangue(): ?string
    {
        return $this->Langue;
    }

    public function setLangue(string $Langue): self
    {
        $this->Langue = $Langue;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    
}
