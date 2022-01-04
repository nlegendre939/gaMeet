<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'date')]
    private $birthdate;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Hotnew::class)]
    private $hotnews;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'user')]
    private $userEvent;

    #[ORM\ManyToMany(targetEntity: Support::class, mappedBy: 'user')]
    private $supports;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ad::class, orphanRemoval: true)]
    private $ads;

    public function __construct()
    {
        $this->hotnews = new ArrayCollection();
        $this->userEvent = new ArrayCollection();
        $this->supports = new ArrayCollection();
        $this->ads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Hotnew[]
     */
    public function getHotnews(): Collection
    {
        return $this->hotnews;
    }

    public function addHotnews(Hotnew $hotnews): self
    {
        if (!$this->hotnews->contains($hotnews)) {
            $this->hotnews[] = $hotnews;
            $hotnews->setUser($this);
        }

        return $this;
    }

    public function removeHotnews(Hotnew $hotnews): self
    {
        if ($this->hotnews->removeElement($hotnews)) {
            // set the owning side to null (unless already changed)
            if ($hotnews->getUser() === $this) {
                $hotnews->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getUserEvent(): Collection
    {
        return $this->userEvent;
    }

    public function addUserEvent(Event $userEvent): self
    {
        if (!$this->userEvent->contains($userEvent)) {
            $this->userEvent[] = $userEvent;
            $userEvent->addUser($this);
        }

        return $this;
    }

    public function removeUserEvent(Event $userEvent): self
    {
        if ($this->userEvent->removeElement($userEvent)) {
            $userEvent->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Support[]
     */
    public function getSupports(): Collection
    {
        return $this->supports;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->supports->contains($support)) {
            $this->supports[] = $support;
            $support->addUser($this);
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        if ($this->supports->removeElement($support)) {
            $support->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setUser($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getUser() === $this) {
                $ad->setUser(null);
            }
        }

        return $this;
    }
}
