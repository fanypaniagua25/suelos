<?php
namespace Modules\Coberturasuelos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Coberturasuelos\Models\Coberturasuelo;

class CoberturasueloFactory extends Factory
{
    protected $model = Coberturasuelo::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}