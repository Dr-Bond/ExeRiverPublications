<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"userId"}, message="There is already an account with this userId")
 */
class User implements UserInterface
{
    const ROLE_ADMIN = ['id' => 'ROLE_ADMIN', 'desc' => 'Admin'];
    const ROLE_AGENT = ['id' => 'ROLE_AGENT', 'desc' => 'Agent'];
    const ROLE_AUTHOR = ['id' => 'ROLE_AUTHOR', 'desc' => 'Author'];
    const ROLE_EDITOR = ['id' => 'ROLE_EDITOR', 'desc' => 'Editor'];
    const ROLE_REVIEWER = ['id' => 'ROLE_REVIEWER', 'desc' => 'Reviewer'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $userId;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="author", orphanRemoval=true)
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Role", mappedBy="roles", orphanRemoval=true)
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address", mappedBy="user", cascade={"persist", "remove"})
     */
    private $address;

    public function __construct($firstName, $surname)
    {
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->userId = substr(md5(microtime()),rand(0,26),5);
        $this->books = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->userId;
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * Return null - salt not used in password creation
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        return null;
    }
    /**
     * Clear plain password.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

}
