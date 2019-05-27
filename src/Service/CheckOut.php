<?php

namespace Gelato\Service;

use Gelato\Entities\ProductInterface;

class CheckOut
{
    /**
     * @var array A sku indexed array containing all the products scanned
     */
    private $productLines = [];

    /**
     * Returns the grand total of the checkout
     */
    public function getGrandTotal()
    {
        $checkoutTotal = 0.0;
        foreach($this->productLines as $line)
        {
            $checkoutTotal += $line['lineTotal'];
        }
        return $checkoutTotal;
    }

    public function __construct($pricing_rules)
    {
    }

    /**
     * @param ProductInterface $product The product being scanned at the checkout
     */
    public function scanItem(ProductInterface $product): void
    {
        if(!array_key_exists($product->getSku(), $this->productLines)) {
            $this->productLines[$product->getSku()] = [
                'product' => $product,
                'qty' => 0,
                'lineTotal' => 0.0
            ];
        }

        // Increase the quantity of products by one
        $line = &$this->productLines[$product->getSku()];
        $line['qty']++;
        $line['lineTotal'] = $product->getUnitPrice() * $line['qty'];
    }
}