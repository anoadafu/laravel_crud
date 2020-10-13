<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Image;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Delete old Images
        // Storage::disk('public')->deleteDirectory('images');
        // Create dir for Images if it not exist
        Storage::disk('public')->makeDirectory('images');

        // Create admin User
        $admin = factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'photo-spot-admin@admin.com',
            'admin' => true,
        ]);
        // Create dummy Users
        $users = factory(User::class, 5)->create();
        // Create categories from http://lorempixel.com/
        $categories_array = [
            'abstract', 'animals', 'business', 'cats', 'city', 'food', 'nightlife', 'fashion', 'people', 'nature', 'sports', 'technics', 'transport'
        ];
        // Add categories to DB
        $categories = [];
        foreach($categories_array as $category){
            $categories[] = factory(Category::class)->create(['title' => $category]);
        }

        // Create uploaded Images for every User
        foreach($users as $user){
            $images = factory(Image::class, 5)->create([
                'user_id' => $user->id,
            ]);
            // Create thumb for Image
            foreach($images as $image) $image->create_thumb();
        }
    }
}
