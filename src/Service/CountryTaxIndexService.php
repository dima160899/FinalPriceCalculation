<?php

namespace App\Service;

/**
 *
 */
class CountryTaxIndexService
{
    /**
     * @param string $taxIndex
     *
     * @return string
     */
    public function getCountryTagFromTaxIndex(string $taxIndex): string
    {
        return \substr($taxIndex, 0, 2);
    }
}