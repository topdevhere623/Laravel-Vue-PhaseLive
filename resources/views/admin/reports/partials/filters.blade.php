<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/reports/unacknowledged') }}">Unacknowledged</a> <span class="count">({{ App\Report::unAcknowledged()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/reports/acknowledged') }}">Acknowledged</a> <span class="count">({{ App\Report::acknowledged()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/reports') }}">All</a> <span class="count">({{ App\Report::count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
