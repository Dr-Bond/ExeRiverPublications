<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class AddBookCommand
 * @package App\Command
 */
class AddBookCommand
{
    /**
     * @var null|string
     */
    private $reference;
    /**
     * @var null|string
     */
    private $name;
    /**
     * @var User
     */
    private $author;
    /**
     * @var User
     */
    private $agent;
    /**
     * @var User
     */
    private $mainReviewer;
    /**
     * @var User
     */
    private $secondaryReviewer;

    /**
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param null|string $reference
     * @return $this
     */
    public function setReference(?string $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return $this
     */
    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     * @return $this
     */
    public function setAuthor(?User $author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getAgent(): ?User
    {
        return $this->agent;
    }

    /**
     * @param User|null $agent
     * @return $this
     */
    public function setAgent(?User $agent)
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getMainReviewer(): ?User
    {
        return $this->mainReviewer;
    }

    /**
     * @param User|null $mainReviewer
     * @return $this
     */
    public function setMainReviewer(?User $mainReviewer)
    {
        $this->mainReviewer = $mainReviewer;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getSecondaryReviewer(): ?User
    {
        return $this->secondaryReviewer;
    }

    /**
     * @param User|null $secondaryReviewer
     * @return $this
     */
    public function setSecondaryReviewer(?User $secondaryReviewer)
    {
        $this->secondaryReviewer = $secondaryReviewer;
        return $this;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('reference', new Assert\NotBlank());
        $metadata->addPropertyConstraint('author', new Assert\NotBlank());
        $metadata->addPropertyConstraint('agent', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mainReviewer', new Assert\NotBlank());
    }
}