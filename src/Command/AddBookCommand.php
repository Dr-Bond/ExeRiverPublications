<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class AddBookCommand
{
    private $reference;
    private $name;
    private $author;
    private $agent;
    private $mainReviewer;
    private $secondaryReviewer;

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author)
    {
        $this->author = $author;
        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent)
    {
        $this->agent = $agent;
        return $this;
    }

    public function getMainReviewer(): ?User
    {
        return $this->mainReviewer;
    }

    public function setMainReviewer(?User $mainReviewer)
    {
        $this->mainReviewer = $mainReviewer;
        return $this;
    }

    public function getSecondaryReviewer(): ?User
    {
        return $this->secondaryReviewer;
    }

    public function setSecondaryReviewer(?User $secondaryReviewer)
    {
        $this->secondaryReviewer = $secondaryReviewer;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('reference', new Assert\NotBlank());
        $metadata->addPropertyConstraint('author', new Assert\NotBlank());
        $metadata->addPropertyConstraint('agent', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mainReviewer', new Assert\NotBlank());
    }
}