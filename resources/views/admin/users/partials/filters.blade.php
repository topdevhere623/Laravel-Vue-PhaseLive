<div class="filter-bar">
	<ul class="filters">
		<li>
			<a href="{{ url('admin/users') }}">All</a> <span class="count">({{ App\User::count() }})</span>
		</li>

		@foreach ($roles as $role)
			@if (($count = App\User::role($role->name)->count()) > 0)
				<li>
					<a href="{{ url("admin/users/role/{$role->name}") }}">{{ ucfirst($role->name) }}</a> <span class="count">({{ $count }})</span>
				</li>
			@endif
		@endforeach

		@if (($count = App\User::onlyTrashed()->count()) > 0)
			<li>
				<a href="{{ url('admin/users/trashed') }}">Trashed</a> <span class="count">({{ $count }})</span>
			</li>
		@endif
	</ul>

	@include('admin.partials.bulk-actions')
</div>
