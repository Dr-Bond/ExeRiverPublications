<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    const ADVANCED_PAYMENT_TYPE = 'Advanced Payment';
    const FINAL_PAYMENT_TYPE = 'Final Payment';
    const PENDING_APPROVAL_STATUS = 'Pending Approval';
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

    public function __construct(Book $book, User $paymentMadeBy, int $amount, string $paymentType)
    {
        $this->book = $book;
        $this->paymentMadeBy = $paymentMadeBy;
        $this->amount = $amount;
        $this->paymentType = $paymentType;
        $this->status = self::PENDING_APPROVAL_STATUS;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaidOn(): ?\DateTimeInterface
    {
        return $this->paidOn;
    }

    public function setPaidOn(\DateTimeInterface $paidOn): self
    {
        $this->paidOn = $paidOn;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getPaymentMadeBy(): ?User
    {
        return $this->paymentMadeBy;
    }

    public function setPaymentMadeBy(?User $paymentMadeBy): self
    {
        $this->paymentMadeBy = $paymentMadeBy;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function approvePayment(): void
    {
        $this->paidOn = new \DateTime();
        $this->status = self::PAID_STATUS;
    }
}
