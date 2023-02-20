<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachRepository::class)]
class Coach extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'coach', targetEntity: ReservationC::class)]
    private Collection $relation;

    public function __construct()
    {
        parent::__construct();
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ReservationC>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(ReservationC $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setCoach($this);
        }

        return $this;
    }

    public function removeRelation(ReservationC $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getCoach() === $this) {
                $relation->setCoach(null);
            }
        }

        return $this;
    }
}
