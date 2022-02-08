@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">News <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/news/create') }}" class="btn btn-sm btn-outline-secondary">New Post</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.news.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Title</th>
						<th>Path</th>
						<th>Author</th>
						<th>Publish Date</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($posts as $post)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $post->id }}"></td>
							@include('admin.news.partials.title', ['partial' => $post])
							<td><a href="{{ url($post->path) }}" target="_blank">{{ \Illuminate\Support\Str::limit($post->path, 30) }}</td>
							<td>{{ $post->user->name }}</td>
							<td>{{ $post->published_at }}</td>
							<td>{{ $post->updated_at }}</td>
							<td>{{ $post->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $posts->links() }}
@endsection
