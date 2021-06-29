<?php

declare(strict_types=1);

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('new')
            ->setLabel('MarketPlace')
        ;

        $newSubmenu
            ->addChild('sellers', [
                'route' => 'app_admin_sellers',
            ])
            ->setAttribute('type', 'link')
            ->setLabel('Sellers')
            ->setLabelAttribute('icon', 'users')
        ;
        

        $newSubmenu
            ->addChild('stores', [
                'route' => 'app_admin_stores',
            ])
            ->setLabel('Stores')
            ->setAttribute('type', 'link')
            ->setLabelAttribute('icon', 'industry')
        ;
    }
}