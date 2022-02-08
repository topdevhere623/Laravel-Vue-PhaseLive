<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;
use App\FaqCategory;

class FAQCategoryController extends Controller
{

    protected $validationRules = [
        'category' => 'required|string|max:255',
        'category-icon' => 'string|max:255',
        'sort_id' => 'nullable|integer',
    ];

    public function index()
    {
        $faqsCategories = FaqCategory::all();
        return view('admin.faqs-categories.index', compact('faqsCategories'));
    }

    public function create()
    {
        $faqsCategories = FaqCategory::all();
        return view('admin.faqs-categories.create', compact('faqsCategories'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate($this->validationRules);
        FaqCategory::create([
            'name' => $validated['category'],
            'icon' => $validated['category-icon'],
            'sort_id' => $validated['sort_id'],
        ]);

        return redirect('/admin/faqs-categories');
    }

    public function edit($id)
    {
        $categories = FaqCategory::find($id);
        return view('admin.faqs-categories.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate($this->validationRules);
        $FaqCategory = FaqCategory::find($id);

        $FaqCategory->name = $validated['category'];
        $FaqCategory->icon = $validated['category-icon'];
        $FaqCategory->sort_id = $validated['sort_id'];

        $FaqCategory->save();

        return redirect('/admin/faqs-categories');
    }

    public function destroy(FaqCategory $FaqCategory, $id)
    {
        $FaqCategory->destroy($id);
        return redirect('/admin/faqs-categories');
    }
}
