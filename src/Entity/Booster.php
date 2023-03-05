<?php

namespace App\Entity;

use App\Repository\BoosterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoosterRepository::class)]
class Booster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'booster', targetEntity: ReservationB::class)]
    private Collection $reservation;

    #[ORM\Column(length: 255)]
    private ?string $rang = null;

    #[ORM\Column(length: 255)]
    private ?string $lane = null;

    #[ORM\Column(length: 255)]
    private ?string $op_gg = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;
    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\Column]
    private ?int $period = null;

    #[ORM\Column]
    private ?float $wallet = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?bool $availability = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ReservationB>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(ReservationB $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setBooster($this);
        }

        return $this;
    }

    public function removeReservation(ReservationB $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getBooster() === $this) {
                $reservation->setBooster(null);
            }
        }

        return $this;
    }

    public function getRang(): ?string
    {
        return $this->rang;
    }

    public function setRang(string $rang): self
    {
        $this->rang = $rang;

        return $this;
    }

    public function getLane(): ?string
    {
        return $this->lane;
    }

    public function setLane(string $lane): self
    {
        $this->lane = $lane;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getWallet(): ?float
    {
        return $this->wallet;
    }

    public function setWallet(float $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }
}
