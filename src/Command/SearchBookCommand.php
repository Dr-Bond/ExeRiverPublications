<?php

namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SearchBookCommand
{
    private $status;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('status', new Assert\NotBlank());
    }
}