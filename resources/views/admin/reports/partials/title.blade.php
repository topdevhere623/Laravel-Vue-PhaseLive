<td class="has-actions">
	<div class="row-actions">
		<span class="edit">
			<a href="{{ url('/admin/reports/view/' . $partial->id) }}">View</a>
		</span>
		|
		@if ($filter == 'acknowledged')
			<span class="restore">
				<a href="{{ url('/admin/reports/unacknowledge/' . $partial->id) }}">Unacknowledge</a>
			</span>
			|
		@elseif ($filter == 'unacknowledged')
			<span class="restore">
				<a href="{{ url('/admin/reports/acknowledge/' . $partial->id) }}">Acknowledge</a>
			</span>
			|
		@endif
		<span class="bin">
			<a href="{{ url('/admin/reports/delete/' . $partial->id) }}">Delete</a>
		</span>
	</div>
</td>
