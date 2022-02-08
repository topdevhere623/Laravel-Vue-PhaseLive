@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Roles <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/roles/create') }}" class="btn btn-sm btn-outline-secondary">New Role</a>
			</div>
		</div>
	</div>
	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.roles.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Role</th>
						<th>Guard</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($roles as $role)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $role->id }}"></td>
							@include('admin.roles.partials.title', ['partial' => $role])
							<td>{{ $role->guard_name }}</td>
							<td>{{ $role->updated_at }}</td>
							<td>{{ $role->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $roles->links() }}
@endsection
