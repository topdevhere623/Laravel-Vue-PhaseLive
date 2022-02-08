<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/orders') }}">All</a> <span class="count">({{ App\Order::count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/orders/complete') }}">Complete</a> <span class="count">({{ App\Order::complete()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/orders/pending') }}">Pending</a> <span class="count">({{ App\Order::pending()->count() }})</span>
		</li>

		<li>
			<a href="{{ url('admin/orders/cancelled') }}">Cancelled</a> <span class="count">({{ App\Order::cancelled()->count() }})</span>
		</li>
	</ul>

	@include('admin.partials.bulk-actions')
</div>
