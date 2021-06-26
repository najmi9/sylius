<?php

declare(strict_types=1);

namespace App\Factory;

use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;

final class ProductFactory implements ProductFactoryInterface
{
    /** @var ProductFactoryInterface  */
    private $decoratedFactory;

    public function __construct(ProductFactoryInterface $factory)
    {
        $this->decoratedFactory = $factory;
    }

    public function createNew(): ProductInterface
    {
        return $this->decoratedFactory->createNew();
    }

    public function createWithVariant(): ProductInterface
    {
        return $this->decoratedFactory->createWithVariant();
    }

    public function createDisabled(): ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->decoratedFactory->createWithVariant();

        $product->setEnabled(false);

        return $product;
    }
}