@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Reports <small>{{ $filter }}</small></h1>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.reports.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>ID</th>
						<th>Actions</th>
						<th>Reported Type</th>
						<th>Reported ID</th>
						<th>Reporter</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($reports as $report)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $report->id }}"></td>
							<td>{{ $report->id }}</td>
							@include('admin.reports.partials.title', ['partial' => $report])
							<td>{{ ucfirst($report->reportable->type) }}</td>
							<td>{{ ucfirst($report->reportable->id) }}</td>
							<td><a href="/admin/users/edit/{{ $report->user->id }}">{{ $report->user->name }}</a></td>
							<td>{{ $report->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $reports->links() }}
@endsection
