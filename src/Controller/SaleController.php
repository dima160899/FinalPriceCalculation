<?php

namespace App\Controller;

use App\DTO\ResponseDTO;
use App\Entity\Sale;
use App\Exception\SaleException;
use App\Form\Type\SaleType;
use App\Responder\SaleResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class SaleController extends AbstractController
{
    /**
     * @throws SaleException
     */
    public function __invoke(
        Request $request,
        SaleResponder $saleResponder
    ): Response {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);

        /** @var ResponseDTO $responseJson */
        $responseDTO = $saleResponder($request, $form, $sale);
        return $this->render($responseDTO->getView(), $responseDTO->getOptions());
    }
}