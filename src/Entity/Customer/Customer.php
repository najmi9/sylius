<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
use Sylius\Component\Core\Model\CustomerInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer implements CustomerInterface
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */ 
    private $secondaryPhoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publicIP;

    /**
     * @ORM\Column(type="array")
     */
    private $location = [];

    /**
     * @ORM\Column(type="array")
     */
    private $lastProducts = [];

    /**
     * Get the value of secondaryPhoneNumber
     */ 
    public function getSecondaryPhoneNumber(): ?string
    {
        return $this->secondaryPhoneNumber;
    }

    /**
     * Set the value of secondaryPhoneNumber
     *
     * @return  self
     */ 
    public function setSecondaryPhoneNumber(string $secondaryPhoneNumber): self
    {
        $this->secondaryPhoneNumber = $secondaryPhoneNumber;

        return $this;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getPublicIP(): ?string
    {
        return $this->publicIP;
    }

    public function setPublicIP(?string $publicIP): self
    {
        $this->publicIP = $publicIP;

        return $this;
    }

    public function getLocation(): ?array
    {
        return $this->location;
    }

    public function setLocation(array $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getLastProducts(): ?array
    {
        return $this->lastProducts;
    }

    public function setLastProducts(array $lastProducts): self
    {
        $this->lastProducts = $lastProducts;

        return $this;
    }
}
