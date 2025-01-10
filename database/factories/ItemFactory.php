<?php

namespace Database\Factories;

use App\Models\ItemType;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $location = Location::all();
        $itemType = ItemType::all();

        return [
            "name" => $this->faker->name,
            "description" => $this->faker->text,
            "serial_number" => $this->faker->uuid(),
            "part_number" => $this->faker->uuid(),
            "count" => $this->faker->randomNumber(),
            "item_type" => $this->faker->randomElement($itemType),
            "self_location" => $this->faker->randomDigit,
            "assignee" => $this->faker->email(),
            "location" => $this->faker->randomElement($location),
            "status" => $this->faker->randomElement(array: array_keys([
                'draft' => 'Draft',
                'in_stock' => 'In Stock',
                'out_of_stock' => 'Out of Stock',
                'on_hold' => 'On Hold',
                'assigned' => 'Assigned',
                'lost' => 'Lost',
                'damaged' => 'Damaged',
            ])),
            "image" => $this->faker->randomElement($array = [null, 'image.jpg']),
        ];
    }
}
