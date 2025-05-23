<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ItemCategory as Category;

class CategoryModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_insert_category()
    {
        // Membuat sebuah Category dengan nama 'Micin'
        $category = Category::create(['name' => 'Micin']);

        // Test apakah nama kategori sesuai
        $this->assertEquals('Micin', $category->name);
    }
}
