<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $firstName;
    private $surname;

    public function setUp()
    {
        $this->firstName = 'first name';
        $this->surname = 'surname';
    }

    private function createUser()
    {
        return new User($this->firstName,$this->surname);
    }

    public function testConstructor()
    {
        $user = $this->createUser();

        $this->assertSame($this->firstName, $user->getFirstName());
        $this->assertSame($this->surname, $user->getSurname());
    }

    public function testSetUserId()
    {
        $string = 'newuserid';
        $user = $this->createUser();
        $user->setUserId($string);
        $this->assertEquals($user->getUserId(), $string);
    }

    public function testSetPassword()
    {
        $string = 'password';
        $user = $this->createUser();
        $user->setPassword($string);
        $this->assertEquals($user->getPassword(), $string);
    }

    public function testSetFirstName()
    {
        $string = 'new first name';
        $user = $this->createUser();
        $user->setFirstName($string);
        $this->assertEquals($user->getFirstName(), $string);
    }

    public function testSetSurname()
    {
        $string = 'new surname';
        $user = $this->createUser();
        $user->setSurname($string);
        $this->assertEquals($user->getSurname(), $string);
    }
}
