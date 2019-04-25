<?php

namespace App\Command;

use App\Entity\Role;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class CreateUserCommand
 * @package App\Command
 */
class CreateUserCommand
{
    /**
     * @var null|string
     */
    private $firstName;
    /**
     * @var null|string
     */
    private $surname;
    /**
     * @var null|string
     */
    private $plainPassword;
    /**
     * @var Role
     */
    private $role;
    /**
     * @var null|string
     */
    private $addressLineOne;
    /**
     * @var null|string
     */
    private $addressLineTwo;
    /**
     * @var null|string
     */
    private $city;
    /**
     * @var null|string
     */
    private $county;
    /**
     * @var null|string
     */
    private $postcode;
    /**
     * @var null|string
     */
    private $country;

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     * @return $this
     */
    public function setFirstName(?string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param null|string $surname
     * @return $this
     */
    public function setSurname(?string $surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param null|string $plainPassword
     * @return $this
     */
    public function setPlainPassword(?string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param null|string $role
     * @return $this
     */
    public function setRole(?string $role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddressLineOne(): ?string
    {
        return $this->addressLineOne;
    }

    /**
     * @param null|string $addressLineOne
     * @return $this
     */
    public function setAddressLineOne(?string $addressLineOne)
    {
        $this->addressLineOne = $addressLineOne;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddressLineTwo(): ?string
    {
        return $this->addressLineTwo;
    }

    /**
     * @param null|string $addressLineTwo
     * @return $this
     */
    public function setAddressLineTwo(?string $addressLineTwo)
    {
        $this->addressLineTwo = $addressLineTwo;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     * @return $this
     */
    public function setCity(?string $city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCounty(): ?string
    {
        return $this->county;
    }

    /**
     * @param null|string $county
     * @return $this
     */
    public function setCounty(?string $county)
    {
        $this->county = $county;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @param null|string $postcode
     * @return $this
     */
    public function setPostcode(?string $postcode)
    {
        $this->postcode = strtoupper($postcode);
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param null|string $country
     * @return $this
     */
    public function setCountry(?string $country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank());
        $metadata->addPropertyConstraint('surname', new Assert\NotBlank());
        $metadata->addPropertyConstraint('plainPassword', new Assert\NotBlank());
        $metadata->addPropertyConstraint('plainPassword', new Assert\Length([
            'min' => 4,
            'minMessage' => 'The password must be at least 4 characters long'
        ]));
        $metadata->addPropertyConstraint('role', new Assert\NotBlank());
        $metadata->addPropertyConstraint('addressLineOne', new Assert\NotBlank());
        $metadata->addPropertyConstraint('city', new Assert\NotBlank());
        $metadata->addPropertyConstraint('county', new Assert\NotBlank());
        $metadata->addPropertyConstraint('postcode', new Assert\NotBlank());
        $metadata->addPropertyConstraint('country', new Assert\NotBlank());
    }
}