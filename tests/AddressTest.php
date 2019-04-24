<?php

namespace App\Tests;

use App\Entity\Address;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    private $addressLineOne;
    private $city;
    private $county;
    private $postcode;
    private $country;

    public function setUp()
    {
        $this->addressLineOne = 'test book';
        $this->city = 'Exeter';
        $this->county = 'Devon';
        $this->postcode = 'EX497YN';
        $this->country = 'UK';
    }

    private function createUser()
    {
        return new User('test', 'user');
    }

    private function createAddress()
    {
        return new Address($this->createUser(),$this->addressLineOne, $this->city, $this->county, $this->postcode, $this->country);
    }

    public function testConstructor()
    {
        $address = $this->createAddress();

        $this->assertSame($this->addressLineOne, $address->getAddressLineOne());
        $this->assertSame($this->city, $address->getCity());
        $this->assertSame($this->county, $address->getCounty());
        $this->assertSame($this->postcode, $address->getPostcode());
        $this->assertSame($this->country, $address->getCountry());
    }

    public function testSetUser()
    {
        $user = $this->createUser();
        $address = $this->createAddress();
        $address->setUser($user);
        $this->assertEquals($address->getUser(), $user);
    }

    public function testSetAddressLineOne()
    {
        $string = 'line one';
        $address = $this->createAddress();
        $address->setAddressLineOne($string);
        $this->assertEquals($address->getAddressLineOne(), $string);
    }

    public function testSetAddressLineTwo()
    {
        $string = 'line two';
        $address = $this->createAddress();
        $address->setAddressLineTwo($string);
        $this->assertEquals($address->getAddressLineTwo(), $string);
    }

    public function testSetCity()
    {
        $string = 'city';
        $address = $this->createAddress();
        $address->setCity($string);
        $this->assertEquals($address->getCity(), $string);
    }

    public function testSetCounty()
    {
        $string = 'county';
        $address = $this->createAddress();
        $address->setCounty($string);
        $this->assertEquals($address->getCounty(), $string);
    }

    public function testSetPostcode()
    {
        $string = 'postcode';
        $address = $this->createAddress();
        $address->setPostcode($string);
        $this->assertEquals($address->getPostcode(), $string);
    }

    public function testSetCountry()
    {
        $string = 'country';
        $address = $this->createAddress();
        $address->setCountry($string);
        $this->assertEquals($address->getCountry(), $string);
    }
}
