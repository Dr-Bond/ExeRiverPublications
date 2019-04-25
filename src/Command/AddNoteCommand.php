<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class AddNoteCommand
 * @package App\Command
 */
class AddNoteCommand
{
    /**
     * @var Book
     */
    private $book;
    /**
     * @var User
     */
    private $user;
    /**
     * @var null|string
     */
    private $content;
    /**
     * @var null|string
     */
    private $noteType;

    /**
     * AddNoteCommand constructor.
     * @param Book $book
     * @param User $user
     */
    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getNoteType(): ?string
    {
        return $this->noteType;
    }

    /**
     * @param string $noteType
     * @return $this
     */
    public function setNoteType(string $noteType)
    {
        $this->noteType = $noteType;
        return $this;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('content', new Assert\NotBlank());
        $metadata->addPropertyConstraint('noteType', new Assert\NotBlank());
    }
}