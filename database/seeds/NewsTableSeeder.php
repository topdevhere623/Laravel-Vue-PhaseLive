<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$posts = factory(App\News::class, 50)->create();

		foreach ($posts as $post)
		{
		    $categories = range(1, 4);
		    shuffle($categories);

			$post->categories()->sync(array_slice($categories, 0, 2));
		}
    }
}
