<?php

namespace Database\Factories;

use App\Models\FaqCategory;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Helpers\Uuid;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Uuid::getUuid(),
            'question' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'category_id' =>  function () {
                return FaqCategory::all()->unique()->random()->uuid;
            },
            'answer' => $this->faker->paragraphs($nb = 3, $asText = true),
            'status' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
