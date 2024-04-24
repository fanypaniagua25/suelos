<?php
namespace Modules\Cultivos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cultivos\Models\Cultivo;

class CultivoFactory extends Factory
{
    protected $model = Cultivo::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}