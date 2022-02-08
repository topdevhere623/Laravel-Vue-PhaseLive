<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\News;
use App\Asset;

class NewsController extends Controller
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
                $posts = News::onlyTrashed()->orderby('created_at', 'desc');
                break;
            case 'mine':
                $posts = \Auth::user()->news_posts()->orderby('created_at', 'desc');
                break;
            case 'drafts':
                $posts = News::drafts();
                break;
            default:
                $posts = News::orderby('created_at', 'desc');
                break;
        }

        if ($request->has('search')) {
            $posts = $posts->search($request->search)->paginate(15);
        } else {
            $posts = $posts->paginate(15);
        }

        return view('admin.news.index')->with([
            'posts' => $posts,
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
                News::destroy($selected);
                break;

            case 'restore':
                News::onlyTrashed()->whereIn('id', $selected)->restore();
                break;

            case 'publish':
                foreach ($selected as $post) {
                    $news = News::findOrFail($post);
                    if ($news->isDraft()) {
                        $news->publishPost();
                    }
                }
                break;
        }

        return redirect('/admin/news');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::role('admin')->get(['id', 'name']);
        $categories = Category::get(['id', 'title']);

        return view('admin.news.create')->with([
            'users' => $users,
            'categories' => $categories,
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
        $data = $request->validate([
            'title' => 'required',
            'path' => 'required',
            'content' => 'required',
            'user_id' => 'required|integer',
            'image' => 'required|image',
            'categories' => 'required|array',
        ]);

        $post = News::create($request->only(['title', 'path', 'content', 'user_id']));

        if (!empty($data['image'])) {
            $post->saveCoverImage($data['image']);
        }

        $post->categories()->sync($request->get('categories'));

        $post->save();

        return redirect('/admin/news');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = News::findOrFail($id);
        $users = User::role('admin')->get(['id', 'name']);
        $categories = Category::get(['id', 'title']);

        return view('admin.news.edit')->with([
            'post' => $post,
            'users' => $users,
            'categories' => $categories,
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
        $data = $request->validate([
            'title' => 'required',
            'path' => 'required',
            'content' => 'required',
            'user_id' => 'required|integer',
            'image' => 'image',
            'categories' => 'required|array',
        ]);

        $post = News::findOrFail($id);

        $post->update($request->only(['title', 'path', 'content', 'user_id']));

        if (!empty($data['image'])) {
            $post->saveCoverImage($data['image']);
        }

        $post->categories()->sync($request->get('categories'));

        $post->save();

        return redirect('/admin/news')->with("Successfully Updated");
    }

    /**
     * Soft delete the object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        News::destroy($id);

        return redirect('/admin/news');
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $page = News::onlyTrashed()->where('id', $id)->restore();

        return redirect('/admin/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = News::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect('/admin/news/trashed');
    }

    public function publish($id)
    {
        News::findOrFail($id)->publishPost();

        return redirect()->back();
    }
}
