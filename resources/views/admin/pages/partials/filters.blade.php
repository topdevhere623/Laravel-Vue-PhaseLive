<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/pages') }}">All</a> <span class="count">({{ App\Page::count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/pages/mine') }}">Mine</a> <span class="count">({{ \Auth::user()->pages()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/pages/trashed') }}">Trashed</a> <span class="count">({{ App\Page::onlyTrashed()->count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
