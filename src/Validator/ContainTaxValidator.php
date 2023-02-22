<?php

namespace App\Validator;

use App\Repository\CountryTaxRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 *
 */
class ContainTaxValidator extends ConstraintValidator
{
    private CountryTaxRepository $countryTaxRepository;

    public function __construct(CountryTaxRepository $countryTaxRepository)
    {
        $this->countryTaxRepository = $countryTaxRepository;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     */
    public function validate($value, Constraint $constraint): void
    {
        $countryTaxes = $this->countryTaxRepository->findAll();
        if (!$constraint instanceof ContainTax) {
            throw new UnexpectedTypeException($constraint, ContainTax::class);
        }

        if (!\is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        $isNotValid = true;
        if (!preg_match('/^[A-Z][A-Z][0-9]+$/', $value)) {
            $this->fail($constraint);

            return;
        }
        foreach ($countryTaxes as $countryTax) {
            if ((\strlen($value) - 2 === $countryTax->getTaxIndexNumberCount()) && similar_text(
                    $value,
                    $countryTax->getTaxIndexName()
                ) === 2) {
                $isNotValid = false;
            }
        }

        if ($isNotValid) {
            $this->fail($constraint);
        }
    }

    /**
     * @param Constraint $constraint
     *
     * @return void
     */
    public function fail(Constraint $constraint): void
    {
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}