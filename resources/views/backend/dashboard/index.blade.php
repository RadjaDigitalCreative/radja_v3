@extends('layout.main')
@section('title', $title)

@section('content')

@foreach($bayar as $row)
@if($row->dibayar >= now() && auth()->user()->id == $row->user_id)
<div class="row">
	<div class="col-lg-4">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Akses</h5>
				<h4 class="card-title">Hak Akses</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_akses == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/akses/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons education_atom"></i>
					</button></a>

					@endif
					@endforeach
				</div>
			</div>
			<div class="card-body">
				
			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Supplier</h5>
				<h4 class="card-title">Supplier Toko</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_supplier == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/supplier/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons users_circle-08"></i>
					</button></a>
					@endif
					@endforeach
				</div>
			</div>
			<div class="card-body">
			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons arrows-1_refresh-69"></i> {{count($sup)}} Supplier
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Item</h5>
				<h4 class="card-title">Item Tersedia</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_produk == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/item/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons files_box"></i>
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($pro)}} Item
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Pesanan</h5>
				<h4 class="card-title">Pesanan</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_order == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/order/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons shopping_bag-16"></i>
						
					</button></a>
					@endif
					@endforeach
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Pesanan
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Pembayaran</h5>
				<h4 class="card-title">Pembayaran</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_pay == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/payment/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons business_money-coins"></i>
						
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($pay)}} Metode
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Petugas</h5>
				<h4 class="card-title">Petugas Kasir</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_user == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/user/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons users_single-02"></i>
						
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($usr)}} Kasir
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Penjualan</h5>
				<h4 class="card-title">Laporan Penjualan</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_order == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/report/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons business_badge"></i>

					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Penjualan
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Pembeli</h5>
				<h4 class="card-title">Laporan Pembeli</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_order == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/report/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons business_badge"></i>

					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Pembeli
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Kas</h5>
				<h4 class="card-title">Laporan Kas</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_kas == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/kas/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons business_globe"></i>
						
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Barang
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Restock</h5>
				<h4 class="card-title">Restock Barang</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_stok == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/restock/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons health_ambulance"></i>
						
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Barang
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Cabang</h5>
				<h4 class="card-title">Cabang Toko</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_cabang == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/cabang/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons location_compass-05"></i>
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Cabang
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Pegawai</h5>
				<h4 class="card-title">Pegawai Kami</h4>
				<div class="dropdown">
					@foreach ($role as $row)
					@if($row->is_cabang == 1 && $row->user_id == auth()->user()->id)
					<a href="{{url('/admin/cabang/')}}"><button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret">
						<i class="now-ui-icons location_compass-05"></i>
					</button></a>
					@endif
					@endforeach
					
				</div>
			</div>
			<div class="card-body">

			</div>
			<div class="card-footer">
				<div class="stats">
					<i class="now-ui-icons ui-2_time-alarm"></i> {{count($ord)}} Pegawai
				</div>
			</div>
		</div>
	</div>
</div>
@elseif($row->dibayar <= now() && auth()->user()->id == $row->user_id)
<div class="row">
	<div class="col-lg-12">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Masa Pemakaian Telah Habis</h5>
				<h4 class="card-title">Silahkan Lakukan Pembayaran</h4>
				<div class="dropdown">

				</div>
			</div>
			<div class="card-body">
				@if (session('resent'))
				<div class="alert alert-success" role="alert">
					{{ __('A fresh verification link has been sent to your email address.') }}
				</div>
				@endif

				Sebelum menggunakan aplikasi kasir silahkan lakukan pembayaran pada menu user payment, yang telah tertera dibawah ini.
				
				<div class="card-footer">
					<div class="stats">
						<i class="now-ui-icons business_money-coins"></i>  <a href="{{url('/admin/user')}}"><button class="btn btn-link p-0 m-0 align-baseline">Bayar Sekarang</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif 
@endforeach

@endsection
