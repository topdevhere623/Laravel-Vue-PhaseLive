@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	<h1 class="h2">Edit <?php echo $plan->title ?> Plan</h1>
</div>

<div>
	<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
		@method('patch')
		@csrf

		<div class="form-group">
			<label for="question">Title</label>
			@include('admin.partials.field-error', ['field' => 'title'])
			<input type="text" class="form-control" name="title" id="title" value="<?php echo $plan->title ?>" required >

		</div>

		<div class="form-group">
			<label for="subtitle">Subtitle</label>
			@include('admin.partials.field-error', ['field' => 'subtitle'])
			<input type="text" name="subtitle" id="subtitle" class="form-control" value="<?php echo $plan->subtitle ?>" >

		</div>

		<div class="form-group">
			<label for="price">Price</label>
			@include('admin.partials.field-error', ['field' => 'price'])
			<input type="number" class="form-control" name="price" id="price" value="<?php echo $plan->price ?>" required >

		</div>

		<div class="form-group">
			<label for="content">Content</label>
			<textarea class="form-control" name="content" id="content" rows="6" value="<?php echo $plan->content ?>" ></textarea>
		</div>

		<div class="form-group">
			<label for="role">Role</label>
			<select id="role" name="role" required>
				@foreach($roles as $role)
					<option value="{{ $role->id  }}" {{ $plan->role_id === $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">

            @if ($plan->image)
			<div class="image-preview">
				<div>Current Image</div>
				<img src="{{ $plan->image->files['thumb']->url }}" alt="{{ $plan->image->alt }}" >
			</div>

			<br />
            @endif

			<label for="image">New Image</label>
			@include('admin.partials.field-error', ['field' => 'image'])
			<input id="image" name="image" type="file" class="file" data-show-preview="false" >
		</div>

		<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">

	</form>
</div>

@endsection