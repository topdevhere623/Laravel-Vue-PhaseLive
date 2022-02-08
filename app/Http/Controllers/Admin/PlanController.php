<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $plans = Plan::search($request->search)->get();
        } else {
            $plans = Plan::all();
        }

         return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.plans.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $plan = new Plan();

        $plan->title = $validated['title'];
        $plan->subtitle = $validated['subtitle'];
        $plan->price = $validated['price'];
        $plan->content = $validated['content'];
        $plan->role_id = $validated['role'];
       
        if(isset($validated['image'])){
          $plan->saveCoverImage($validated['image']);
        }

        $plan->save();

        return redirect('/admin/plans');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $roles = Role::all();

        return view('admin.plans.edit', compact('plan', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $this->validateData($request);

        $plan->title = $validated['title'];
        $plan->subtitle = $validated['subtitle'];
        $plan->price = $validated['price'];
        $plan->content = $validated['content'];

        if(isset($validated['image'])){
          $plan->saveCoverImage($validated['image']);
        }
        
        $plan->save();
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect('/admin/plans');
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'price' => 'required',
            'content' => 'nullable',
            'image' => 'nullable',
            'role' => 'required|integer'
        ]);
    }
}
