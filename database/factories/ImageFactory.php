<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = $this->faker->numberBetween(1,54) . '.jpg';
        return [
            'path'=> "img/products/{$fileName}",
        ];
    }

    public function user(){
        $fileName = $this->faker->numberBetween(1,5) . '.jpg';

        return $this->state([
            'path'=> "img/users/{$fileName}",
        ]);
    }
    public function userJ(){
        $fileName = 'j.jpg';

        return $this->state([
            'path'=> "img/users/{$fileName}",
        ]);
    }
}
