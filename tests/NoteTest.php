<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Note;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class NoteTest extends TestCase
{
    private $content;
    private $noteType;
    private $book;
    private $user;

    public function setUp()
    {
        $this->content = 'test content';
        $this->noteType = 'test note type';
        $this->book = $this->createBook();
        $this->user = $this->createUser();
    }

    private function createBook()
    {
        $user = new User('firstName','surname');
        return new Book('test book', 'test reference', $user, $user, $user);
    }

    private function createNote()
    {
        return new Note($this->book, $this->user, $this->content, $this->noteType);
    }

    private function createUser()
    {
        return new User('firstName','surname');
    }

    public function testConstructor()
    {
        $note = $this->createNote();

        $this->assertSame($this->book, $note->getBook());
        $this->assertSame($this->user, $note->getAddedBy());
        $this->assertSame($this->content, $note->getContent());
        $this->assertSame($this->noteType, $note->getNoteType());
    }

    public function testSetBook()
    {
        $book = $this->createBook();
        $note = $this->createNote();
        $note->setBook($book);
        $this->assertEquals($note->getBook(), $book);
    }

    public function testSetAddedBy()
    {
        $user = $this->createUser();
        $note = $this->createNote();
        $note->setAddedBy($user);
        $this->assertEquals($note->getAddedBy(), $user);
    }

    public function testSetContent()
    {
        $string = 'new content';
        $note = $this->createNote();
        $note->setContent($string);
        $this->assertEquals($note->getContent(), $string);
    }

    public function testSetNoteType()
    {
        $string = 'new note type';
        $note = $this->createNote();
        $note->setNoteType($string);
        $this->assertEquals($note->getNoteType(), $string);
    }
}
