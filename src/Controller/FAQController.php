<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FAQController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('custom/index.html.twig');
    }
}