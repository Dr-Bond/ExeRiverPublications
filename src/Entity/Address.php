<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressLineOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressLineTwo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $county;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Address constructor.
     * @param User $user
     * @param string $addressLineOne
     * @param string $city
     * @param string $county
     * @param string $postcode
     * @param string $country
     */
    public function __construct(User $user, string $addressLineOne, string $city, string $county, string $postcode, string $country)
    {
        $this->user = $user;
        $this->addressLineOne = $addressLineOne;
        $this->city = $city;
        $this->county = $county;
        $this->postcode = $postcode;
        $this->country = $country;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getAddressLineOne(): ?string
    {
        return $this->addressLineOne;
    }

    /**
     * @param string $addressLineOne
     * @return Address
     */
    public function setAddressLineOne(string $addressLineOne): self
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
     * @return Address
     */
    public function setAddressLineTwo(?string $addressLineTwo): self
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
     * @param string $city
     * @return Address
     */
    public function setCity(string $city): self
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
     * @param string $county
     * @return Address
     */
    public function setCounty(string $county): self
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
     * @param string $postcode
     * @return Address
     */
    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;
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
     * @param string $country
     * @return Address
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Address
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
