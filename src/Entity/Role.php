<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Role
{
    /**
     * Roles: ID = ROLE_ADMIN and Desc = Admin
     */
    const ROLE_ADMIN = ['id' => 'ROLE_ADMIN', 'desc' => 'Admin'];
    /**
     * Roles: ID = ROLE_AGENT and Desc = Agent
     */
    const ROLE_AGENT = ['id' => 'ROLE_AGENT', 'desc' => 'Agent'];
    /**
     * Roles: ID = ROLE_AUTHOR and Desc = Author
     */
    const ROLE_AUTHOR = ['id' => 'ROLE_AUTHOR', 'desc' => 'Author'];
    /**
     * Roles: ID = ROLE_EDITOR and Desc = Editor
     */
    const ROLE_EDITOR = ['id' => 'ROLE_EDITOR', 'desc' => 'Editor'];
    /**
     * Roles: ID = ROLE_REVIEWER and Desc = Reviewer
     */
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

    /**
     * Role constructor.
     * @param User $user
     * @param string $role
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return user|null
     */
    public function getUser(): ?user
    {
        return $this->user;
    }

    /**
     * @param user|null $user
     * @return Role
     */
    public function setUser(?user $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return Role
     */
    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}
