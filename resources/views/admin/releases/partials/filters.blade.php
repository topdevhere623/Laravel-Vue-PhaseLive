<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/releases') }}">All</a> <span class="count">({{ App\Release::count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/releases/live') }}">Live</a> <span class="count">({{ App\Release::statusLive()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/releases/featured') }}">Featured</a> <span class="count">({{ App\Release::featured()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/releases/pending') }}">Pending</a> <span class="count">({{ App\Release::statusPending()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/releases/offline') }}">Offline</a> <span class="count">({{ App\Release::statusOffline()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/releases/trashed') }}">Trashed</a> <span class="count">({{ App\Release::onlyTrashed()->count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
