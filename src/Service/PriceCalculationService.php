<?php

namespace App\Service;

use App\Entity\Sale;
use App\Exception\SaleException;
use App\Repository\CountryTaxRepository;
use Doctrine\ORM\NonUniqueResultException;
use mysql_xdevapi\Exception;

class PriceCalculationService
{
    private CountryTaxRepository   $countryTaxRepository;

    private CountryTaxIndexService $countryTaxIndexService;

    /**
     * @param CountryTaxRepository   $countryTaxRepository
     * @param CountryTaxIndexService $countryTaxIndexService
     */
    public function __construct(
        CountryTaxRepository $countryTaxRepository,
        CountryTaxIndexService $countryTaxIndexService
    ) {
        $this->countryTaxRepository = $countryTaxRepository;
        $this->countryTaxIndexService = $countryTaxIndexService;
    }

    /**
     * @param Sale $sale
     *
     * @return int
     * @throws SaleException
     */
    public function calculate(Sale $sale): int
    {
        try {
            $country = $this->countryTaxRepository->getCountryByTaxIndex(
                $this->countryTaxIndexService->getCountryTagFromTaxIndex($sale->getTaxIndex())
            );
        } catch(\Exception $exception) {
            throw new SaleException($exception->getMessage());
        }
        if ($country === null) {
            throw new SaleException('Something went wrong...');
        }

        return $sale->getProduct() !== null ?
            $sale->getProduct()->getPrice() * (1 + ($country->getTax() / 100)) : 0;
    }
}