<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/seller", name="seller_dashboard")
     */
    public function index(ChannelContextInterface $channelContextIn): Response
    {
        return $this->render('admin/seller.html.twig', [
            'channel' => $channelContextIn->getChannel(),
        ]);
    }
}

