<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Cool title',
            'author_id' => Author::factory(),
        ];
    }
}
