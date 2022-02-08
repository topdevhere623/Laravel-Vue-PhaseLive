@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Permission</h1>
	</div>

	<div>
        <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
            @method('patch')
			@csrf

			<div class="form-group">
				<label for="name">Name</label>
				@include('admin.partials.field-error', ['field' => 'name'])
				<input type="text" required class="form-control" name="name" id="name" value="{{ $permission->name }}">
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
		</form>
	</div>
@endsection
