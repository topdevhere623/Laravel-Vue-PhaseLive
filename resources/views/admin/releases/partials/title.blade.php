<td class="has-actions">
	@if ($filter == 'trashed')
		{{ \Illuminate\Support\Str::limit($partial->name, 30) }}
	@else
		<a href="{{ url('/admin/releases/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($partial->name, 30) }}</a>
	@endif

	<div class="row-actions">
		@if ($filter != 'trashed')
			<span class="view">
				<a href="{{ url('/release/' . $partial->slug) }}">View</a>
			</span>
			@if ($filter == 'live' || $partial->status == 'live')
				<span class="take-offline">
				<a href="{{ url('/admin/releases/take-offline/' . $partial->id) }}">Take Offline</a>
			</span>
			@elseif ($filter == 'pending' || $partial->status == 'pending')
				<span class="approve">
				<a href="{{ url('/admin/releases/approve/' . $partial->id) }}">Approve</a>
			</span>
			@elseif ($filter == 'offline' || $partial->status == 'offline')
				<span class="put-online">
				<a href="{{ url('/admin/releases/make-live/' . $partial->id) }}">Make Live</a>
			</span>
			@endif
			<span class="bin">
			<a href="{{ url('/admin/releases/delete/' . $partial->id) }}">Bin</a>
		</span>
		@endif
		@if ($filter == 'trashed')
			<span class="restore">
				<a href="{{ url('/admin/releases/restore/' . $partial->id) }}">Restore</a>
			</span>
			|
			<span class="bin">
				<a href="{{ url('/admin/releases/destroy/' . $partial->id) }}">Delete</a>
			</span>
		@endif
	</div>
</td>
