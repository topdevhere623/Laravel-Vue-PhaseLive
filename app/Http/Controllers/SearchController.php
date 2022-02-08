<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Release;
use App\Track;
use App\Phase\Filter\Filter;
use App\Genre;

class SearchController extends Controller
{

    /**
     * 
     * Main Search
     * 
     */
    public function index(Request $request, $page = 1)
    {
        $validated = $request->validate([
            'term' => 'string|nullable',

            'genres' => 'array',
            'genres.*.id' => 'exists:genres,id',

            'classes' => 'array',
            'classes.*.val' => 'string',
            'classes.*.name' => 'string',

            'keys' => 'array',
            'keys.val' => 'string',
            'keys.name' => 'string',

            'bpm' => 'array'
        ]);

        $users = User::whereHas('roles', function ($q) use ($validated) {
            $q->whereIn('roles.name', ['pro', 'artist', 'admin', 'standard'])
                ->where(function ($q) use ($validated) {
                    $q->where('users.name', 'like', '%' . $validated['term'] . '%')
                        ->orWhere('users.first_name', 'like', '%' . $validated['term'] . '%')
                        ->orWhere('users.last_name', 'like', '%' . $validated['term'] . '%');
                });
        })->get();


        $tracks = collect(Track::where('status', 'approved')
            ->where('name', 'like', '%' . $validated['term'] . '%')
            ->get());

        $releases = collect(Release::where('status', 'live')
            ->where('name', 'like', '%' . $validated['term'] . '%')
            ->orWhere('description', 'like', '%' . $validated['term'] . '%')
            ->orWhereHas('uploader', function ($query) use ($validated) {
                return $query->where('name', 'like', '%' . $validated['term'] . '%');
            })->get());

        $filter = new Filter($releases);

        if (collect($validated['genres'])->isNotEmpty()) {
            foreach ($validated['genres'] as $genre) {
                $filter->addGenreFilter(Genre::find($genre['id']));
            }
        }

        if (collect($validated['classes'])->isNotEmpty()) {
            foreach ($validated['classes'] as $class) {
                $filter->addClassFilter($class['val']);
            }
        }

        if (collect($validated['bpm'])->isNotEmpty()) {
            $filter->addBpmFilter($validated['bpm'][0], $validated['bpm'][1]);
        }

        if (collect($validated['keys'])->isNotEmpty()) {
            $filter->addKeyFilter($validated['keys']);
        }

        $data = collect();

        if ($validated['term']) $data = $data->merge($users);

        $data = $data->merge($tracks)->merge($filter->get());

        $chunked = $data->chunk(20);
        if (isset($chunked[$page - 1])) {
            return $chunked[$page - 1];
        } else {
            return [];
        }
    }
}
