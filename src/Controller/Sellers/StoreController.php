<?php

declare(strict_types=1);

namespace App\Controller\Sellers;

use App\Entity\Store;
use App\Entity\User\ShopUser;
use App\Repository\ProductRepository;
use App\Repository\StoreRepository;
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
     * @Route("/stores", name="stores")
     */
    public function stores(): Response
    {
        /** @var ShopUser $user */
        $user = $this->getUser();

        $seller = $user->getSeller();

        $stores = $seller->getStores();

        return $this->render('seller/stores.html.twig', [
            'stores' => $stores,
        ]);
    }

    /**
     * @Route("/stores/{id}/dashboard", name="store")
     */
    public function dashboard(string $id, StoreRepository $storeRepo, ProductRepository $productRepository): Response
    {
        $store = $storeRepo->find($id);

        $prods = $productRepository->findBy(['store' => $store]);

        dd($prods);

        // the dashboard of a seller store.
        return $this->render('seller/store.html.twig', [
            'store' => $store,
        ]);
    }

    /**
     * @Route("/test/{id}", name="test")
     */
    public function test($id)
    {

    }
}
