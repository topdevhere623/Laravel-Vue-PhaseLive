@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Role</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			<div class="form-group">
				<label for="name">Name</label>
				@include('admin.partials.field-error', ['field' => 'name'])
				<input type="text" required class="form-control" name="name" id="name" value="{{ $role->name }}">
			</div>

			<div class="form-group">
				<label for="password">Permissions</label>
				@include('admin.partials.field-error', ['field' => 'permissions'])
				<select name="permissions[]" required id="permission" multiple class="form-control">
					@foreach ($permissions as $permission)
						<option value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'selected' : '' }}>{{ ucfirst($permission->name) }}</option>
					@endforeach
				</select>
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
		</form>
	</div>
@endsection
