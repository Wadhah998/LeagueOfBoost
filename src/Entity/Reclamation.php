<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = false;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\Column(length: 100)]
    private ?string $object = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;
////////////////////////////////////////////



//////////////////////////////////////////////
    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'reclamation', targetEntity: Message::class,)]
    #[ORM\JoinColumn(onDelete:"CASCADE")]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'reclamation', targetEntity: Rating::class)]
    private Collection $ratings;





    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
    /////////////////////////////////////////////
    ///
    ///


    //////////////////////////////////////////



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getmessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $messages): self
    {
        if (!$this->messages->contains($messages)) {
            $this->messages->add($messages);
            $messages->setReclamation($this);
        }

        return $this;
    }

    public function removeMessage(Message $messages): self
    {
        if ($this->messages->removeElement($messages)) {
            // set the owning side to null (unless already changed)
            if ($messages->getReclamation() === $this) {
                $messages->setReclamation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setReclamation($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getReclamation() === $this) {
                $rating->setReclamation(null);
            }
        }

        return $this;
    }
}
