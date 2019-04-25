<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManuscriptRepository")
 */
class Manuscript
{
    /**
     * Pending Review Status
     */
    const PENDING_REVIEW = 'Pending Review';
    /**
     * Accepted Status
     */
    const ACCEPTED_STATUS = 'Accepted';
    /**
     * Rejected Status
     */
    const REJECTED_STATUS = 'Rejected';
    /**
     * Revision Required Status
     */
    const REVISION_REQUIRED_STATUS = 'Revision Required';
    /**
     * Published Status
     */
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

    /**
     * Manuscript constructor.
     * @param string $name
     * @param string $location
     * @param Book $book
     */
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Manuscript
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Manuscript
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
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
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Manuscript
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUploadedOn(): ?\DateTimeInterface
    {
        return $this->uploadedOn;
    }

    /**
     * @param \DateTimeInterface $uploadedOn
     * @return Manuscript
     */
    public function setUploadedOn(\DateTimeInterface $uploadedOn): self
    {
        $this->uploadedOn = $uploadedOn;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRevisionNumber(): ?int
    {
        return $this->revisionNumber;
    }

    /**
     * @param int $revisionNumber
     * @return Manuscript
     */
    public function setRevisionNumber(int $revisionNumber): self
    {
        $this->revisionNumber = $revisionNumber;
        return $this;
    }

    /**
     * @return Book|null
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * @param Book|null $book
     * @return Manuscript
     */
    public function setBook(?Book $book): self
    {
        $this->book = $book;
        return $this;
    }

}
