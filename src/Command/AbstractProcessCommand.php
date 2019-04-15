<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

abstract class AbstractProcessCommand
{
    private $book;
    private $user;
    private $feedback;
    private $process;
    private $rating;
    protected $amount;

    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(string $feedback)
    {
        $this->feedback = $feedback;
        return $this;
    }

    public function getProcess(): ?string
    {
        return $this->process;
    }

    public function setProcess(string $process)
    {
        $this->process = $process;
        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating)
    {
        $this->rating = $rating;
        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('feedback', new Assert\NotBlank());
        $metadata->addPropertyConstraint('process', new Assert\NotBlank());
        $metadata->addPropertyConstraint('rating', new Assert\NotBlank());
        $metadata->addConstraint(new Assert\Callback([
            'callback' => 'validatePayment'
        ]));
    }

    public function validatePayment(ExecutionContextInterface $context)
    {
        $user = $this->user;
        $book = $this->book;
        if ($user === $book->getMainReviewer() or $user === $book->getSecondaryReviewer()) {
            if($this->process === Book::REJECTED_STATUS and $this->amount !== null) {
                $context
                    ->buildViolation('Advanced payments cannot be made on rejected books.')
                    ->atPath('amount')
                    ->addViolation()
                ;
                return;
            }
            if($book->getStatus() !== Book::PENDING_SECOND_REVIEW_STATUS and $this->amount !== null) {
                $context
                    ->buildViolation('Advanced payment requires both reviews to be completed.')
                    ->atPath('amount')
                    ->addViolation()
                ;
                return;
            }
            if($book->getStatus() === Book::PENDING_SECOND_REVIEW_STATUS and $this->amount === null and $this->process === Book::ACCEPTED_STATUS) {
                $context
                    ->buildViolation('Advanced payment required.')
                    ->atPath('amount')
                    ->addViolation()
                ;
                return;
            }
        }
        if ($user === $book->getEditor()) {
            if($this->process === Book::REVISION_REQUIRED_STATUS and $this->amount !== null) {
                $context
                    ->buildViolation('Final payments are only to be made on published books.')
                    ->atPath('amount')
                    ->addViolation()
                ;
                return;
            }
            if($this->process === Book::PUBLISHED_STATUS and $this->amount === null) {
                $context
                    ->buildViolation('Published books require a final payment')
                    ->atPath('amount')
                    ->addViolation()
                ;
                return;
            }
        }
    }
}