<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('plans')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'title' => 'Standard',
                'price' => 0,
                'role_id' => '4',
                'content' => 'Suspendisse at tortor sed magna fermentum ultricies vitae nec elit. Nullam eu justo luctus, tincidunt orci quis, viverra nulla. Morbi ut aliquam libero, eu consectetur lectus. Curabitur eu ullamcorper urna. Nulla nunc magna, aliquet vel neque quis, tincidunt sollicitudin libero. In hac habitasse platea dictumst. Vestibulum sagittis venenatis mi, at facilisis ipsum commodo sit amet.'
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'title' => 'Artist',
                'price' => 0,
                'role_id' => '5',
                'content' => 'Suspendisse at tortor sed magna fermentum ultricies vitae nec elit. Nullam eu justo luctus, tincidunt orci quis, viverra nulla. Morbi ut aliquam libero, eu consectetur lectus. Curabitur eu ullamcorper urna. Nulla nunc magna, aliquet vel neque quis, tincidunt sollicitudin libero. In hac habitasse platea dictumst. Vestibulum sagittis venenatis mi, at facilisis ipsum commodo sit amet.'
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'title' => 'Artist Pro',
                'price' => 10,
                'role_id' => '6',
                'content' => 'Suspendisse at tortor sed magna fermentum ultricies vitae nec elit. Nullam eu justo luctus, tincidunt orci quis, viverra nulla. Morbi ut aliquam libero, eu consectetur lectus. Curabitur eu ullamcorper urna. Nulla nunc magna, aliquet vel neque quis, tincidunt sollicitudin libero. In hac habitasse platea dictumst. Vestibulum sagittis venenatis mi, at facilisis ipsum commodo sit amet.'
            ],
        ]);
    }
}
