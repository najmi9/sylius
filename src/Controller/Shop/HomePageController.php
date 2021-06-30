<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\Entity\Customer\Customer;
use App\Infrastructure\GeoLocation\LocationInterface;
use App\Infrastructure\Search\SearchConstants;
use App\Infrastructure\Search\SearchInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

final class HomePageController extends AbstractController
{
    /**
     * @Route("/{_locale}/home", name="home", methods={"GET"})
     */
    public function index(Request $request, SearchInterface $search, LocationInterface $location, SessionInterface $session,
    CustomerRepository $customerRepo): Response
    {
        $customerLocation = [];
        $lastProducts = [];
        $ip = $request->getClientIp();
        /** @var Customer $customer */
        $customer = $customerRepo->findOneBy(['publicIP' => $ip]);

        // GET Customer Location
        if ($customer) {
            $customerLocation = $customer->getLocation();
            // Recently Purchased Products Category
            $lastProducts = $customer->getLastProducts();
        }

        if (!$customer) {
            $key = "customer-location-{$ip}";
            $cachedLocation = $session->get($key, null);

            if (!$cachedLocation) {
                $customerLocation = $location->location($ip);
                $session->set($key, $customerLocation);
            }
        }

        $searchOptions = $this->options($customerLocation, $lastProducts);

        $result = $search->search(SearchConstants::PRODUCTS_INDEX, '', $searchOptions);

        return $this->render('home/index.html.twig', [
            'products' => $result->getItems(),
            'total' => $result->getTotal(),
        ]);
    }

    private function options(array $customerLocation, array $lastProducts): array
    {
        $searchOptions = [];
        $searchOptions['close'] = [
            'to' => 'store.location',
            'origin' => $customerLocation,
        ];

        // Last Products Options

        return $searchOptions;
    }
}
