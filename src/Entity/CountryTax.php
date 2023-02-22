<?php

namespace App\Entity;

use App\Repository\CountryTaxRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
#[ORM\Entity(repositoryClass: CountryTaxRepository::class)]
class CountryTax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $country = null;

    #[ORM\Column(length: 5)]
    private ?string $taxIndexName = null;

    #[ORM\Column]
    private ?int $taxIndexNumberCount = null;

    #[ORM\Column]
    private ?int $tax = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return $this
     */public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxIndexName(): ?string
    {
        return $this->taxIndexName;
    }

    /**
     * @param string $taxIndexName
     *
     * @return $this
     */public function setTaxIndexName(string $taxIndexName): self
    {
        $this->taxIndexName = $taxIndexName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTaxIndexNumberCount(): ?int
    {
        return $this->taxIndexNumberCount;
    }

    /**
     * @param int $taxIndexNumberCount
     *
     * @return $this
     */public function setTaxIndexNumberCount(int $taxIndexNumberCount): self
    {
        $this->taxIndexNumberCount = $taxIndexNumberCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTax(): ?int
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     *
     * @return $this
     */public function setTax(int $tax): self
    {
        $this->tax = $tax;

        return $this;
    }
}
