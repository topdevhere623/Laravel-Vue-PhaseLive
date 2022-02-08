@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Users <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/users/create') }}" class="btn btn-sm btn-outline-secondary">New User</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.users.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Display Name</th>
						<th>Email</th>
                        <th>Roles</th>
                        <th>Status</th>
						<th>Approved At</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $user->id }}"></td>
							@include('admin.users.partials.title', ['partial' => $user])
							<td>{{ $user->email }}</td>
                            <td>{!! implode(',', array_map('ucfirst', $user->roles->pluck('name')->toArray())) !!}</td>
                            <td>{{ $user->status }}</td>
							<td>
								@if(!$user->approved_at) <p class="btn-danger p-2">Requires Approval</p>
								@else {{ $user->approved_at }}
								@endif
							</td>
							<td>{{ $user->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $users->links() }}

	@push("styles")
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' />
	@endpush
@endsection
