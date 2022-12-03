<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            [
                'question' => 'How many cars does the company own?',
                'answer' => 'We are too poor to own cars yet!',
                'category_id' => 1
            ],
            [
                'question' => 'How do you plan to invest in company cars?',
                'answer' => "We obviously planned to burn all our shareholders' investments",
                'category_id' => 1
            ], [
                'question' => 'How many tigers does the company own?',
                'answer' => 'We have many cats, especially in our branch in Thailand',
                'category_id' => 2
            ]
        ]);
    }
}
