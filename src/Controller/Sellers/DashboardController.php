<?php

declare(strict_types=1);

namespace App\Controller\Sellers;

use App\Entity\Seller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seller", name="seller_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/become-one", name="become_one")
     */
    public function becomeSeller(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $seller = new Seller();

        $seller->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setIsEnabled(false)
            ->setUser($user)
        ;

        $em->persist($seller);
        $em->flush();

        $this->addFlash('success', 'Now You are a seller.');

        return $this->redirectToRoute('seller_stores');
    }
}
