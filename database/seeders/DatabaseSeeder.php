<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CommentFactory;
use Database\Factories\ProfileFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->createMany(10);

        ProfileFactory::new()
            ->for(UserFactory::new())
            ->createMany(10);

        CommentFactory::new()
            ->for(
                ProfileFactory::new()->for(UserFactory::new())
            )
            ->createMany(10);
    }
}
