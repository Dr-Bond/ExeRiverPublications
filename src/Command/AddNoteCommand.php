<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class AddNoteCommand
{
    private $book;
    private $user;
    private $content;
    private $noteType;

    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function getNoteType(): ?string
    {
        return $this->noteType;
    }

    public function setNoteType(string $noteType)
    {
        $this->noteType = $noteType;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('content', new Assert\NotBlank());
        $metadata->addPropertyConstraint('noteType', new Assert\NotBlank());
    }
}