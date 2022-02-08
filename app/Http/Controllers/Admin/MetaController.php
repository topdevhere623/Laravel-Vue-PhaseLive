<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meta;
use App\Page;
use Illuminate\Support\Facades\Storage;

class MetaController extends Controller
{
    /**
     * Get page metas.
     *
     * @param  \Illuminate\Http\Request $request
     * @param null $id
     * @return \Illuminate\Http\Response
     */
    public function getPageMetas(Request $request, $id)
    {
        //get page
        $page = Page::findOrFail($id);

        //loop through metas and prepare them for front end
        $image = ['uploaded' => null, 'input' => null];
        $repeater = ['text' => [], 'image' => [], 'dropdown' => [], 'slider' => []];
        $content = '';
        foreach ($page->metas as $meta) {
            if ($meta->option === 'text' || $meta->option === 'dropdown') {
                array_push($repeater[$meta->option], [
                    'id' => count($repeater[$meta->option]),
                    'name' => $meta->key,
                    'inputs' => json_decode($meta->value)
                ]);
            } elseif ($meta->option === 'image') {
                //store image full path
                $image = ['uploaded' => url('storage/uploads/' . $id . '/' . $meta->value), 'input' => null];
            } elseif ($meta->option === 'slider') {
                //loop through slider and add actual URLs
                $slider = json_decode($meta->value);
                foreach ($slider as $item) {
                    $item->uploaded = url('storage/uploads/' . $id . '/slider/' . $item->uploaded);
                }
                array_push($repeater[$meta->option], [
                    'id' => count($repeater[$meta->option]),
                    'name' => $meta->key,
                    'inputs' => $slider
                ]);
            } elseif ($meta->option === 'content') {
                $content = $meta->value;
            }
        }

        return ['repeater' => $repeater, 'image' => $image, 'content' => $content];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $page = !is_null($id) ? Page::find($id) : null;

        return view('admin.meta.create')->with(['page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param null $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        //get page
        $page = Page::findOrFail($id);

        //clear old metas
        $page->metas()->delete();

        if ($request->has('content')) {
            $page->metas()->save(
                new \App\Meta([
                    'key' => 'content',
                    'value' => $request['content'] ?: '',
                    'option' => 'content'
                ])
            );
        }

        /*========================================
        =            Store main image            =
        ========================================*/
        if ($request->has('main_image.input')) {
            //get original image file name
            $originalName = $request->all()['main_image']['input']->getClientOriginalName();

            //upload image
            $request->all()['main_image']['input']->storeAs('uploads', $id . '/' . $originalName, 'public');

            //store record in db
            $page->metas()->save(
                new \App\Meta([
                    'key' => 'main_image',
                    'value' => $originalName,
                    'option' => 'image'
                ])
            );
        //if user remove the uploaded image
        } elseif ($request->has('main_image.uploaded')) {
            //store record in db
            $page->metas()->save(
                new \App\Meta([
                    'key' => 'main_image',
                    'value' => basename($request->all()['main_image']['uploaded']),
                    'option' => 'image'
                ])
            );
        } else {
            //then delete it from database and file system
            $mainImage = $page->metas()->where('option', 'image')->first();
            if ($mainImage) {
                Storage::disk('public')->delete('uploads/' . $id . '/' . $mainImage->value);
                $mainImage->delete();
            }
        }

        /*=======================================
        =            Store repeaters            =
        =======================================*/

        //check for repeaters
        if ($request->has('repeaters')) {
            //loop through repeaters and for each type add the correct structure to DB
            foreach ($request->all()['repeaters'] as $type => $repeater) {
                /*======================================================
                =            Store text and dropdown fields            =
                ======================================================*/
                if ($type == 'text' || $type == 'dropdown') {
                    foreach ($repeater as $name => $inputs) {
                        $page->metas()->save(
                            new \App\Meta([
                                'key' => $name,
                                'value' => json_encode($inputs),
                                'option' => $type
                            ])
                        );
                    }

                    /*=====================================
                    =            Store sliders            =
                    =====================================*/
                } elseif ($type == 'slider') {
                    foreach ($repeater as $name => $inputs) {
                        //loop through inputs and upload files
                        $sliderArray = [];
                        foreach ($inputs as $image) {
                            //if file already uploaded just add the name to the db array
                            if (isset($image['uploaded'])) {
                                array_push($sliderArray, [
                                    'uploaded' => basename($image['uploaded'])
                                ]);
                            //else input exist then upload the file and save to db array
                            } elseif (isset($image['input'])) {
                                //get original image file name
                                $originalName = $image['input']->getClientOriginalName();
                                $image['input']->storeAs('uploads', $id . '/slider/' . $originalName, 'public');
                                array_push($sliderArray, [
                                    'uploaded' => $originalName
                                ]);
                            }
                        }

                        $page->metas()->save(
                            new \App\Meta([
                                'key' => $name,
                                'value' => json_encode($sliderArray),
                                'option' => $type
                            ])
                        );
                    }
                }
            }
        }

        return back();
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $meta = Meta::findOrFail($id);

    //     return view('admin.meta.edit')->with([
    //         'meta' => $meta,
    //     ]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $meta = Meta::findOrFail($id);

    //     $validated = $request->validate([
    //         'key' => 'required|max:255',
    //         'value' => 'required',
    //     ]);

    //     $validated['page_id'] = $meta->page_id;

    //     $meta->update($validated);

    //     return back();
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     Meta::destroy($id);

    //     return back();
    // }
}
