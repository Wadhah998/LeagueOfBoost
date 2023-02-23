<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $riot_username = null;

    #[ORM\Column(length: 255)]
    private ?string $op_gg = null;

    #[ORM\ManyToOne(inversedBy: 'player')]
    private ?Team $team = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRiotUsername(): ?string
    {
        return $this->riot_username;
    }

    public function setRiotUsername(string $riot_username): self
    {
        $this->riot_username = $riot_username;

        return $this;
    }

    public function getOpGg(): ?string
    {
        return $this->op_gg;
    }

    public function setOpGg(string $op_gg): self
    {
        $this->op_gg = $op_gg;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }
}
