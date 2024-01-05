<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomNum = fake()->randomNumber(5, true);
        $exampleMeta = [
            "title" => "Criminology skills",
            "authors" => "Finch, Emily | Fafinski, Stefan",
            "type" => "Text",
            "Publication details" => "Oxford University, 2012.",
            "Description" => "xix, 402 p. : ill. ; 25 cm",
            "ISBN" => "9780199597376",
            "subjects" => "Criminology -- Research | Criminology -- Study guides | Criminology",
            "ddc" => "364",
        ];

        return [
            'title' => 'Test Document -' .$randomNum,
            'description' =>'lorem ipsum test description of the Document -' .$randomNum,
            'status' => 'Active',
            'isCatalog' => false,
            'catalog_id'=> null,
            'user_id' => User::factory()->create()->id,
            'metadata'=> $exampleMeta,

        ];
    }
}
