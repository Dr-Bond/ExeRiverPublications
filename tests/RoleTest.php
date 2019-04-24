<?php

namespace App\Tests;

use App\Entity\Role;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    private $role;
    private $user;

    public function setUp()
    {
        $this->role = 'test role';
        $this->user = $this->createUser();
    }

    private function createRole()
    {
        return new Role($this->user, $this->role);
    }

    private function createUser()
    {
        return new User('firstName','surname');
    }

    public function testConstructor()
    {
        $role = $this->createRole();

        $this->assertSame($this->role, $role->getRole());
        $this->assertSame($this->user, $role->getUser());
    }

    public function testSetUser()
    {
        $user = $this->createUser();
        $role = $this->createRole();
        $role->setUser($user);
        $this->assertEquals($role->getUser(), $user);
    }

    public function testSetEditorRating()
    {
        $string = 'new role';
        $role = $this->createRole();
        $role->setRole($string);
        $this->assertEquals($role->getRole(), $string);
    }
}
