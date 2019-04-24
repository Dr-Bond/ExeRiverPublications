<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManuscriptRepository")
 */
class Manuscript
{
    const PENDING_REVIEW = 'Pending Review';
    const ACCEPTED_STATUS = 'Accepted';
    const REJECTED_STATUS = 'Rejected';
    const REVISION_REQUIRED_STATUS = 'Revision Required';
    const PUBLISHED_STATUS = 'Published';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadedOn;

    /**
     * @ORM\Column(type="integer")
     */
    private $revisionNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\book", inversedBy="manuscripts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    public function __construct(string $name, string $location, Book $book)
    {
        $revision = $book->revisionCount();

        $this->reference = str_replace(' ', '-', $book->getName()).'_#RV'.$revision;
        $this->name = $name;
        $this->location = $location;
        $this->book = $book;
        $this->revisionNumber = $revision;
        $this->status = self::PENDING_REVIEW;
        $this->uploadedOn = new \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getUploadedOn(): ?\DateTimeInterface
    {
        return $this->uploadedOn;
    }

    public function setUploadedOn(\DateTimeInterface $uploadedOn): self
    {
        $this->uploadedOn = $uploadedOn;
        return $this;
    }

    public function getRevisionNumber(): ?int
    {
        return $this->revisionNumber;
    }

    public function setRevisionNumber(int $revisionNumber): self
    {
        $this->revisionNumber = $revisionNumber;
        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;
        return $this;
    }

}
