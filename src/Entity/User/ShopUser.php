<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\Seller;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShopUser as BaseShopUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shop_user")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class ShopUser extends BaseShopUser
{
    /**
     * @ORM\OneToOne(targetEntity=Seller::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $seller;

    public function getAvatar()
    {
    }

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function setSeller(Seller $seller): self
    {
        // set the owning side of the relation if necessary
        if ($seller->getUser() !== $this) {
            $seller->setUser($this);
        }

        $this->seller = $seller;

        return $this;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
