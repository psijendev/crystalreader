<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Document;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "document_id" => Document::factory()->create()->id,
            "user_id" => User::factory()->create()->id,
            "status" => "Active",
        ];
    }
}
