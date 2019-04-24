<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Notification;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    private $content;
    private $book;
    private $user;

    public function setUp()
    {
        $this->content = 'test content';
        $this->book = $this->createBook();
        $this->user = $this->createUser();
    }

    private function createBook()
    {
        $user = new User('firstName','surname');
        return new Book('test book', 'test reference', $user, $user, $user);
    }

    private function createNotification()
    {
        return new Notification($this->user, $this->content, $this->book);
    }

    private function createUser()
    {
        return new User('firstName','surname');
    }

    public function testConstructor()
    {
        $notification = $this->createNotification();

        $this->assertSame($this->book, $notification->getBook());
        $this->assertSame($this->user, $notification->getUser());
        $this->assertSame($this->content, $notification->getContent());
    }

    public function testSetBook()
    {
        $book = $this->createBook();
        $notification = $this->createNotification();
        $notification->setBook($book);
        $this->assertEquals($notification->getBook(), $book);
    }

    public function testSetUser()
    {
        $user = $this->createUser();
        $notification = $this->createNotification();
        $notification->setUser($user);
        $this->assertEquals($notification->getUser(), $user);
    }

    public function testSetContent()
    {
        $string = 'new content';
        $notification = $this->createNotification();
        $notification->setContent($string);
        $this->assertEquals($notification->getContent(), $string);
    }

    public function testSetCreatedOn()
    {
        $date = new \DateTime();
        $notification = $this->createNotification();
        $notification->setCreatedOn($date);
        $this->assertEquals($notification->getCreatedOn(), $date);
    }
}
