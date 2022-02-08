@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Tracks</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th><input type="checkbox" class="select-all"></th>
                <th>Track Name</th>
                <th></th>
                <th>Length</th>
                <th>BPM</th>
                <th>Key</th>
                <th>Price</th>
                <th>Status</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
            <tr>
                <td><input type="checkbox" name="selected[]" class="page" value="{{ $track->id }}"></td>
                @include('admin.tracks.partials.title', ['partial' => $track])
                <td>
                    <?php
                    if(isset( $track->streamable->files) )
                    {
                        $trackPath = $track->streamable->files->first()->path;
                    }else{
                        $trackPath = null;
                    }
                    ?>
                    @if($trackPath !== null)
                     <audio src="{{ Storage::url($trackPath)  }}" controls="controls" preload="none">
                            Your browser does not support the <code>audio</code> element.
                     </audio>
                    @endif
                </td>
                <td>{{$track->length}}</td>
                <td>{{$track->bpm}}</td>
                <td>{{$track->key}}</td>
                <td>{{$track->price}}</td>
                <td @if($track->status === 'pending') { 
                    class="bg-danger text-white p-2" 
                } @elseif ($track->status === 'frozen') {
                class="bg-primary text-white p-2" 
                }
                @endif>{{$track->status}}</td>
                <td>{{$track->created_at}}</td>
                <td>{{$track->updated_at}}</td>
            </tr>
            @endforeach
        </tbody>
</table>
</div>

{{ $tracks->links() }}

@endsection