<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\CustomerBundle\Form\Type\CustomerProfileType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CustomerProfileTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Adding new fields works just like in the parent form type.
            ->add('secondaryPhoneNumber', TextType::class, [
                'required' => false,
                'label' => 'secondary_phone_number',
            ])
            // To remove a field from a form simply call ->remove(`fieldName`).
            ->remove('gender')
            // You can change the label by adding again the same field with a changed `label` parameter.
            ->add('lastName', TextType::class, [
                'label' => 'Surname',
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [CustomerProfileType::class];
    }
}