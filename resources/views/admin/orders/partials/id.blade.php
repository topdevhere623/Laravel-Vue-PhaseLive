<td class="has-actions">
	{{ $partial->id }}

	<div class="row-actions">
		<span class="complete">
			<a href="{{ url('/admin/orders/complete/' . $partial->id) }}">Complete</a>
		</span>
		|
		<span class="suspend">
			<a href="{{ url('/admin/orders/pending/' . $partial->id) }}">Suspend</a>
		</span>
		|
		<span class="cancel">
			<a href="{{ url('/admin/orders/cancelled/' . $partial->id) }}">Cancel</a>
		</span>
		<span class="bin">
			<a href="{{ url('/admin/orders/delete/' . $partial->id) }}">Bin</a>
		</span>
	</div>
</td>
