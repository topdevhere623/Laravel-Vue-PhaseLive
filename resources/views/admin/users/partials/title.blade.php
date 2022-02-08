<td class="has-actions">
	@if ($filter == 'trashed')
		{{ \Illuminate\Support\Str::limit($partial->name, 30) }}
	@else
		<a href="{{ url('/admin/users/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($partial->name, 30) }}</a>
	@endif

	<div class="row-actions">
		@if ($filter != 'trashed')
			<span class="view">
				<a href="{{ url('/user/' . $partial->path) }}">View</a>
			</span>
		|
			<span class="edit">
				<a href="{{ url('/admin/users/edit/' . $partial->id) }}">Edit</a>
            </span>
		@endif

		@if (Auth::id() != $partial->id)
			|

			@if ($filter == 'trashed')
				<span class="restore">
					<a href="{{ url('/admin/users/restore/' . $partial->id) }}">Restore</a>
				</span>
				|
				<span class="bin">
					<a href="{{ url('/admin/users/destroy/' . $partial->id) }}">Delete</a>
				</span>
            @else
                <span>
                    @if($user->status == 'active')
                        <a href="{{ url('/admin/users/freeze/' . $partial->id) }}">Freeze</a>
                    @else
                        <a href="{{ url('/admin/users/activate/' . $partial->id) }}">Activate</a>
                    @endif

                </span>
				|
				<span class="bin">
					<a href="{{ url('/admin/users/ban/' . $partial->id) }}">Ban</a>
				</span>
                |
				<span class="bin">
					<a href="{{ url('/admin/users/delete/' . $partial->id) }}">Bin</a>
                </span>
            @endif
            | 
            
            @if(!$partial->approved_at)
            	<a class="text-primary" title="Verify" href="{{ url('/admin/users/approve/' . $partial->id) }}">
            		<i class=' fa fa-check-circle'></i>
            	</a>
            @else
            	<a class="text-danger" title="Unverify" href="{{ url('/admin/users/unapprove/' . $partial->id) }}">
            		<i class=" fa fa-times-circle"></i>
            	</a>
            @endif
		@endif
	</div>
</td>
