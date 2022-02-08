@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Comments <small>{{ $filter }}</small></h1>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.comments.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Excerpt</th>
						<th>Module</th>
						<th>Author</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($comments as $comment)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $comment->id }}"></td>
							@include('admin.comments.partials.title', ['partial' => $comment])
							<td>{{ ucfirst($comment->commentable_type) }}</td>
							<td>{{ $comment->user->name }}</td>
							<td>{{ $comment->updated_at }}</td>
							<td>{{ $comment->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $comments->links() }}
@endsection
