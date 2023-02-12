<?php

namespace App\Validator;

use App\DTO\TaxDto;
use Symfony\Component\Validator\Constraint;
class ContainTax extends Constraint
{
    public string $message = 'Incorrect tax index';
    public TaxDto $taxDto;
    public function __construct(TaxDto $taxDto ,array $options = [], array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
        $this->taxDto = $taxDto;
    }

    /**
     * Returns the name of the class that validates this constraint.
     *
     * By default, this is the fully qualified name of the constraint class
     * suffixed with "Validator". You can override this method to change that
     * behavior.
     *
     * @return string
     */
    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}