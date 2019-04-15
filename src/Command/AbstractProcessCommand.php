<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

abstract class AbstractProcessCommand
{
    private $book;
    private $user;
    private $feedback;
    private $process;
    private $rating;

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

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(string $feedback)
    {
        $this->feedback = $feedback;
        return $this;
    }

    public function getProcess(): ?string
    {
        return $this->process;
    }

    public function setProcess(string $process)
    {
        $this->process = $process;
        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating)
    {
        $this->rating = $rating;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('feedback', new Assert\NotBlank());
        $metadata->addPropertyConstraint('process', new Assert\NotBlank());
        $metadata->addPropertyConstraint('rating', new Assert\NotBlank());
    }
}