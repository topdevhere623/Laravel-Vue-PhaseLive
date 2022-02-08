<?php

namespace App\Http\Controllers;

use App\Merch;
use App\Phase\ImageManager;
use Illuminate\Http\Request;
use App\Events\User\CreatedMerch;

class MerchController extends Controller
{
    public function index()
    {
        return Merch::with('user')->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'image',
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'links.*.link' => 'active_url'
        ]);

        if ($data['image']) {
            $manager = ImageManager::resource($data['image'])
                ->directory('images/merch')
                ->altText('Product Image')
                ->square()
                ->storeOriginal()
                ->storeLarge()
                ->storeMedium()
                ->storeThumb();
        }

        $merch = Merch::create([
            'user_id' => $request->user()->id,
            'image_id' => $manager->asset->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'links' => $data['links'],
        ]);

        $merch->refresh();

        event(new CreatedMerch($merch));

        return $merch;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Merch $merch
     * @return void
     */
    public function update(Request $request, Merch $merch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Merch $merch
     * @return void
     */
    public function destroy(Merch $merch)
    {
        //
    }
}
