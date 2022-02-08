<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Storage;
use App\Genre;
use App\Asset;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null)
    {
        switch ($filter) {
            case 'trashed':
                $genres = Genre::onlyTrashed();
                break;
            default:
                $genres = new Genre;
                break;
        }

        if ($request->has('search')) {
            $genres = $genres->search($request->search)->paginate(20);
        } else {
            $genres = $genres->paginate(20);
        }

        return view('admin.genres.index')->with([
            'genres' => $genres,
            'filter' => $filter
        ]);
    }

    /**
     * Handle bulk actions
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $action = $request->get('actions');
        $selected = $request->get('selected');

        if (empty($selected)) {
            return back();
        }

        switch ($action) {
            case 'bin':
                Genre::destroy($selected);
                break;

            case 'restore':
                Genre::onlyTrashed()->whereIn('id', $selected)->restore();
                break;
        }

        return redirect('/admin/genres');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.genres.create');
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
            'name' => 'required',
            'image' => 'nullable|image'
        ]);

        $genre = new Genre;

        $genre->name = $data['name'];

        if ( !empty($data['image']) ) {
            $genre->saveCoverImage($data['image']);
        }

        $genre->save();

        return redirect('admin/genres');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'nullable|sometimes|image'
        ]);


        $genre = Genre::findOrFail($id);

        $genre->name = $data['name'];

        if ( !empty( $data['image'] ) ) {
            $genre->saveCoverImage($data['image']);
        }

        $genre->save();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genre = Genre::findOrFail($id);

        return view('admin.genres.edit')->with('genre', $genre);
    }

    /**
     * Soft delete the object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Genre::destroy($id);

        return redirect('/admin/genres');
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Genre::onlyTrashed()->where('id', $id)->restore();

        return redirect('/admin/genres');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Genre::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect('/admin/genres/trashed');
    }
}