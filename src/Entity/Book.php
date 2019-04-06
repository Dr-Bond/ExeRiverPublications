<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    const PENDING_MANUSCRIPT_STATUS = 'Pending Manuscript';

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
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainReviewer;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    private $mainReviewerComments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mainReviewerRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="books")
     */
    private $secondaryReviewer;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    private $secondaryReviewerComments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $secondaryReviewerRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="books")
     */
    private $editor;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    private $editorComments;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $paymentAmount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paidOn;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manuscript", mappedBy="book", orphanRemoval=true)
     */
    private $manuscripts;

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

    public function getAuthor(): ?user
    {
        return $this->author;
    }

    public function setAuthor(?user $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getAgent(): ?user
    {
        return $this->agent;
    }

    public function setAgent(?user $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getMainReviewer(): ?user
    {
        return $this->mainReviewer;
    }

    public function setMainReviewer(?user $mainReviewer): self
    {
        $this->mainReviewer = $mainReviewer;

        return $this;
    }

    public function getMainReviewerComments(): ?string
    {
        return $this->mainReviewerComments;
    }

    public function setMainReviewerComments(?string $mainReviewerComments): self
    {
        $this->mainReviewerComments = $mainReviewerComments;

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

    public function getSecondaryReviewer(): ?user
    {
        return $this->secondaryReviewer;
    }

    public function setSecondaryReviewer(?user $secondaryReviewer): self
    {
        $this->secondaryReviewer = $secondaryReviewer;

        return $this;
    }

    public function getSecondaryReviewerComments(): ?string
    {
        return $this->secondaryReviewerComments;
    }

    public function setSecondaryReviewerComments(?string $secondaryReviewerComments): self
    {
        $this->secondaryReviewerComments = $secondaryReviewerComments;

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

    public function getEditor(): ?user
    {
        return $this->editor;
    }

    public function setEditor(?user $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getEditorComments(): ?string
    {
        return $this->editorComments;
    }

    public function setEditorComments(?string $editorComments): self
    {
        $this->editorComments = $editorComments;

        return $this;
    }

    public function getPaymentAmount(): ?float
    {
        return $this->paymentAmount;
    }

    public function setPaymentAmount(?float $paymentAmount): self
    {
        $this->paymentAmount = $paymentAmount;

        return $this;
    }

    public function getPaidOn(): ?\DateTimeInterface
    {
        return $this->paidOn;
    }

    public function setPaidOn(?\DateTimeInterface $paidOn): self
    {
        $this->paidOn = $paidOn;

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

    public function removeManuscript(Manuscript $manuscript): self
    {
        if ($this->manuscripts->contains($manuscript)) {
            $this->manuscripts->removeElement($manuscript);
            if ($manuscript->getBook() === $this) {
                $manuscript->setBook(null);
            }
        }

        return $this;
    }
}
