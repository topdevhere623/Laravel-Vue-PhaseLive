@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Genres <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/genres/create') }}" class="btn btn-sm btn-outline-secondary">New Genre</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.genres.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Name</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($genres as $genre)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $genre->id }}"></td>
							@include('admin.genres.partials.title', ['partial' => $genre])
							<td>{{ $genre->updated_at }}</td>
							<td>{{ $genre->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $genres->links() }}
@endsection