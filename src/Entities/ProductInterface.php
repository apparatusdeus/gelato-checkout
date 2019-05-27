<?php

namespace Gelato\Entities;

interface ProductInterface
{
    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return int
     */
    public function getUnitPrice(): int;

    /**
     * ProductInterface constructor.
     * @param string $sku A product sku used to uniquely identify a product
     * @param string $description A product description
     * @param float $unitPrice The price of a single product
     */
    public function __construct(string $sku, string $description, float $unitPrice);
}