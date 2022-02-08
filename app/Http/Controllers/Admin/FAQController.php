<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use App\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    protected $validationRules = [
        'question' => 'required|string|max:255',
        'answer' => 'required|string',
        'sort_id' => 'required|integer',
        'category_id' => 'required|integer'
    ];

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $faqs = Faq::search($request->search)->get();
        } else {
            $faqs = Faq::all();
        }

        return view('admin.faqs.index')->with([
            'faqs' => $faqs
        ]);
    }

    public function create()
    {
        $categories = FaqCategory::all();

        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);

        $faq = new Faq([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_id' => $validated['sort_id'],
            'category_id' => $validated['category_id']
        ]);
        $faq->save();

        return redirect('admin/faqs');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::all();

        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validationRules);

        $faq = Faq::findOrFail($id);

        $faq->question = $validated['question'];
        $faq->answer = $validated['answer'];
        $faq->sort_id = $validated['sort_id'];
        $faq->category_id = $validated['category_id'];
        $faq->save();

        return back();
    }

    public function delete($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect('/admin/faqs');
    }
}
