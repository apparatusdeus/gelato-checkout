<?php

namespace Gelato\Service;

use Gelato\Entities\ProductInterface;
use Gelato\Entities\ProductLine;

class CheckOut
{
    /**
     * @var array A sku indexed array containing all the products scanned
     */
    private $productLines = [];

    /**
     * @var array A collection of pricing rules used to alter the product pricing
     */
    private $pricingRules = [];

    /**
     * Returns the grand total of the checkout
     */
    public function getGrandTotal()
    {
        $checkoutTotal = 0.0;

        /**
         * @var string $sku
         * @var ProductLine $line
         */
        foreach($this->productLines as $sku => $line)
        {
            $product = $line->getProduct();
            $productQuantity = $line->getQuantity();
            $rules = [];
            if(array_key_exists($sku, $this->pricingRules)) {
                $rules = $this->pricingRules[$sku];
            }

            foreach($rules as $ruleQuantity => $rulePrice) {
                $multiplier = floor($productQuantity / $ruleQuantity);
                if($multiplier > 0) {
                    $checkoutTotal += $rulePrice * $multiplier;
                    $productQuantity -= $ruleQuantity * $multiplier;
                }
            }

            $checkoutTotal += $productQuantity * $product->getUnitPrice();
        }
        return $checkoutTotal;
    }

    public function __construct(array $pricing_rules)
    {
        $this->pricingRules = $pricing_rules;
    }

    /**
     * @param ProductInterface $product The product being scanned at the checkout
     */
    public function scanItem(ProductInterface $product): void
    {
        if(!array_key_exists($product->getSku(), $this->productLines)) {
            $this->productLines[$product->getSku()] = new ProductLine($product);
        }

        // Increase the quantity of products by one
        $this->productLines[$product->getSku()]->incrementQuantity();
    }
}