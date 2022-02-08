<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/genres') }}">All</a> <span class="count">({{ App\Genre::count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/genres/trashed') }}">Trashed</a> <span class="count">({{ App\Genre::onlyTrashed()->count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
