<?php

namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CreateUserCommand
{
    private $firstName;
    private $surname;
    private $plainPassword;
    private $addressLineOne;
    private $addressLineTwo;
    private $city;
    private $county;
    private $postcode;
    private $country;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getAddressLineOne(): ?string
    {
        return $this->addressLineOne;
    }

    public function setAddressLineOne(string $addressLineOne)
    {
        $this->addressLineOne = $addressLineOne;
        return $this;
    }

    public function getAddressLineTwo(): ?string
    {
        return $this->addressLineTwo;
    }

    public function setAddressLineTwo(string $addressLineTwo)
    {
        $this->addressLineTwo = $addressLineTwo;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(string $county)
    {
        $this->county = $county;
        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank());
        $metadata->addPropertyConstraint('surname', new Assert\NotBlank());
        $metadata->addPropertyConstraint('plainPassword', new Assert\NotBlank());
        $metadata->addPropertyConstraint('plainPassword', new Assert\Length([
            'min' => 5,
            'minMessage' => 'The password must be at least 4 characters long'
        ]));
    }
}