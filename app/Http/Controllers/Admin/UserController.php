<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use App\Events\FreezeAccount;
use App\Events\BanUserAccount;
use App\Events\UnFreezeAccount;
use App\Http\Controllers\Controller;
use App\Mail\UserFreeze;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use App\NotificationSetting;
use Auth;
use Mail;
use App\Mail\NewAccount;
use App\Mail\UserApproved;

class UserController extends Controller
{

    protected $count = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null, $role = null)
    {
        switch ($filter) {
            case 'trashed':
                $users = User::onlyTrashed();
                break;
            case 'role':
                if (is_null($role)) {
                    $users = [];
                } else {
                    $roleExists = Role::where('name', $role)->count() > 0;
                    $users = $roleExists ? User::role($role) : [];
                }
                break;
            default:
                $users = new User;
                break;
        }

        if ($request->has('search')) {
            $users = $users->search($request->search)->paginate($this->count);
        } else {
            $users = $users->paginate($this->count);
        }

        $roles = Role::all();

        return view('admin.users.index')->with([
            'users' => $users,
            'roles' => $roles,
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
                User::destroy($selected);
                break;

            case 'restore':
                User::onlyTrashed()->whereIn('id', $selected)->restore();
                break;
        }

        return redirect('/admin/users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = Role::all();

        return view('admin.users.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'integer|required|exists:roles,id',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required',
            'social_web' => 'nullable',
            'social_facebook' => 'nullable',
            'social_twitter' => 'nullable',
            'social_youtube' => 'nullable',
        ]);

        $validated['path'] = strtolower(str_replace(' ', '_', $validated['name']));

        $user = User::create($validated)
            ->assignRole($validated['role']);

        $this->createNotificationSettings($user);

        return redirect('/admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $genres = Genre::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'genres' => $genres,
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'role' => 'integer|required|exists:roles,id',
            'password' => 'nullable|confirmed|min:6',
            'social_web' => 'nullable',
            'phone' => 'required|max:255',
            'social_facebook' => 'nullable',
            'social_twitter' => 'nullable',
            'social_youtube' => 'nullable',
            'interests' => 'nullable',
            'genres' => 'nullable',
        ]);

        $user = User::findOrFail($id);
        $user->syncRoles($validated['role']);
        $user->update($validated);
        $user->interests()->sync($validated['interests']);
        $user->genres()->sync($validated['genres']);

        return back();
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->approved_at = now();
        $user->save();
        Mail::to($user->email)->send(new UserApproved($user));

        return redirect('/admin/users');
    }

    public function freeze($id)
    {
        $user = User::findOrFail($id);
        event(new FreezeAccount($user));
        Mail::to($user->email)->send(new UserFreeze($user));

        return redirect('/admin/users');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        event(new UnFreezeAccount($user));

        Mail::to($user->email)->send(new UserApproved($user));

        return redirect('/admin/users');
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        event(new BanUserAccount($user));

        return redirect('/admin/users');
    }

    /**
     * Soft delete the object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (Auth::id() == $id) {
            return null;
        }

        User::destroy($id);

        return redirect('/admin/users');
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (Auth::id() == $id) {
            return null;
        }

        $user = User::onlyTrashed()->where('id', $id)->restore();

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return null;
        }

        $user = User::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect('/admin/users/trashed');
    }

    protected function createNotificationSettings($user)
    {
        return $user->notification_setting()->create([
            'activity_follower_on_me_email' => 0,
            'activity_share_on_mine_email' => 0,
            'activity_post_from_followee_email' => 0,
            'activity_like_on_mine_email' => 0,
            'activity_comment_on_mine_email' => 0,
            'activity_message_email' => 0,
            'phase_new_features_email' => 0,
            'phase_surveys_feedback_email' => 0,
            'phase_tips_offers_email' => 0,
            'phase_newsletter_email' => 0,
        ]);
    }

    public function unapprove($id)
    {
        if (Auth::id() == $id) {
            return null;
        }

        $user = User::where('id', $id)->update(['approved_at' => null ]);

        return redirect('/admin/users');
    }
}
