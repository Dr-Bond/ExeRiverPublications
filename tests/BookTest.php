<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    private $user;
    private $name;
    private $reference;

    public function setUp()
    {
        $this->user = $this->prophesize(User::class);
        $this->name = 'test book';
        $this->reference = 'test reference';
    }

    private function createBook()
    {
        $author = $this->user->reveal();
        $agent = $this->user->reveal();
        $mainReviewer = $this->user->reveal();

        return new Book($this->name, $this->reference, $author, $agent, $mainReviewer);
    }

    private function createUser()
    {
        return new User('test', 'user');
    }

    public function testConstructor()
    {
        $author = $this->user->reveal();
        $agent = $this->user->reveal();
        $mainReviewer = $this->user->reveal();

        $book = $this->createBook();

        $this->assertSame($this->name, $book->getName());
        $this->assertSame($this->reference, $book->getReference());
        $this->assertSame($author, $book->getAuthor());
        $this->assertSame($agent, $book->getAgent());
        $this->assertSame($mainReviewer, $book->getMainReviewer());
    }

    public function testSetName()
    {
        $name = 'new name';
        $book = $this->createBook();
        $book->setName($name);
        $this->assertEquals($book->getName(), $name);
    }

    public function testSetReference()
    {
        $reference = 'new reference';
        $book = $this->createBook();
        $book->setReference($reference);
        $this->assertEquals($book->getReference(), $reference);
    }

    public function testSetStatus()
    {
        $status = 'new status';
        $book = $this->createBook();
        $book->setStatus($status);
        $this->assertEquals($book->getStatus(), $status);
    }

    public function testSetMainReviewerRating()
    {
        $rating = 5;
        $book = $this->createBook();
        $book->setMainReviewerRating($rating);
        $this->assertEquals($book->getMainReviewerRating(), $rating);
    }

    public function testSetSecondaryReviewerRating()
    {
        $rating = 4;
        $book = $this->createBook();
        $book->setSecondaryReviewerRating($rating);
        $this->assertEquals($book->getSecondaryReviewerRating(), $rating);
    }

    public function testSetEditorRating()
    {
        $rating = 3;
        $book = $this->createBook();
        $book->setEditorRating($rating);
        $this->assertEquals($book->getEditorRating(), $rating);
    }

    public function testSetAuthor()
    {
        $user = $this->createUser();
        $book = $this->createBook();
        $book->setAuthor($user);
        $this->assertEquals($book->getAuthor(), $user);
    }

    public function testSetAgent()
    {
        $user = $this->createUser();
        $book = $this->createBook();
        $book->setAgent($user);
        $this->assertEquals($book->getAgent(), $user);
    }

    public function testSetMainReviewer()
    {
        $user = $this->createUser();
        $book = $this->createBook();
        $book->setMainReviewer($user);
        $this->assertEquals($book->getMainReviewer(), $user);
    }

    public function testSetSecondaryReviewer()
    {
        $user = $this->createUser();
        $book = $this->createBook();
        $book->setSecondaryReviewer($user);
        $this->assertEquals($book->getSecondaryReviewer(), $user);
    }

    public function testSetEditor()
    {
        $user = $this->createUser();
        $book = $this->createBook();
        $book->setEditor($user);
        $this->assertEquals($book->getEditor(), $user);
    }

}
