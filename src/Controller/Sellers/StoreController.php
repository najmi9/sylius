<?php

declare(strict_types=1);

namespace App\Controller\Sellers;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seller", name="seller_")
 */
class StoreController extends AbstractController
{
    /**
     * @Route("/stores/new", name="stores_new")
     */
    public function new(EntityManagerInterface $em): Response
    {
        $store = new Store();

        $seller = $this->getUser()->getseller();

        $store->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setSeller($seller)
            ->setIsEnabled(true)
            ->setName('Store Name')
        ;
        $em->persist($store);
        $em->flush();

        $this->addFlash('success', 'Store Created Successfully.');

        return $this->redirectToRoute('seller_stores');
    }

    /**
     * @Route("/store", name="store")
     */
    public function dashboard(): Response
    {
        $store = $this->getUser()->getSeller()->getStore();

        // the dashboard of a seller store.
        return $this->render('seller/store.html.twig', [
            'store' => $store,

        ]);
    }
}
