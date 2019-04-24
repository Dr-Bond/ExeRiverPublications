<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Payment;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    private $paymentType;
    private $amount;
    private $book;
    private $user;

    public function setUp()
    {
        $this->paymentType = 'test payment type';
        $this->amount = 40.0;
        $this->book = $this->createBook();
        $this->user = $this->createUser();
    }

    private function createBook()
    {
        $user = new User('firstName','surname');
        return new Book('test book', 'test reference', $user, $user, $user);
    }

    private function createPayment()
    {
        return new Payment($this->book, $this->user, $this->amount, $this->paymentType);
    }

    private function createUser()
    {
        return new User('firstName','surname');
    }

    public function testConstructor()
    {
        $payment = $this->createPayment();

        $this->assertSame($this->book, $payment->getBook());
        $this->assertSame($this->user, $payment->getPaymentMadeBy());
        $this->assertSame($this->amount, $payment->getAmount());
        $this->assertSame($this->paymentType, $payment->getPaymentType());
        $this->assertSame(Payment::PENDING_APPROVAL_STATUS, $payment->getStatus());
    }

    public function testSetBook()
    {
        $book = $this->createBook();
        $payment = $this->createPayment();
        $payment->setBook($book);
        $this->assertEquals($payment->getBook(), $book);
    }

    public function testSetPaymentMadeBy()
    {
        $user = $this->createUser();
        $payment = $this->createPayment();
        $payment->setPaymentMadeBy($user);
        $this->assertEquals($payment->getPaymentMadeBy(), $user);
    }

    public function testSetEditorRating()
    {
        $float = 3.5;
        $payment = $this->createPayment();
        $payment->setAmount($float);
        $this->assertEquals($payment->getAmount(), $float);
    }

    public function testSetPaymentType()
    {
        $string = 'new payment type';
        $payment = $this->createPayment();
        $payment->setPaymentType($string);
        $this->assertEquals($payment->getPaymentType(), $string);
    }

    public function testSetStatus()
    {
        $string = 'new status';
        $payment = $this->createPayment();
        $payment->setStatus($string);
        $this->assertEquals($payment->getStatus(), $string);
    }
}
