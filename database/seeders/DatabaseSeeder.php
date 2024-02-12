<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(
                Post::factory()
                    ->count(rand(1, 5))
                    ->has(Comment::factory()->count(rand(1, 5)), 'comments'),
                'posts'
            )
            ->create([
                'email' => 'admin@gmail.com',
            ]);
    }
}
