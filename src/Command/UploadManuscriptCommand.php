<?php

namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class UploadManuscriptCommand
{
    private $reference;
    private $name;
    private $location;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location)
    {
        $this->location = $location;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('reference', new Assert\NotBlank());
        $metadata->addPropertyConstraint('location', new Assert\NotBlank());
    }
}