<?php

namespace App\Entity;

use App\Repository\BoosterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoosterRepository::class)]
class Booster extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'booster', targetEntity: ReservationB::class)]
    private Collection $reservation;

    public function __construct()
    {
        parent::__construct();
        $this->reservation = new ArrayCollection();
    }

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
}
