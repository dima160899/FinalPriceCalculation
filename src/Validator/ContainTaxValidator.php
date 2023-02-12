<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use function PHPUnit\Framework\equalTo;

/**
 *
 */
class ContainTaxValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     */
    public function validate($value, Constraint $constraint): void
    {
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
        foreach ($constraint->taxDto->getCountryIndexes() as $taxIndex => $taxNumberCount) {
            if ((\strlen($value) - 2 === $taxNumberCount) && similar_text($value, $taxIndex) === 2) {
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