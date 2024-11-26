<?php

namespace Database\Factories\Partner;

use App\Models\Team;
use App\Models\Partner\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class PartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => 1,
            'image' => "",
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'ssn' => str_pad(rand(00,99),2,'0', STR_PAD_LEFT) . str_pad(rand(1,12),2,'0', STR_PAD_LEFT) . str_pad(rand(0,31),2,'0', STR_PAD_LEFT) . '-' . rand(1111,9999),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'twitch_url' => $this->faker->firstName(),
            'youtube_url' => "https://www.youtube.com/channel/" . Str::random(),
            'instagram_url' => "https://www.instagram.com/" . Str::random(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
    }
}
