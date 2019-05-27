<?php

namespace Gelato\Entities;

class Product implements ProductInterface
{
    /**
     * @var string The sku of the product used to uniquely identify it
     */
    private $sku;

    /**
     * @var string The name of the product
     */
    private $description;

    /**
     * @var int The price of an individual item.
     */
    private $unitPrice;

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * ProductInterface constructor.
     * @param string $sku A product sku used to uniquely identify a product
     * @param string $description A product description
     * @param float $unitPrice The price of a single product
     */
    public function __construct(string $sku, string $description, float $unitPrice)
    {
        $this->sku = $sku;
        $this->description = $description;
        $this->unitPrice = $unitPrice;
    }
}