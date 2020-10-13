<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    // Get random category for new Image
    $category = Category::inRandomOrder()->first();
    // Download and save Image from http://lorempixel.com/ with selected category
    $file = $faker->image($dir = storage_path('app/public/images'), $width = 1920, $height = 1080, $category->title);
    $file_name = explode('\\', $file);
    $storage_path = 'images/' . end($file_name);

    return [
        'title' => $faker->sentence(3),
        'description' => $faker->text(254),
        'category_id' => $category->id,
        'storage_path' => $storage_path
    ];
});
