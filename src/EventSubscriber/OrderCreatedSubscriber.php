<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class OrderCreatedSubscriber implements EventSubscriberInterface
{
    public function onSyliusOrderItemPreCreate(GenericEvent $event)
    {
        $orderItem = $event->getSubject();
       //ToDO
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.order_item.pre_create' => ['onSyliusOrderItemPreCreate'],
        ];
    }
}
