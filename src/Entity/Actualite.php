<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
class Actualite
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
#[ORM\Groups('actualites')]
private ?int $id = null;

#[ORM\Column(type: Types::TEXT)]
#[ORM\Groups('actualites')]
private ?string $Description = null;

#[ORM\OneToMany(mappedBy: 'comments', targetEntity: Commentaire::class)]
#[ORM\Groups('actualites')]
private Collection $commentaire;

#[ORM\Column(length: 255)]
#[ORM\Groups('actualites')]
private ?string $Titre = null;

#[ORM\Column(nullable: true)]
#[ORM\Groups('actualites')]
private ?int $Likes = null;

public function __construct()
{
$this->commentaire = new ArrayCollection();
}

public function getId(): ?int
{
return $this->id;
}

public function getDescription(): ?string
{
return $this->Description;
}

public function setDescription(string $Description): self
{
$this->Description = $Description;

return $this;
}

/**
* @return Collection<int, Commentaire>
*/
public function getCommentaire(): Collection
{
return $this->commentaire;
}

public function addCommentaire(Commentaire $commentaire): self
{
if (!$this->commentaire->contains($commentaire)) {
$this->commentaire->add($commentaire);
$commentaire->setComments($this);
}

return $this;
}

public function removeCommentaire(Commentaire $commentaire): self
{
if ($this->commentaire->removeElement($commentaire)) {
// set the owning side to null (unless already changed)
if ($commentaire->getComments() === $this) {
$commentaire->setComments(null);
}
}

return $this;
}

public function getTitre(): ?string
{
return $this->Titre;
}

public function setTitre(string $Titre): self
{
$this->Titre = $Titre;

return $this;
}
public function __toString()
{
return $this->getTitre(); // or whatever property you want to use as the string representation
}

public function getLikes(): ?int
{
return $this->Likes;
}

public function setLikes(?int $Likes): self
{
$this->Likes = $Likes;

return $this;
}
}