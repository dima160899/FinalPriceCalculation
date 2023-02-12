<?php

namespace App\Controller;

use App\DTO\TaxDto;
use App\Entity\CountryTax;
use App\Entity\Sale;
use App\Form\Type\SaleType;
use App\Repository\CountryTaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class SaleController extends AbstractController
{
    private CountryTaxRepository $countryTaxRepository;

    /**
     * @param CountryTaxRepository $countryTaxRepository
     */
    public function __construct(CountryTaxRepository $countryTaxRepository)
    {
        $this->countryTaxRepository = $countryTaxRepository;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $countryTax = $this->countryTaxRepository->findAll();

        $taxDto = new TaxDto();

        $sale = new Sale();

        $indexes = [];
        foreach ($countryTax as $tax) {
            $indexes[$tax->getTaxIndexName()] = $tax->getTaxIndexNumberCount();
        }

        $taxDto->setCountryIndexes($indexes);

        $form = $this->createForm(SaleType::class, $sale, ['taxDto' => $taxDto]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $country = $this->countryTaxRepository->getCountryByTaxIndex(
              $this->getCountryTagFromTaxIndex($sale->getTaxIndex())
            );
            if ($country === null) {
                return new Response('Something went wrong...');
            }
            $price = $sale->getProduct() !== null ?
                $sale->getProduct()->getPrice() * (1 + ($country->getTax() / 100)) : 0;
            return $this->render('sale/price.html.twig', [
                'price' => $price
            ]);
        }

        return $this->render('sale/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param string $taxIndex
     *
     * @return string
     */
    private function getCountryTagFromTaxIndex(string $taxIndex): string
    {
        return \substr($taxIndex, 0, 2);
    }
}