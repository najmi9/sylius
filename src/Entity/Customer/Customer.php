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
}
