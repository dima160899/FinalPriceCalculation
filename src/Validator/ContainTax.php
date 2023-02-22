<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 *
 */
class ContainTax extends Constraint
{
    public string $message = 'Incorrect tax index';

    public function __construct(
        array $options = [],
        array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
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
        return static::class . 'Validator';
    }
}