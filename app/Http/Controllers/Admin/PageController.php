<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use App\Component;
use App\User;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param null $filter
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null)
    {
        switch ($filter) {
            case 'trashed':
                $pages = Page::onlyTrashed();
                break;
            case 'mine':
                $pages = \Auth::user()->pages()->isParent();
                break;
            default:
                $pages = Page::isParent();
                break;
        }

        if ($request->has('search')) {
            $pages = $pages->search($request->search)->paginate(15);
        } else {
            $pages = $pages->paginate(15);
        }

        return view('admin.pages.index')->with([
            'pages' => $pages,
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
                Page::destroy($selected);
                break;

            case 'restore':
                Page::onlyTrashed()->whereIn('id', $selected)->restore();
                break;
        }

        return redirect('/admin/pages');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = Component::get(['id', 'name']);
        $users = User::role('admin')->get(['id', 'name']);
        $parents = Page::isParent()->get(['id', 'title']);

        return view('admin.pages.create')->with([
            'components' => $components,
            'users' => $users,
            'parents' => $parents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'path' => 'required|max:255',
            'name' => 'required|max:255',
            'user_id' => 'required|integer',
            'parent_id' => 'nullable|integer',
            'component_id' => 'required|integer',
        ]);

        Cache::forget('routes');

        Page::create($validated);

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
        $page = Page::findOrFail($id);
        $components = Component::get(['id', 'name']);
        $users = User::role('admin')->get(['id', 'name']);
        $parents = Page::isParent()->get(['id', 'title']);
        // $metas = $page->meta()->get();

        return view('admin.pages.edit')->with([
            'page' => $page,
            'components' => $components,
            'users' => $users,
            'parents' => $parents,
            // 'metas' => $metas
        ]);
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
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'path' => 'required|max:255',
            'name' => 'required|max:255',
            'user_id' => 'required|integer',
            'parent_id' => 'nullable|integer',
            'component_id' => 'required|integer',
        ]);

        $page->update($validated);

        Cache::forget('routes');

        return back();
    }

    /**
     * Soft delete the object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Page::destroy($id);

        Cache::forget('routes');

        return redirect('/admin/pages');
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $page = Page::onlyTrashed()->where('id', $id)->restore();

        Cache::forget('routes');

        return redirect('/admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::onlyTrashed()->where('id', $id)->forceDelete();

        Cache::forget('routes');

        return redirect('/admin/pages/trashed');
    }
}
