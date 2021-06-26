<?php

declare(strict_types=1);

namespace App\ShippingCalculator;

use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;

class ParcelCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        $parcelSize = $configuration['size'];
        $parcelPrice = $configuration['price'];

        $numberOfPackages = ceil($subject->getUnits()->count() / $parcelSize);

        return (int) ($numberOfPackages * $parcelPrice);
    }

    public function getType(): string
    {
        return 'parcel';
    }
}