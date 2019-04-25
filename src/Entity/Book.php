<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * Pending Manuscript Status
     */
    const PENDING_MANUSCRIPT_STATUS = 'Pending Manuscript';
    /**
     * Pending Review Status
     */
    const PENDING_REVIEW_STATUS = 'Pending Review';
    /**
     * Pending Secondary Review Status
     */
    const PENDING_SECOND_REVIEW_STATUS = 'Pending Secondary Review';
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
     * Pending Editor Review Status
     */
    const PENDING_EDITOR_REVIEW_STATUS = 'Pending Editor Review';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdOn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainReviewer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mainReviewerRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     */
    private $secondaryReviewer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $secondaryReviewerRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     */
    private $editor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manuscript", mappedBy="book", orphanRemoval=true)
     */
    private $manuscripts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="book", orphanRemoval=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="book", orphanRemoval=true)
     */
    private $payments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $editorRating;

    /**
     * Book constructor.
     * @param string $name
     * @param string $reference
     * @param User $author
     * @param User $agent
     * @param User $mainReviewer
     */
    public function __construct(string $name, string $reference, User $author, User $agent, User $mainReviewer)
    {
        $this->name = $name;
        $this->reference = $reference;
        $this->author = $author;
        $this->agent = $agent;
        $this->mainReviewer = $mainReviewer;
        $this->createdOn = new \Datetime;
        $this->status = self::PENDING_MANUSCRIPT_STATUS;
        $this->manuscripts = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTimeInterface $createdOn
     * @return Book
     */
    public function setCreatedOn(\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
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
     * @return Book
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
     * @return Book
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Book
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     * @return Book
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getAgent(): ?User
    {
        return $this->agent;
    }

    /**
     * @param User|null $agent
     * @return Book
     */
    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getMainReviewer(): ?User
    {
        return $this->mainReviewer;
    }

    /**
     * @param user|null $mainReviewer
     * @return Book
     */
    public function setMainReviewer(?user $mainReviewer): self
    {
        $this->mainReviewer = $mainReviewer;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMainReviewerRating(): ?int
    {
        return $this->mainReviewerRating;
    }

    /**
     * @param int|null $mainReviewerRating
     * @return Book
     */
    public function setMainReviewerRating(?int $mainReviewerRating): self
    {
        $this->mainReviewerRating = $mainReviewerRating;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getSecondaryReviewer(): ?User
    {
        return $this->secondaryReviewer;
    }

    /**
     * @param User|null $secondaryReviewer
     * @return Book
     */
    public function setSecondaryReviewer(?User $secondaryReviewer): self
    {
        $this->secondaryReviewer = $secondaryReviewer;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSecondaryReviewerRating(): ?int
    {
        return $this->secondaryReviewerRating;
    }

    /**
     * @param int|null $secondaryReviewerRating
     * @return Book
     */
    public function setSecondaryReviewerRating(?int $secondaryReviewerRating): self
    {
        $this->secondaryReviewerRating = $secondaryReviewerRating;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getEditor(): ?User
    {
        return $this->editor;
    }

    /**
     * @param User|null $editor
     * @return Book
     */
    public function setEditor(?User $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return Collection|Manuscript[]
     */
    public function getManuscripts(): Collection
    {
        return $this->manuscripts;
    }

    /**
     * @param Manuscript $manuscript
     * @return Book
     */
    public function addManuscript(Manuscript $manuscript): self
    {
        if (!$this->manuscripts->contains($manuscript)) {
            $this->manuscripts[] = $manuscript;
            $manuscript->setBook($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int|null
     * Counts the number of manuscripts attached to the book.
     */
    public function revisionCount(): ?int
    {
        return   count($this->getManuscripts());
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * @param User $user
     * @param string $status
     * @param int $rating
     * Updates the book with the review status and updates the manuscripts with an updated status but skips any which already have a rejection status.
     */
    public function review(User $user, string $status, int $rating)
    {
        if($status !== self::REJECTED_STATUS) {
            $complete = false;
            if ($user === $this->mainReviewer) {
                if ($this->secondaryReviewerRating !== null) {
                    $complete = true;
                }
            } elseif ($user === $this->secondaryReviewer) {
                if ($this->mainReviewerRating !== null) {
                    $complete = true;
                }
            }
            if ($complete === false) {
                $status = self::PENDING_SECOND_REVIEW_STATUS;
            }
        }

        $this->status = $status;
        if ($user === $this->mainReviewer) {
            $this->mainReviewerRating = $rating;
        } elseif ($user === $this->secondaryReviewer) {
            $this->secondaryReviewerRating = $rating;
        } else {
            throw new NotFoundHttpException("Not an assigned reviewer");
        }
    }

    /**
     * @param $status
     * Updates the book status along with the status of the attached manuscripts, skipping any which have been rejected.
     */
    public function processManuscripts($status)
    {
        foreach ($this->manuscripts as $manuscript) {
            if($manuscript->getStatus() !== $status and $manuscript->getStatus() !== Manuscript::REJECTED_STATUS) {
                if($status == self::PUBLISHED_STATUS and $manuscript->getStatus() !== Manuscript::REVISION_REQUIRED_STATUS) {
                    $manuscript->setStatus(Manuscript::PUBLISHED_STATUS);
                } elseif($status == self::REVISION_REQUIRED_STATUS) {
                    $manuscript->setStatus(Manuscript::REVISION_REQUIRED_STATUS);
                } else {
                    $manuscript->setStatus(Manuscript::REJECTED_STATUS);
                }

            }
        }
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * @return int|null
     */
    public function getEditorRating(): ?int
    {
        return $this->editorRating;
    }

    /**
     * @param int|null $editorRating
     * @return Book
     */
    public function setEditorRating(?int $editorRating): self
    {
        $this->editorRating = $editorRating;
        return $this;
    }

}
