<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $now = now();
//
//        $unsplash = new MahdiMajidzadeh\LaravelUnsplash\Search();
//        $photos = $unsplash->photo('music', ['per_page' => 30, 'page' => 1])->getArray();
//
//        $sizes = [
//            'original' => 'regular',
//            'thumb' => 'thumb',
//            'medium' => 'regular',
//            'large' => 'full',
//        ];
//
//        $data = [];
//
//        foreach ($photos['results'] as $key => $photo) {
//            $assetId = factory(App\Asset::class)->create()->id;
//            foreach ($sizes as $name => $size) {
//                $localName = str_random(32);
//
//                Storage::put("covers/$photo->id-$localName.jpg", file_get_contents($photo->urls->$size), 'public');
//
//                factory(App\File::class)->create([
//                    'path' => "covers/{$photo->id}-{$localName}.jpg",
//                    'size' => $name,
//                    'asset_id' => $assetId,
//                ]);
//            }
//        }

        $assets = Arr::wrap(json_decode(file_get_contents(__DIR__ . '/assets.json'), true));
        $files = Arr::wrap(json_decode(file_get_contents(__DIR__ . '/files.json'), true));

        DB::table('assets')->insert($assets);
        DB::table('files')->insert($files);
    }
}
