<?php

namespace Tests\SA\MuseumBundle\Entity;

use PHPUnit\Framework\TestCase;
use SA\MuseumBundle\Entity\Product;

class ProductTest extends TestCase
{

    public function testcomputeTVAFoodProduct()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, 20);

        $this->assertSame(1.1, $product->computeTVA());
    }
}