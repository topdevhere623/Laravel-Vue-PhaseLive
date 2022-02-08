@if ($errors->has($field))
    @foreach ($errors->get($field) as $error)
	    <div class="alert alert-danger">
            {{ $error }}
	    </div>
    @endforeach
@endif