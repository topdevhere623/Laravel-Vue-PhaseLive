<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/comments') }}">All</a> <span class="count">({{ App\Comment::count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/comments/trashed') }}">Trashed</a> <span class="count">({{ App\Comment::onlyTrashed()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/comments/flagged') }}">Flagged</a> <span class="count">({{ App\Comment::whereHas('reports')->count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
