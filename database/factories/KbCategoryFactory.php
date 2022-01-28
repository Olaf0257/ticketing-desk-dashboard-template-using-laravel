<?php

namespace Database\Factories;

use App\Models\KbCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Helpers\Uuid;

class KbCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KbCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Uuid::getUuid(),
            'name' => $this->faker->sentence($nbWords = 1, $variableNbWords = true),
            'icon' => "<i class='fas fa-tshirt'></i>",
            'description' => $this->faker->sentence($nbWords = 10, $variableNbWords = true),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
