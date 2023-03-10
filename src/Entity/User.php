<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $voie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienOpgg = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $solde = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: SessionCoaching::class)]
    private Collection $sessionCoachings;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ReservationC::class)]
    private Collection $reservationCs;

    public function __construct()
    {
        $this->sessionCoachings = new ArrayCollection();
        $this->reservationCs = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }



    public function __toString(): string
    {
        return $this->firstname.
            $this->lastname.
            $this->email.
            $this->username.
            $this->password;

    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(?string $voie): self
    {
        $this->voie = $voie;

        return $this;
    }

    public function getLienOpgg(): ?string
    {
        return $this->lienOpgg;
    }

    public function setLienOpgg(?string $lienOpgg): self
    {
        $this->lienOpgg = $lienOpgg;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(?int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, SessionCoaching>
     */
    public function getSessionCoachings(): Collection
    {
        return $this->sessionCoachings;
    }

    public function addSessionCoaching(SessionCoaching $sessionCoaching): self
    {
        if (!$this->sessionCoachings->contains($sessionCoaching)) {
            $this->sessionCoachings->add($sessionCoaching);
            $sessionCoaching->setUser($this);
        }

        return $this;
    }

    public function removeSessionCoaching(SessionCoaching $sessionCoaching): self
    {
        if ($this->sessionCoachings->removeElement($sessionCoaching)) {
            // set the owning side to null (unless already changed)
            if ($sessionCoaching->getUser() === $this) {
                $sessionCoaching->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReservationC>
     */
    public function getReservationCs(): Collection
    {
        return $this->reservationCs;
    }

    public function addReservationC(ReservationC $reservationC): self
    {
        if (!$this->reservationCs->contains($reservationC)) {
            $this->reservationCs->add($reservationC);
            $reservationC->setUser($this);
        }

        return $this;
    }

    public function removeReservationC(ReservationC $reservationC): self
    {
        if ($this->reservationCs->removeElement($reservationC)) {
            // set the owning side to null (unless already changed)
            if ($reservationC->getUser() === $this) {
                $reservationC->setUser(null);
            }
        }

        return $this;
    }

}
