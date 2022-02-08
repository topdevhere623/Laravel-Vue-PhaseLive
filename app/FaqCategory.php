<?php

namespace App;

/**
 * Class FaqCategory
 *
 * A way of grouping frequently asked questions
 *
 * @package App
 */
class FaqCategory extends PhaseModel
{
    protected $guarded = [];
    protected $table = 'faq_categories';
    protected $appends = ['faqs'];

    public function scopeInOrder($query)
    {
        return $query->orderBy('sort_id', 'asc');
    }

    public function faqs()
    {
        return $this->hasMany('App\Faq', 'category_id');
    }

    public function getFaqsAttribute()
    {
        return $this->faqs()->orderBy('sort_id')->get();
    }
}
