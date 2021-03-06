<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'role_id'=>$faker->numberBetween(2,3),
        'is_active'=>1,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'category_id' => $faker->numberBetween(1,5),    
        'title'=>$faker->sentence(7,11),
        'body'=>$faker->paragraphs(rand(10,15),true),

    ];
});


$factory->define(App\Photo::class, function (Faker\Generator $faker) {
    return [
        'file' =>'placeholder.jpg',
        

    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'post_id' => $faker->numberBetween(1,10),
        'is_active' => 1,
        'user_id' => rand(1,10),
        'body'=>$faker->sentence(7,11),

    ];
});


$factory->define(App\CommentReply::class, function (Faker\Generator $faker) {
    return [
        'comment_id' => rand(1,10),
        'is_active' => 1,
        'user_id' => rand(1,10),
        'body'=>$faker->sentence(7,11),

    ];
});

