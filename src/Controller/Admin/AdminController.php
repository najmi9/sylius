<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="app_admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/sellers", name="sellers", methods={"GET"})
     */
    public function sellers(ChannelContextInterface $channelContextIn): Response
    {
        return $this->render('admin/sellers.html.twig', [
            'channel' => $channelContextIn->getChannel(),
        ]);
    }

    /**
     * @Route("/stores", name="stores", methods={"GET"})
     */
    public function stores(ChannelContextInterface $channelContextIn): Response
    {
        return $this->render('admin/sellers.html.twig', [
            'channel' => $channelContextIn->getChannel(),
        ]);
    }
}

