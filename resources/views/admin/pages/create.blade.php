@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Page</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@csrf

			<div class="form-group">
				<label for="title">Title</label>
				@include('admin.partials.field-error', ['field' => 'title'])
				<input type="text" class="form-control" name="title" id="title">
			</div>

			<div class="form-group">
				<label for="path">Path</label>
				@include('admin.partials.field-error', ['field' => 'path'])
				<input type="text" class="form-control" name="path" id="path">
            </div>

            <div class="form-group">
				<label for="title">Name</label>
				@include('admin.partials.field-error', ['field' => 'name'])
				<input type="text" class="form-control" name="name" id="name">
			</div>

			<div class="form-group">
				<label for="user_id">Author</label>
				@include('admin.partials.field-error', ['field' => 'user_id'])
				<select name="user_id" id="user_id" class="form-control">
					<option value="">Select a User</option>
					@foreach($users as $user)
						<option value="{{ $user->id }}" {{ $user->id === Auth::user()->id ? 'selected' : ''}}>{{ $user->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="parent_id">Parent Page</label>
				@include('admin.partials.field-error', ['field' => 'parent_id'])
				<select name="parent_id" id="parent_id" class="form-control">
					<option value="">Select a Page</option>
					@foreach ($parents as $parent)
						<option value="{{ $parent->id }}">{{ $parent->title }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="component_id">Vue Component</label>
				@include('admin.partials.field-error', ['field' => 'component_id'])
				<select class="form-control" name="component_id" id="component_id">
					<option value="">Select a Component</option>
					@foreach ($components as $component)
						<option value="{{ $component->id }}">{{ $component->name }}</option>
					@endforeach
				</select>
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Create">
		</form>
	</div>
@endsection
