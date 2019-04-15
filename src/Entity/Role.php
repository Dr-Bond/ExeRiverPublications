<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Role
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
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="roles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
