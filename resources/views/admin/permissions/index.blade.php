@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Permissions <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/permissions/create') }}" class="btn btn-sm btn-outline-secondary">New Permission</a>
			</div>
		</div>
	</div>
	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.permissions.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Permission</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($permissions as $permission)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $permission->id }}"></td>
							@include('admin.permissions.partials.title', ['partial' => $permission])
							<td>{{ $permission->updated_at }}</td>
							<td>{{ $permission->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $permissions->links() }}
@endsection
