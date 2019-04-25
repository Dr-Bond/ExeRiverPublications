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

    /**
     * Reviewer Feedback Note Type
     */
    const REVIEWER_FEEDBACK_TYPE = 'Reviewer Feedback';
    /**
     * Editor Feedback Note Type
     */
    const EDITOR_FEEDBACK_TYPE = 'Editor Feedback';
    /**
     * Meeting Note Note Type
     */
    const MEETING_NOTE_TYPE = 'Meeting Note';
    /**
     * Phone Call Note Note Type
     */
    const PHONE_CALL_NOTE_TYPE = 'Phone Call Note';

    /**
     * Note constructor.
     * @param Book $book
     * @param User $addedBy
     * @param string $content
     * @param string $noteType
     */
    public function __construct(Book $book, User $addedBy, string $content, string $noteType)
    {
        $this->book = $book;
        $this->addedBy = $addedBy;
        $this->content = $content;
        $this->noteType = $noteType;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return Note
     */
    public function setBook(?Book $book): self
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    /**
     * @param User|null $addedBy
     * @return Note
     */
    public function setAddedBy(?User $addedBy): self
    {
        $this->addedBy = $addedBy;
        return $this;
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
     * @return Note
     */
    public function setContent(string $content): self
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
     * @return Note
     */
    public function setNoteType(string $noteType): self
    {
        $this->noteType = $noteType;
        return $this;
    }
}
