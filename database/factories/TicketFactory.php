<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Helpers\Uuid;
use App\Helpers\Random;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Uuid::getUuid(),
            'tid' => Random::getTicketNumber(),
            'site_id' => 0,
            'ticket_user_id' => 3,
            'opened_user_id' => $this->faker->randomElement(['2', '3']),
            'department_id' => $this->faker->randomElement(['1', '2']),
            'title' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'message' => $this->faker->sentence($nbWords = 20, $variableNbWords = true),
            'staff_unread' => 0,
            'user_unread' => $this->faker->randomElement([true, false]),
            'ticket_status_id' => $this->faker->randomElement(['1', '2', '3', '4', 5, 6]),
            'ticket_urgency_id' => $this->faker->randomElement(['1', '2', '3']),
            'last_touched_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'source' => 'web',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
