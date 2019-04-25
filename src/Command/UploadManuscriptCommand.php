<?php

namespace App\Command;

use App\Entity\Book;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class UploadManuscriptCommand
 * @package App\Command
 */
class UploadManuscriptCommand
{
    /**
     * @var null|string
     */
    private $name;
    /**
     * @var null|mixed
     */
    private $location;
    /**
     * @var Book
     */
    private $book;

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
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function setBook(Book $book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('location', new Assert\NotBlank());
    }
}