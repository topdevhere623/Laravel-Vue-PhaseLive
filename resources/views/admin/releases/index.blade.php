@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Releases <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/releases/create') }}" class="btn btn-sm btn-outline-secondary">New Release</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.releases.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Title</th>
						<th></th>
						<th>Status</th>
						<th>Total Tracks</th>
						<th>Featured</th>
						<th>Release Date</th>
						<th>Royalty Fee</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($releases as $release)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $release->id }}"></td>
							@include('admin.releases.partials.title', ['partial' => $release])
							<td><a href="/admin/tracks/release/{{ $release->id }}" class="btn btn-secondary">View Tracks</a></td>
							<td>{{ $release->status }}</td>
							<td>{{ $release->tracks->count() }}</td>
							<td>@if ($release->isFeatured()) Yes @else No @endif</td>
							<td>{{ $release->release_date->format('d/m/Y') }}</td>
							<td>{{ $release->royalty_fee }}%</td>
							<td>{{ $release->updated_at }}</td>
							<td>{{ $release->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $releases->links() }}
@endsection
