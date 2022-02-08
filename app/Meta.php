<?php

namespace App;

/**
 * Class Meta
 *
 * Why does this class exist? I'm not sure.
 *
 * @package App
 */
class Meta extends PhaseModel
{
	protected $table = 'meta';

	protected $fillable = ['key', 'value', 'page_id','option'];

	public function metable()
	{
		return $this->morphTo();
	}
}
