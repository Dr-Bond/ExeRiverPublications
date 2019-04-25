<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class AssignEditorCommand
 * @package App\Command
 */
class AssignEditorCommand
{
    /**
     * @var Book
     */
    private $book;
    /**
     * @var User
     */
    private $editor;

    /**
     * AssignEditorCommand constructor.
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @return User|null
     */
    public function getEditor(): ?User
    {
        return $this->editor;
    }

    /**
     * @param User $editor
     * @return $this
     */
    public function setEditor(User $editor)
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('editor', new Assert\NotBlank());
    }
}