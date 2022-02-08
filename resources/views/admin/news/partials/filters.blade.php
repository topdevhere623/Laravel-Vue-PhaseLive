<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/news') }}">All</a> <span class="count">({{ App\News::count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/news/drafts')}}">Drafts <span class="count">({{ App\News::drafts()->count() }})</span></a>
		</li>

		<li>
			<a href="{{ url('admin/news/mine') }}">Mine</a> <span class="count">({{ \Auth::user()->news_posts()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/news/trashed') }}">Trashed</a> <span class="count">({{ App\News::onlyTrashed()->count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
