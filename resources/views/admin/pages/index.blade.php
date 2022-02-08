@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Pages <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/pages/create') }}" class="btn btn-sm btn-outline-secondary">New Page</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.pages.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>Title</th>
						<th>Path</th>
						<th>Author</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($pages as $page)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $page->id }}"></td>
							@include('admin.pages.partials.title', ['partial' => $page])
							<td><a href="{{ url($page->path) }}" target="_blank">{{ $page->path }}</a></td>
							<td>{{ $page->user->name }}</td>
							<td>{{ $page->updated_at }}</td>
							<td>{{ $page->created_at }}</td>

							@if ( ! empty($page->children))
								@foreach ($page->children as $child)
									<tr class="children">
										<td><input type="checkbox" name="selected[]" class="page" value="{{ $child->id }}"></td>
										@include('admin.pages.partials.title', ['partial' => $child])
										<td><a href="{{ url($page->path . $child->path) }}" target="_blank">{{ $child->path }}</a></td>
										<td>{{ $child->user->name }}</td>
										<td>{{ $child->updated_at }}</td>
										<td>{{ $child->created_at }}</td>
									</tr>
								@endforeach
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>

	{{ $pages->links() }}
@endsection

@push('styles')
	<style>
		.children td:not(:first-child) {
			padding-left: 25px;
		}
	</style>
@endpush
