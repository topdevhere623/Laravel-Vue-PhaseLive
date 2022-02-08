@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Release</h1>
    </div>

    <div>
        <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                @include('admin.partials.field-error', ['field' => 'name'])
                <input type="text" class="form-control" name="name" id="name" value="{{ $release->name }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                @include('admin.partials.field-error', ['field' => 'description'])
                <textarea class="form-control" name="description"
                          id="description">{{ $release->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                @include('admin.partials.field-error', ['field' => 'price'])
                <input type="number" class="form-control" name="price" id="price" value="{{ $release->price }}">
            </div>

            <div class="form-group">
                <label for="class">Class</label>
                @include('admin.partials.field-error', ['field' => 'class'])
                <input type="text" class="form-control" name="class" id="class" value="{{ $release->class }}">
            </div>

            <div class="form-group">
                <label for="royalty_fee">Royalty Fee (%)</label>
                @include('admin.partials.field-error', ['field' => 'royalty_fee'])
                <input type="number" min="0" class="form-control" name="royalty_fee" id="class"
                       value="{{ $release->royalty_fee }}">
            </div>

            <div class="form-group">
                <label for="release-date">Release Date</label>
                @include('admin.partials.field-error', ['field' => 'release_date'])
                <input type="text" class="form-control" name="release-date" id="release-date"
                       value="{{ $release->release_date }}">
            </div>

            <div class="form-group">
                <label for="uploaded-by">Uploaded By</label>
                @include('admin.partials.field-error', ['field' => 'uploaded_by'])
                <input type="text" disabled class="form-control" name="uploaded-by" id="uploaded-by"
                       value="{{ $release->uploader->name }}">
            </div>
            <div class="form-group">
                <label for="genres">Genres</label>
                @include('admin.partials.field-error', ['field' => 'genres'])
                <genre-select :populated="{{ $release->genres }}"></genre-select>
            </div>

            {{--			<div class="form-group">--}}
            {{--				@include('admin.partials.field-error', ['field' => 'price'])--}}
            {{--				<div class="form-check">--}}
            {{--					<input type="hidden" name="featured" value="0">--}}
            {{--					<input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" @if($release->featured) checked @endif>--}}
            {{--					<label class="form-check-label" for="featured">--}}
            {{--						Featured--}}
            {{--					</label>--}}
            {{--				</div>--}}
            {{--			</div>--}}

            @if ($release->isFeatured())
                <div class="form-group">
                    <label for="featured_dates">Featured Dates</label>
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <td>Date</td>
                            <td>Approved</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($release->featuredDates as $date)
                        <tr>
                            <td>{{ $date->featured_date }}</td>
                            <td>{{ $date->approved_at ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="/admin/releases/featured-date/{{ $date->id }}/approve">Approve</a>
                                <a href="/admin/releases/featured-date/{{ $date->id }}/decline">Decline</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
        </form>
    </div>
@endsection
