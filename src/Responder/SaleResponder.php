<?php

namespace App\Responder;

use App\DTO\ResponseDTO;
use App\Exception\SaleException;
use App\Service\PriceCalculationService;

/**
 *
 */
class SaleResponder
{
    private PriceCalculationService $priceCalculationService;

    /**
     * @param PriceCalculationService $priceCalculationService
     */
    public function __construct(PriceCalculationService $priceCalculationService)
    {
        $this->priceCalculationService = $priceCalculationService;
    }

    /**
     * @param $request
     * @param $form
     * @param $sale
     *
     * @return ResponseDTO
     * @throws SaleException
     */
    public function __invoke($request, $form, $sale): ResponseDTO
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $price = $this->priceCalculationService->calculate($sale);

            return new ResponseDTO('sale/price.html.twig', [
                'price' => $price
            ]);
        }

        return new ResponseDTO('sale/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}