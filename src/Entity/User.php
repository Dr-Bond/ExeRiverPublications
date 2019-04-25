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
     * @ORM\OneToOne(targetEntity="App\Entity\Address", mappedBy="user", cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Role", mappedBy="user", orphanRemoval=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="addedBy")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="paymentMadeBy", orphanRemoval=true)
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user", orphanRemoval=true)
     */
    private $notifications;

    /**
     * User constructor.
     * @param $firstName
     * @param $surname
     */
    public function __construct($firstName, $surname)
    {
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->userId = substr(md5(microtime()),rand(0,26),5);
        $this->books = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return User
     */
    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->userId;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return User
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     *
     */
    public function eraseCredentials(): void
    {

    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';
        foreach ($this->roles->getValues() as $role) {
            $roles[] = $role->getRole();
        }

        return array_unique($roles);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->firstName.' '.$this->surname;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

}
