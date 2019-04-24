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
    const PENDING_MANUSCRIPT_STATUS = 'Pending Manuscript';
    const PENDING_REVIEW_STATUS = 'Pending Review';
    const PENDING_SECOND_REVIEW_STATUS = 'Pending Secondary Review';
    const ACCEPTED_STATUS = 'Accepted';
    const REJECTED_STATUS = 'Rejected';
    const REVISION_REQUIRED_STATUS = 'Revision Required';
    const PUBLISHED_STATUS = 'Published';
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getMainReviewer(): ?User
    {
        return $this->mainReviewer;
    }

    public function setMainReviewer(?user $mainReviewer): self
    {
        $this->mainReviewer = $mainReviewer;

        return $this;
    }

    public function getMainReviewerRating(): ?int
    {
        return $this->mainReviewerRating;
    }

    public function setMainReviewerRating(?int $mainReviewerRating): self
    {
        $this->mainReviewerRating = $mainReviewerRating;

        return $this;
    }

    public function getSecondaryReviewer(): ?User
    {
        return $this->secondaryReviewer;
    }

    public function setSecondaryReviewer(?User $secondaryReviewer): self
    {
        $this->secondaryReviewer = $secondaryReviewer;

        return $this;
    }

    public function getSecondaryReviewerRating(): ?int
    {
        return $this->secondaryReviewerRating;
    }

    public function setSecondaryReviewerRating(?int $secondaryReviewerRating): self
    {
        $this->secondaryReviewerRating = $secondaryReviewerRating;

        return $this;
    }

    public function getEditor(): ?User
    {
        return $this->editor;
    }

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

    public function addManuscript(Manuscript $manuscript): self
    {
        if (!$this->manuscripts->contains($manuscript)) {
            $this->manuscripts[] = $manuscript;
            $manuscript->setBook($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

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

    public function getEditorRating(): ?int
    {
        return $this->editorRating;
    }

    public function setEditorRating(?int $editorRating): self
    {
        $this->editorRating = $editorRating;

        return $this;
    }

}
