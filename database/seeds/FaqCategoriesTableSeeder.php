<?php

use Illuminate\Database\Seeder;

class FaqCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('faq_categories')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'name' => 'Getting Started',
                'icon' => 'fas fa-play',
                'sort_id' => 0,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'name' => 'Knowledge Base',
                'icon' => 'fas fa-lightbulb',
                'sort_id' => 10,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'name' => 'Your Account',
                'icon' => 'fas fa-user',
                'sort_id' => 20,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'name' => 'Copyright',
                'icon' => 'fas fa-copyright',
                'sort_id' => 30,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'name' => 'Contact',
                'icon' => 'fas fa-envelope',
                'sort_id' => 40,
            ],
        ]);
    }
}
