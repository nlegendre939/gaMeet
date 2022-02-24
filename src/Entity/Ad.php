<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdRepository::class)]
class Ad
{

  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
          /* * 
 * @var string|null
 * @Assert\NotBlank()
 * @Assert\Length(min=4, max=45)
 */
   
    #[ORM\Column(type: 'string', length: 45)]
    private $name;

       /* * 
 
     * @var string|null
   * @Assert\NotBlank()
    * @Assert\Length
      *   'min' => 10,
    'max' => 1500,
     'minMessage' => 'La description doit contenir au minimum {{ limit }} caractères',
      'minMessage' => 'La description doit contenir au minimum {{ limit }} caractères',
     */
    #[ORM\Column(type: 'text')]
    private $description;
    

    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $picture;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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
