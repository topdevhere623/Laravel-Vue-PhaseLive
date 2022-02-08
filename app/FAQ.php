<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * Class Faq
 *
 * A frequently asked question
 *
 * @package App
 */
class Faq extends PhaseModel
{
    use SearchableTrait;

    protected $guarded = [];

//    protected $table = 'faqs';

    protected $searchable = [
        'columns' => [
            'faqs.question' => 20,
            'faqs.answer' => 10,
            'faq_categories.name' => 5,
        ],
        'joins' => [
            'faq_categories' => ['faqs.category_id', 'faq_categories.id']
        ]
    ];

    public function scopeInOrder($query)
    {
        return $query->orderBy('sort_id', 'asc');
    }

    public function category()
    {
        return $this->belongsTo('App\FaqCategory', 'category_id');
    }
}
