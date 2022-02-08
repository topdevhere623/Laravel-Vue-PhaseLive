@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Page</h1>

		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url("/admin/meta/create/{$page->id}") }}" class="btn btn-sm btn-outline-secondary">New Meta</a>
			</div>
		</div>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			<div class="form-group">
				<label for="title">Title</label>
				@include('admin.partials.field-error', ['field' => 'title'])
				<input type="text" class="form-control" name="title" id="title" value="{{ $page->title }}">
			</div>

			<div class="form-group">
				<label for="path">Path</label>
				@include('admin.partials.field-error', ['field' => 'path'])
				<input type="text" class="form-control" name="path" id="path" value="{{ $page->path }}">
			</div>

			<div class="form-group">
				<label for="user_id">Author</label>
				@include('admin.partials.field-error', ['field' => 'user_id'])
				<select name="user_id" id="user_id" class="form-control">
					<option value="">Select a User</option>
					@foreach($users as $user)
						<option value="{{ $user->id }}" {{ $page->user->id == $user->id ? 'selected' : null }}>{{ $user->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="parent_id">Parent Page</label>
				@include('admin.partials.field-error', ['field' => 'parent_id'])
				<select name="parent_id" id="parent_id" class="form-control">
					<option value="">Select a Page</option>
					@foreach ($parents as $parent)
						<option value="{{ $parent->id }}" {{ $page->parent_id == $parent->id ? 'selected' : null }}>{{ $parent->title }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="component_id">Vue Component</label>
				@include('admin.partials.field-error', ['field' => 'component_id'])
				<select class="form-control" name="component_id" id="component_id">
					<option value="">Select a Component</option>
					@foreach ($components as $component)
						<option value="{{ $component->id }}" {{ $page->component->id == $component->id ? 'selected' : null }}>{{ $component->name }}</option>
					@endforeach
				</select>
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
		</form>
	</div>

	@if ($metas->count() > 0)
		<br />
		<br />
		<br />

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
			<h1 class="h2">Meta</h1>
		</div>

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th>Key</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($metas as $meta)
						<tr>
							<td class="has-actions">
								<a href="{{ url('/admin/meta/edit/' . $meta->id) }}">{{ $meta->key }}</a>

								<div class="row-actions">
									<span class="edit">
										<a href="{{ url('/admin/meta/edit/' . $meta->id) }}">Edit</a>
									</span>
									|
									<span class="bin">
										<a href="{{ url('/admin/meta/delete/' . $meta->id) }}">Delete</a>
									</span>
								</div>
							</td>
							<td>{{ $meta->updated_at }}</td>
							<td>{{ $meta->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@endif
@endsection