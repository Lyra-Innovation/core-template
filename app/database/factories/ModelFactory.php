<?php

use Faker as Faker;

$factory->define(App\Allie::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image' => 'https://danriverchurch.org/wp-content/uploads/2017/05/Core_Podcast.jpg',
    ];
});

$factory->define(App\Answer::class, function (Faker\Generator $faker) {
    return [
        'question_id' => function () {
             return factory(App\Question::class)->create()->id;
        },
        'answer' => $faker->word,
        'correct' => $faker->boolean,
    ];
});

$factory->define(App\Competence::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image' => 'https://danriverchurch.org/wp-content/uploads/2017/05/Core_Podcast.jpg',
    ];
});

$factory->define(App\Question::class, function (Faker\Generator $faker) {
    return [
        'question' => $faker->word,
    ];
});

$factory->define(App\Resource::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image' => 'https://danriverchurch.org/wp-content/uploads/2017/05/Core_Podcast.jpg',
    ];
});

$factory->define(App\Sector::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image' => 'https://danriverchurch.org/wp-content/uploads/2017/05/Core_Podcast.jpg',
    ];
});

$factory->define(App\SectorCompetence::class, function (Faker\Generator $faker) {
    return [
        'sector_id' => function () {
             return factory(App\Sector::class)->create()->id;
        },
        'competence_id' => function () {
             return factory(App\Competence::class)->create()->id;
        },
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'password' => bcrypt('test')
    ];
});

$factory->define(App\UserItem::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
             return factory(App\User::class)->create()->id;
        },
        'item' => $faker->word,
        'item_id' => $faker->randomNumber(),
        'item_comment' => $faker->word,
        'level' => $faker->randomNumber(),
    ];
});

