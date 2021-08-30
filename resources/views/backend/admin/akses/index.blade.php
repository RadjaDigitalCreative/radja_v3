@extends('layout.main')
@section('title', $title)
@section('content')
@if(auth()->user()->level == 'Owner') 
<div class="card ">
	<div class="card-header ">
		<h4 class="card-title">Menu Pengguna</h4>
		@if(auth()->user()->id_team == 1)
		<a  href="{{route('hargatabel.list')}}"><button type="button" class="btn btn-primary"><i class="now-ui-icons design_bullet-list-67"></i> Tabel Menu Harga</button></a>
		@endif
	</div>
	<form name="myform" method="post" action="{{route('akses.store')}}" class="form-horizontal">
		@csrf
		<div class="card-body ">
			<div class="row">
				<label class="col-sm-2 col-form-label">Nama Pengguna</label>
				<div class="col-sm-8">
					<div class="form-group has-success">
						<select class="form-control" name="user_id" required="">
							<option value="">-- Pilih Nama Pengguna --</option>
							@foreach ($user as $row)
							<option value="{{$row->id}}">{{$row->name}} ({{$row->level}})</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">	
				<label class="col-sm-2 col-form-label">Menu</label>
				<div class="col-sm-4 col-sm-offset-1 checkbox-radios">
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_admin" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Beranda
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_akses" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Management
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_supplier" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Supplier
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_kategori" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Kategori
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_kas" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Kas
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_stok" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Stock
						</label>
					</div>
				</div>
				<div class="col-sm-4 col-sm-offset-1 checkbox-radios">
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_produk" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Produk
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_order" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Order 
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_pay" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Pembayaran
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_report" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Laporan
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_cabang" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses Cabang
						</label>
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input name="is_user" value="1" id="check_list" class="form-check-input" type="checkbox">
							<span class="form-check-sign"></span>
							Akses User
						</label>
					</div>
				</div>

			</div>
		</div>
		<div class="card-footer ">
			<button type="reset" class="btn btn-fill btn-danger">Reset</button>
			<input  id="Check_All" type="button" value="Check All"
			onClick="Check(document.myform.check_list)" class="btn btn-fill btn-success"></input>
			<button style="float: right;" type="submit" class="btn btn-fill btn-primary">Submit</button>
		</div>
	</form>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{$title}}</h4>
				<!-- Example split danger button -->
				<div  class="btn-group">

				</div>
			</div>
			<div class="card-body">
				<div class="toolbar">
				</div>
				<table id="scrool" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>akses_beranda</th>
							<th>akses_manage</th>
							<th>akses_supplier</th>
							<th>akses_kategori</th>
							<th>akses_produk</th>
							<th>akses_order</th>
							<th>akses_pay</th>
							<th>akses_report</th>
							<th>akses_kas</th>
							<th>akses_stok</th>
							<th>akses_cabang</th>
							<th>akses_user</th>
							<!-- <th class="disabled-sorting text-right">Actions</th> -->
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>akses_beranda</th>
							<th>akses_manage</th>
							<th>akses_supplier</th>
							<th>akses_kategori</th>
							<th>akses_produk</th>
							<th>akses_order</th>
							<th>akses_pay</th>
							<th>akses_report</th>
							<th>akses_kas</th>
							<th>akses_stok</th>
							<th>akses_cabang</th>
							<th>akses_user</th>
							<!-- <th class="disabled-sorting text-right">Actions</th> -->
						</tr>
					</tfoot>
					<tbody>
						@php
						$nomor = 1;
						@endphp
						@foreach ($data as $row)
						
						<tr>
							<td>{{$nomor++}}</td>
							<td>{{$row->name}} ({{$row->level}})</td>
							@if ($row->is_admin == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif

							@if ($row-> is_akses == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_supplier == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_kategori == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_produk == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_order == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_pay == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_report == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_kas == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_stok == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_cabang == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
							@if ($row-> is_user == 1)
							<td>Ya</td>
							@else
							<td>Tidak</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-body">
				<div class="toolbar">
				</div>
				<table id="scrool" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Purcahse</th>
							<th>Nama Cabang</th>
							<th>Dibuat</th>
							
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Nama Purcahse</th>
							<th>Nama Cabang</th>
							<th>Dibuat</th>
							
						</tr>
					</tfoot>
					<tbody>
						@php
						$nomor = 1;
						@endphp
						@foreach ($role_cabang as $row)
						<tr>
							<td>{{$nomor++}}</td>
							<td>{{$row->name}}</td>
							<td>{{$row->nama_cabang}}</td>
							<td>{{$row->created_at}}</td>
							
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
		<h4 class="card-title">Purchase Cabang</h4>
	</div>
	<form method="post" action="{{route('akses.show')}}" method="post" action="{{route('akses.show')}}" class="form-horizontal">
		@csrf
		<div class="card-body ">
			<div class="row">
				<label class="col-sm-2 col-form-label">Nama Pengguna</label>
				<div class="col-sm-8">
					<div class="form-group has-success">
						<select class="form-control" name="user_id"> 
							<option value="">-- Pilih Nama Pengguna --</option>
							@foreach ($user as $row)
							@if ($row->level == 'Purchase')
							<option value="{{$row->id}}">{{$row->name}} ({{$row->level}})</option>
							@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-2 col-form-label">Cabang</label>
				<div class="col-sm-4 col-sm-offset-1 checkbox-radios">
					@foreach ($cabang as $row)
					<div class="form-check">
						<label class="form-check-label">
							<input name="cabang[]" value="{{$row->nama_cabang}}" class="form-check-input" type="checkbox">
							<span class="form-check-sign">{{$row->nama_cabang}}</span>
						</label>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<button type="reset" class="btn btn-fill btn-danger">Reset</button>
			<button type="submit" class="btn btn-fill btn-primary">Submit</button>

		</div>
	</form>
</div>
@endif
@section('script')
<script type="text/javascript">
	function Check(chk)
	{
		if(document.myform.Check_All.value=="Check All"){
			for (i = 0; i < chk.length; i++)
				chk[i].checked = true ;
			document.myform.Check_All.value="Uncheck All";
		}else{

			for (i = 0; i < chk.length; i++)
				chk[i].checked = false ;
			document.myform.Check_All.value="Check All";
		}
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#scrool').DataTable( {
			"scrollX": true
		} );
	} );
</script>
@endsection
@endsection
