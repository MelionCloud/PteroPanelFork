<?php

namespace Database\Factories;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Pterodactyl\Models\Addon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Addon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'uuidShort' => Str::lower(Str::random(8)),
            'name' => $this->faker->domainWord,
            'description' => implode(' ', $this->faker->sentences()),
            'image' => 'http://via.placeholder.com/16x16',
            'version' => $this->faker->numerify('v###'),
            'author' => $this->faker->name,
            'website' => $this->faker->url,
            'license' => $this->faker->word,
            'enabled' => $this->faker->boolean,
            'installed' => $this->faker->boolean,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
