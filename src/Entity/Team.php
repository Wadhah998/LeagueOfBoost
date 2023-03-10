<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'team')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\Column(length: 255)]

    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Player::class)]
    private Collection $player;

    #[ORM\Column(length: 255)]
    private ?string $player1 = null;

    #[ORM\Column(length: 255)]
    private ?string $player2 = null;

    #[ORM\Column(length: 255)]
    private ?string $player3 = null;

    #[ORM\Column(length: 255)]
    private ?string $player4 = null;

    #[ORM\Column(length: 255)]
    private ?string $player5 = null;

    public function __construct()
    {
        $this->player = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayer(): Collection
    {
        return $this->player;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->player->contains($player)) {
            $this->player->add($player);
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->player->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    public function getPlayer1(): ?string
    {
        return $this->player1;
    }

    public function setPlayer1(string $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?string
    {
        return $this->player2;
    }

    public function setPlayer2(string $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getPlayer3(): ?string
    {
        return $this->player3;
    }

    public function setPlayer3(string $player3): self
    {
        $this->player3 = $player3;

        return $this;
    }

    public function getPlayer4(): ?string
    {
        return $this->player4;
    }

    public function setPlayer4(string $player4): self
    {
        $this->player4 = $player4;

        return $this;
    }

    public function getPlayer5(): ?string
    {
        return $this->player5;
    }

    public function setPlayer5(string $player5): self
    {
        $this->player5 = $player5;

        return $this;
    }

}
