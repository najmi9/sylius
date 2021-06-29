<?php

declare(strict_types=1);

namespace App\Infrastructure\Search\Services;

use App\Entity\Product\Product;
use App\Infrastructure\Search\Model\Product as ProductModel;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EntityToModelService
{
    private NormalizerInterface $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @return array|ProductModel
     */
    public function product(Product $product, bool $isNormalized = true, bool $isForTypesense = false)
    {
        $model = new ProductModel();


        if ($isNormalized) {
            return $this->normalizer->normalize($model);
        }

        return $model;
    }

    public function user()
    {

    }
}