@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Plans</h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/plans/create') }}" class="btn btn-sm btn-outline-secondary">New Plan</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Plan</th>
						<th>Price</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($plans as $plan)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $plan->id }}"></td>
							@include('admin.plans.partials.title', ['partial' => $plan])
							<td>{{ $plan->price }}</td>
							<td>{{ $plan->updated_at }}</td>
							<td>{{ $plan->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

@endsection