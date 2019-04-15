<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class AssignEditorCommand
{
    private $book;
    private $editor;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getEditor(): ?User
    {
        return $this->editor;
    }

    public function setEditor(User $editor)
    {
        $this->editor = $editor;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('editor', new Assert\NotBlank());
    }
}