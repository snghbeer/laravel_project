<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'author' => 'snghbeer',
                'content' => 'Nice content bro',
                'news_id' => 1
            ], [
                'author' => 'testuser',
                'content' => "Very informative content, I recommend!",
                'news_id' => 1
            ], [
                'author' => 'admin',
                'content' => 'What am I doing here???',
                'news_id' => 1 
            ],
            [
                'author' => 'snghbeer',
                'content' => 'Dummy comment 1',
                'news_id' => 2
            ], [
                'author' => 'testuser',
                'content' => "Why did you comment like a bot ??",
                'news_id' => 2
            ]
        ]);
    }
}
