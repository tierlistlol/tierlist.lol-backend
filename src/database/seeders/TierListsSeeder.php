<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\TierList;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TierListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all the users and categories
        $users = User::all();
        $categories = Categories::all();

        // For each user, create a tier list, randomly set
        // is_public field and a category

        $users->each(function (User $user) use ($categories) {
            $category = $categories->random();

            TierList::factory()->create([
                User::FOREIGN_KEY => $user,
                Categories::FOREIGN_KEY => $category,
            ]);
        });

        $this->seedCarouselWithRealisticThumbnail();
    }

    private function seedCarouselWithRealisticThumbnail(): void
    {
        $url = 'https://i.imgur.com/UUNxrF4.png'; // image of tier list template 600x420

        TierList::factory(6)->create([
            'thumbnail' => $url,
            'is_public' => true,
            Model::CREATED_AT => fake()->dateTimeBetween(startDate: 'now', endDate: 'now'),
        ]);
    }
}
