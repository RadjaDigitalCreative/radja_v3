@extends('layout.main')
@section('title', $title)
@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{$title2}}</h4>

			</div>
			<div class="card-body">
				<div class="toolbar">
				</div>
				<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Bulan</th>
							<th>Harga</th>
							<th class="disabled-sorting text-center">Actions</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Bulan</th>
							<th>Harga</th>
							<th class="disabled-sorting text-center">Actions</th>
						</tr>
					</tfoot>
					<tbody>
						@php
						$nomor = 1;
						function rupiah($m)
						{
							$rupiah = "Rp ".number_format($m,0,",",".").",-";
							return $rupiah;
						}
						@endphp
						@foreach ($listharga as $row)
						<tr>
							<td>{{$nomor++}}</td>
							<td>{{$row->bulan}} Bulan</td>
							<td>{{rupiah($row->harga)}}</td>
							<td class="text-center">
								<form id="data-{{ $row->id }}" action="{{route('menuharga.delete',$row->id)}}" method="post">
									{{csrf_field()}}
									{{method_field('delete')}}
								</form>
								@csrf
								@method('DELETE')
								<button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-fill btn-danger"><i class="fas fa-times"></i> Hapus</button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
<div class="card ">
	<div class="card-header ">
		<h4 class="card-title">{{$title}}</h4>
	</div>
	<div class="card-body ">
		<form method="post" action="{{route('menuharga.store')}}" class="form-horizontal">
			@csrf
			<div id="app">
				<div class="row" v-for="(order, index) in orders" :key="index">
					<label class="col-md-3 col-form-label">Jumlah Bulan</label>
					<div class="col-md-2">
						<div class="form-group">
							<input  type="number" placeholder="Bulan" name="bulan[]" class="form-control" required="">
						</div>
					</div>
					<label class="col-md-3 col-form-label">Harga Total</label>
					<div class="col-md-3">
						<div class="form-group">
							<input  type="number" name="harga[]" class="form-control" required="">
						</div>
					</div>
					<button type="button" class="btn btn-danger btn-sm" @click="delOrder(index)"><i class="fa fa-trash"></i></button>
					<button type="button" class="btn btn-success btn-sm" @click="addOrder()" ><i class="fa fa-plus"></i></button>
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<div class="row">
				<label class="col-md-3"></label>
				<div class="col-md-9">
					<button type="reset" class="btn btn-fill btn-danger">Reset</button>
					<button type="submit" class="btn btn-fill btn-warning">Buat Harga</button>
				</div>
			</div>
		</div>
	</form>
</div>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script type="text/javascript">
	new Vue({
		el: '#app',
		data: {
			orders: [
			{pesanan: 0, nama: "", harga: 0, jumlah: 1, subtotal: 0},
			],
			discount: 0,
			note: "",
		},
		methods: {
			addOrder(){
				var orders = {pesanan: 0, nama: "", harga: 0, jumlah: 1, subtotal: 0};
				this.orders.push(orders);
			},
			delOrder(index){
				if (index > 0){
					this.orders.splice(index,1);
				}
			},
		},
	});
</script>
@endsection
@endsection