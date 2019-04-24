<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Manuscript;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ManuscriptTest extends TestCase
{
    private $name;
    private $location;
    private $book;

    public function setUp()
    {
        $this->name = 'test name';
        $this->location = 'test location';
        $this->book = $this->createBook();
    }

    private function createBook()
    {
        $user = new User('firstName','surname');
        return new Book('test book', 'test reference', $user, $user, $user);
    }

    private function createManuscript()
    {
        return new Manuscript($this->name, $this->location, $this->book);
    }

    public function testConstructor()
    {
        $manuscript = $this->createManuscript();

        $this->assertSame($this->name, $manuscript->getName());
        $this->assertSame($this->location, $manuscript->getLocation());
        $this->assertSame($this->book, $manuscript->getBook());
    }

    public function testSetName()
    {
        $string = 'new name';
        $manuscript = $this->createManuscript();
        $manuscript->setName($string);
        $this->assertEquals($manuscript->getName(), $string);
    }

    public function testSetLocation()
    {
        $string = 'new location';
        $manuscript = $this->createManuscript();
        $manuscript->setLocation($string);
        $this->assertEquals($manuscript->getLocation(), $string);
    }

    public function testSetStatus()
    {
        $string = 'new status';
        $manuscript = $this->createManuscript();
        $manuscript->setStatus($string);
        $this->assertEquals($manuscript->getStatus(), $string);
    }

    public function testSetUploadedOn()
    {
        $date = new \DateTime();
        $manuscript = $this->createManuscript();
        $manuscript->setUploadedOn($date);
        $this->assertEquals($manuscript->getUploadedOn(), $date);
    }

    public function testSetRevisionNumber()
    {
        $int = 4;
        $manuscript = $this->createManuscript();
        $manuscript->setRevisionNumber($int);
        $this->assertEquals($manuscript->getRevisionNumber(), $int);
    }

    public function testSetBook()
    {
        $book = $this->createBook();
        $manuscript = $this->createManuscript();
        $manuscript->setBook($book);
        $this->assertEquals($manuscript->getBook(), $book);
    }
}
