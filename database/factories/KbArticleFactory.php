<?php

namespace Database\Factories;

use App\Models\KbArticle;
use App\Models\KbCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Helpers\Uuid;

class KbArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KbArticle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Uuid::getUuid(),
            'title' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'category_id' =>  function () {
                return KbCategory::all()->unique()->random()->uuid;
            },
            'status' => true,
            'description' => $this->faker->paragraphs($nb = 3, $asText = true),
            'page_title' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'meta_description' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'meta_keyword' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'slug' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
