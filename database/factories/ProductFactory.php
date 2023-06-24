<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
    protected $model = Product::class;
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $index = 1;

        return [
            'code' => $this->faker->unique()->regexify('[A-Za-z0-9]{6}'),
            'name' => $this->faker->name,
            'img_url' => 'https://picsum.photos/id/' . $index . '/200/300',
            'price' => $this->faker->numberBetween(1000, 999999),
            'currency' => 'IDR',
            'discount' => $this->faker->numberBetween(1, 20),
            'dimension' => '13 cm x 10 cm',
            'unit' => 'PCS',
            'created_by' => 1,
        ];
    }
}
