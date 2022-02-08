<?php

use App\Page;

Route::post('page', function () {
    $page = Page::where('path', request('path'))->first();
    $meta = $page->metas;

    $metas = new stdClass;
    if ($meta->where('key', 'content')->first()) {
        $metas->content = $meta->where('key', 'content')->first()->value;
    }
    if ($meta->where('key', 'main_image')->first()) {
        $metas->image = url('storage/uploads/' . $page->id . '/' . $meta->where('key', 'main_image')->first()->value);
    }

    return ['page' => $page, 'metas' => $metas];
});
