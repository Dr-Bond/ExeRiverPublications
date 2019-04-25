<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * Advanced Payment Type
     */
    const ADVANCED_PAYMENT_TYPE = 'Advanced Payment';
    /**
     * Final Payment Type
     */
    const FINAL_PAYMENT_TYPE = 'Final Payment';
    /**
     * Pending Approval Status
     */
    const PENDING_APPROVAL_STATUS = 'Pending Approval';
    /**
     * Paid Status
     */
    const PAID_STATUS = 'Paid';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */

    private $paidOn;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paymentType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentMadeBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * Payment constructor.
     * @param Book $book
     * @param User $paymentMadeBy
     * @param float $amount
     * @param string $paymentType
     */
    public function __construct(Book $book, User $paymentMadeBy, float $amount, string $paymentType)
    {
        $this->book = $book;
        $this->paymentMadeBy = $paymentMadeBy;
        $this->amount = $amount;
        $this->paymentType = $paymentType;
        $this->status = self::PENDING_APPROVAL_STATUS;
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
    public function getPaidOn(): ?\DateTimeInterface
    {
        return $this->paidOn;
    }

    /**
     * @param \DateTimeInterface $paidOn
     * @return Payment
     */
    public function setPaidOn(\DateTimeInterface $paidOn): self
    {
        $this->paidOn = $paidOn;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Payment
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Payment
     */
    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getPaymentMadeBy(): ?User
    {
        return $this->paymentMadeBy;
    }

    /**
     * @param User|null $paymentMadeBy
     * @return Payment
     */
    public function setPaymentMadeBy(?User $paymentMadeBy): self
    {
        $this->paymentMadeBy = $paymentMadeBy;
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
     * @return Payment
     */
    public function setBook(?Book $book): self
    {
        $this->book = $book;
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
     * @return Payment
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Approves payment by setting paidOn with \DateTime() and sets status to PAID_STATUS
     */
    public function approvePayment(): void
    {
        $this->paidOn = new \DateTime();
        $this->status = self::PAID_STATUS;
    }
}
