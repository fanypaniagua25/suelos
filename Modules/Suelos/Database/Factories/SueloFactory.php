<?php
namespace Modules\Suelos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Suelos\Models\Suelo;

class SueloFactory extends Factory
{
    protected $model = Suelo::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}