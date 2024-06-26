<?php
namespace Modules\Propiedades\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Propiedades\Models\Propiedade;

class PropiedadeFactory extends Factory
{
    protected $model = Propiedade::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}