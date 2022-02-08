<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
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
                $comments = Comment::onlyTrashed();
                break;
            case 'flagged':
                $comments = Comment::whereHas('reports')->with('reports');
                break;
            default:
                $comments = new Comment;
                break;
        }

        if ($request->has('search')) {
            $comments = $comments->search($request->search)->orderby('created_at')->paginate(10);
        } else {
            $comments = $comments->orderby('created_at')->paginate(10);
        }

        return view('admin.comments.index')->with([
            'comments' => $comments,
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
                Comment::destroy($selected);
                break;

            case 'restore':
                Comment::onlyTrashed()->whereIn('id', $selected)->restore();
                break;
        }

        return redirect('/admin/comments');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return view('admin.comments.edit')->with([
            'comment' => $comment,
            'reports' => $comment->reports()->with('user')->get()
        ]);
    }

    public function update(Comment $comment, Request $request)
    {
        $comment->update([
            'body' => $request->body
        ]);

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
        Comment::destroy($id);

        return redirect('/admin/comments');
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Comment::onlyTrashed()->where('id', $id)->restore();

        return redirect('/admin/comments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect('/admin/comments/trashed');
    }
}
