<?php

namespace Tests\Gelato\Integration;

use Gelato\Entities\Product;
use Gelato\Service\CheckOut;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class CheckOutTest extends TestCase
{
    private $productA;
    private $productB;
    private $productC;
    private $productD;

    private $pricingRules;

    protected function setUp(): void
    {
        $this->pricingRules = [
            'A' => [
                6 => 230, // 38.33333333
                3 => 130  // 43.33333333
            ],
            'B' => [
                2 => 45
            ]
        ];

        $this->productA = new Product('A', 'A product', 50.0);
        $this->productB = new Product('B', 'B product', 30.0);
        $this->productC = new Product('C', 'C product', 20.0);
        $this->productD = new Product('D', 'D product', 15.0);
    }

    /**
     * @test
     */
    public function test_get_grand_total()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productA);

        Assert::assertEquals(50.0, $checkout->getGrandTotal());
    }

    /**
     * @test
     */
    public function test_product_sequence_a()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productB);

        Assert::assertEquals(80.0, $checkout->getGrandTotal());
    }

    /**
     * @test
     */
    public function test_product_sequence_b()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);

        Assert::assertEquals(100.0, $checkout->getGrandTotal());
    }

    /**
     * @test
     */
    public function test_product_sequence_c()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);

        Assert::assertEquals(130.0, $checkout->getGrandTotal());
    }

    /**
     * @test
     */
    public function test_product_sequence_d()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productC);
        $checkout->scanItem($this->productD);
        $checkout->scanItem($this->productB);
        $checkout->scanItem($this->productA);

        Assert::assertEquals(115.0, $checkout->getGrandTotal());
    }

    /**
     * @test
     */
    public function test_product_rules_applying_correctly()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productB);
        Assert::assertEquals(30.0, $checkout->getGrandTotal());

        $checkout->scanItem($this->productB);
        Assert::assertEquals(45.0, $checkout->getGrandTotal());

        $checkout->scanItem($this->productB);
        Assert::assertEquals(75.0, $checkout->getGrandTotal());

        $checkout->scanItem($this->productB);
        Assert::assertEquals(90.0, $checkout->getGrandTotal());
    }

    /**
     * @test
     */
    public function test_higher_quantity_special_price()
    {
        $checkout = new CheckOut($this->pricingRules);

        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);

        Assert::assertEquals(230.0, $checkout->getGrandTotal());

        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);
        $checkout->scanItem($this->productA);

        Assert::assertEquals(360.0, $checkout->getGrandTotal());
    }
}