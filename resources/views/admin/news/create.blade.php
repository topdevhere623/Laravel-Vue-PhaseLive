@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">News</h1>
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
				<label for="user_id">Author</label>
				@include('admin.partials.field-error', ['field' => 'user_id'])
				<select name="user_id" id="user_id" class="form-control">
					<option value="">Select a User</option>
					@if(!empty($users))
						@foreach($users as $user)
							<option {{ Auth::id() == $user->id ? 'selected' : null }} value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
					@endif
				</select>
			</div>

			<div class="form-group">
				<label for="categories">Category</label>
				@include('admin.partials.field-error', ['field' => 'categories'])
				<select name="categories[]" id="categories" class="form-control" multiple="multiple">
					@if(!empty($categories))
						@foreach($categories as $category)
							<option value="{{ $category->id }}">{{ $category->title }}</option>
						@endforeach
					@endif
				</select>
			</div>

			<div class="form-group">
				<label for="content">Content</label>
				@include('admin.partials.field-error', ['field' => 'content'])
				<textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
			</div>

			<div class="form-group">
				<label for="published_at">Publish Date</label>
				<input class="form-control" type="date" name="published_at">
			</div>

			<div class="form-group">
				<label for="image">Image</label>
				@include('admin.partials.field-error', ['field' => 'image'])
				<input id="image" name="image" type="file" class="file" data-show-preview="false">
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Create">
		</form>
	</div>
@endsection

@push('scripts')
	<script>
		jQuery(function ($) {
			$('#categories').select2()
		})
	</script>
@endpush
