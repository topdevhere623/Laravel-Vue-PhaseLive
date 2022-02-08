<td class="has-actions">
	<a href="{{ url('/admin/tracks/edit/'.$partial->id) }}">{{ $partial->name }}</a>
	<div class="row-actions">
		<span class="view">
			<a href="{{ url('/track/' . $partial->slug) }}">View</a>
		</span>
		|
		@unless($partial->approved())
		<span class="approve">
			<a href="{{ url('/admin/tracks/approve/' . $partial->id) }}">Approve</a>
		</span>
		|
		@endunless
		<span class="edit">
			<a href="{{ url('/admin/tracks/freeze/' . $partial->id) }}">Freeze</a>
		</span>
		|
		<span class="bin">
			<a href="{{ url('/admin/tracks/destroy/' . $partial->id) }}">Delete</a>
		</span>
	</div>
</td>
