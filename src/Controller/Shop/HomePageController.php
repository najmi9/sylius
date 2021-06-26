<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class HomePageController
{
    /** @var Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function indexAction(): Response
    {
        return new Response($this->twig->render('@SyliusShop/Homepage/index.html.twig'));
    }

    public function customAction(Request $request): Response
    {
        return new Response($this->twig->render('custom/index.html.twig', [
            'query' => $request->query->all(),
        ]));
    }
}
