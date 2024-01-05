<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog>
 */
class CatalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomNum = fake()->randomNumber(5, true);
        $exampleCatalogMeta = [
            "title" => "Criminology Series",
            "subjects" => "Criminology | Police | Law Enforcement",
        ];

        return [
            "title" => 'Test Catalog -' .$randomNum,
            "description" => 'lorem ipsum test description of the Catalog -' .$randomNum,
            "user_id" => User::factory()->create()->id,
            "metadata" => $exampleCatalogMeta,
        ];
    }
}
