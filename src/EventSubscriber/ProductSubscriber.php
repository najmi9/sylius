<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\User\ShopUser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class ProductSubscriber implements EventSubscriberInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onSyliusProductPreCreate(GenericEvent $event)
    {
        $product = $event->getSubject();

        /** @var ShopUser $user */
        $user = $this->security->getUser();

        if ($user instanceof ShopUser) {
            $store = $user->getSeller()->getStore();

            if (false) {
                throw new NotFoundHttpException("Store Not Found");
            }
    
            $product->setStore($store);
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.product.pre_create' => 'onSyliusProductPreCreate',
        ];
    }
}
