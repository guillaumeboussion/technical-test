<?php

namespace Database\Factories;

use App\Enum\ProfileStatus;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'creator_id' => null,
            'status' => $this->faker->randomElement(ProfileStatus::cases()),
            'image_url' => $this->faker->imageUrl(),
        ];
    }

    public function pending(): self
    {
        return $this->state([
            'status' => ProfileStatus::Pending,
        ]);
    }

    public function active(): self
    {
        return $this->state([
            'status' => ProfileStatus::Active,
        ]);
    }
}
