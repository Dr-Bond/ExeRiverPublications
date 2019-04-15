<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notes")
     */
    private $addedBy;

    /**
     * @ORM\Column(type="string", length=4000)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $noteType;

    const REVIEWER_FEEDBACK_TYPE = 'Reviewer Feedback';
    const EDITOR_FEEDBACK_TYPE = 'Reviewer Feedback';
    const MEETING_NOTE_TYPE = 'Meeting Note';
    const PHONE_CALL_NOTE_TYPE = 'Phone Call Note';
    const PAYMENT_TYPE = 'Payment';

    public function __construct(Book $book, User $addedBy, string $content, string $noteType)
    {
        $this->book = $book;
        $this->addedBy = $addedBy;
        $this->content = $content;
        $this->noteType = $noteType;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): self
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getNoteType(): ?string
    {
        return $this->noteType;
    }

    public function setNoteType(string $noteType): self
    {
        $this->noteType = $noteType;

        return $this;
    }
}
