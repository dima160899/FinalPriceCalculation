<?php

namespace App\DTO;

/**
 *
 */
class TaxDto
{
    private array $countryIndexes;

    /**
     *
     * @return array
     */
    public function getCountryIndexes(): array
    {
        return $this->countryIndexes;
    }

    /**
     *
     *
     * @param array $countryIndexes
     *
     * @return TaxDto
     */
    public function setCountryIndexes(array $countryIndexes): self
    {
        $this->countryIndexes = $countryIndexes;

        return $this;
    }
}