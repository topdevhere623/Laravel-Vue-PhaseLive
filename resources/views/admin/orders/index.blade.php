@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Orders <small>{{ $filter }}</small></h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group mr-2">
				<a href="{{ url('admin/orders/create') }}" class="btn btn-sm btn-outline-secondary">New Order</a>
			</div>
		</div>
	</div>

	<form action="{{ url()->current() }}" method="post">
		@csrf

		@include('admin.orders.partials.filters', ['filter' => $filter])

		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th><input type="checkbox" class="select-all"></th>
						<th>ID</th>
						<th>Purchaser</th>
						<th>Subtotal</th>
						<th>Tax</th>
						<th>Total</th>
						<th>Status</th>
						<th>Updated</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $order)
						<tr>
							<td><input type="checkbox" name="selected[]" class="page" value="{{ $order->id }}"></td>
							@include('admin.orders.partials.id', ['partial' => $order])
							<td><a href="{{ url('admin/users/edit', $order->purchaser->id) }}">{{ $order->purchaser->name }}</a></td>
							<td>{{ $order->sub_total }}</td>
							<td>{{ $order->tax }}</td>
							<td>{{ $order->total }}</td>
							<td>{{ $order->status }}</td>
							<td>{{ $order->updated_at }}</td>
							<td>{{ $order->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{{ $orders->links() }}
		</div>
	</form>

	{{--{{ $pages->links() }}--}}
@endsection

@push('styles')
	<style>
		.children td:not(:first-child) {
			padding-left: 25px;
		}
	</style>
@endpush
