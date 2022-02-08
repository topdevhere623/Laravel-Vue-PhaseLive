@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        @if(!$user->approved_at)
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="" style="text-align: center">
                    <input type="submit" class="btn btn-sm btn-success" value="Approve">
                </div>
            </form>
        @endif
    </div>

    <div>
        <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf

            <div class="form-group">
                <label for="name">Display Name</label>
                @include('admin.partials.field-error', ['field' => 'name'])
                <input type="text" required class="form-control" name="name" id="name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                @include('admin.partials.field-error', ['field' => 'first_name'])
                <input type="text" required class="form-control" name="first_name" id="first_name"
                       value="{{ $user->first_name }}">
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                @include('admin.partials.field-error', ['field' => 'last_name'])
                <input type="text" required class="form-control" name="last_name" id="last_name"
                       value="{{ $user->last_name }}">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                @include('admin.partials.field-error', ['field' => 'phone'])
                <input type="text" required class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                @include('admin.partials.field-error', ['field' => 'email'])
                <input type="text" required class="form-control" name="email" id="email" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label for="social_web">Website</label>
                @include('admin.partials.field-error', ['field' => 'social_web'])
                <input type="text" required class="form-control" name="social_web" id="social_web"
                       value="{{ $user->social_web }}">
            </div>

            <div class="form-group">
                <label for="social_youtube">YouTube</label>
                @include('admin.partials.field-error', ['field' => 'social_youtube'])
                <input type="text" required class="form-control" name="social_youtube" id="social_youtube"
                       value="{{ $user->social_youtube }}">
            </div>

            <div class="form-group">
                <label for="social_twitter">Twitter</label>
                @include('admin.partials.field-error', ['field' => 'social_twitter'])
                <input type="text" required class="form-control" name="social_twitter" id="social_twitter"
                       value="{{ $user->social_twitter }}">
            </div>

            <div class="form-group">
                <label for="social_facebook">Facebook</label>
                @include('admin.partials.field-error', ['field' => 'social_facebook'])
                <input type="text" required class="form-control" name="social_facebook" id="social_facebook"
                       value="{{ $user->social_facebook }}">
            </div>

            <div class="form-group">
                <label for="interests">Interests</label>
                @include('admin.partials.field-error', ['field' => 'interests'])
                <select name="interests[]" id="interests" class="form-control" multiple="multiple">
                    @foreach($genres as $interest)
                        <option {{ $user->interests->contains($interest->id) ? 'selected' : null }} value="{{ $interest->id }}">{{ $interest->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="genres">Genres</label>
                @include('admin.partials.field-error', ['field' => 'genres'])
                <select name="genres[]" id="genres" class="form-control" multiple="multiple">
                    @foreach($genres as $genre)
                        <option {{ $user->genres->contains($genre->id) ? 'selected' : null }} value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password">Role</label>
                @include('admin.partials.field-error', ['field' => 'role'])
                <select name="role" required id="role" class="form-control">
                    <option>Select a Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : null }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                @include('admin.partials.field-error', ['field' => 'password'])
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                @include('admin.partials.field-error', ['field' => 'password_confirmation'])
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
            </div>

            <input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
        </form>

    </div>
@endsection

@push('scripts')
    <script>
      jQuery(function ($) {
        $('#interests').select2()
        $('#genres').select2()
      })
    </script>
@endpush
