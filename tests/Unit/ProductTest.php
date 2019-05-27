<?php

namespace Tests\Gelato\Unit;

use Gelato\Entities\Product;
use Gelato\Entities\ProductInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var ProductInterface
     */
    private $product;

    protected function setUp(): void
    {
        $this->product = new Product('A', 'A product', 50.0);
    }

    /**
     * @test
     */
    public function test_get_sku(): void
    {
        Assert::assertEquals('A', $this->product->getSku());
    }

    /**
     * @test
     */
    public function test_get_description(): void
    {
        Assert::assertEquals('A product', $this->product->getDescription());
    }

    /**
     * @test
     */
    public function test_get_unit_price(): void
    {
        Assert::assertEquals(50.0, $this->product->getUnitPrice());
    }
}