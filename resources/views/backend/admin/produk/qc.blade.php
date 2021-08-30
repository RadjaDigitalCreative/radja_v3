@extends('layout.main')
@section('title', $title)
@section('content')
@include('backend.admin.produk.import')

@foreach ($data as $row)
<!-- modal buat QC controller -->
<div class="modal fade" id="staticBackdrop-{{$row->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">{{$row->name}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action=" {{ route('product.item.qc.store') }}" method="post">

				<div class="modal-body">
					Silahkan masukkan keterangan produk yang telah dipilih. <br><br>
					@csrf
					<div class="row">
						<label class="col-md-3 col-form-label">Type Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<select name="qc_status" class="form-control" required="">
									<option> -- Silahkan Masukkan Pilihan -- </option>
									<option value="Asli">Asli</option>
									<option value="Palsu">Palsu</option>
									<option value="Bekas">Bekas</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Nama Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" readonly="" class="form-control" value="{{$row->name}}">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Tgl Buat Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="date" class="form-control" name="tgl_produk" >

							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Tgl Exp Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="date" class="form-control" name="exp_produk" >
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Perusahaan</label>
						<div class="col-md-9">
							<div class="form-group">
								<select name="supplier" class="form-control" required="">
									<option> -- Tentukan Supplier Produk -- </option>
									@foreach($supplier as $sup)
									<option value="{{$sup->perusahaan}}">{{$sup->nama}} / {{$sup->perusahaan}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<input type="hidden" name="id" value="{{ $row->id}}">

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Create QC</button>
				</div>
			</form>

		</div>
	</div>
</div>
@endforeach
<!-- modal buat QC controller -->
@foreach ($data as $row)

<!-- modal update QC controller -->
<div class="modal fade" id="staticBackdrop2-{{$row->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">{{$row->name}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action=" {{ route('product.item.qc.store') }}" method="post">

				<div class="modal-body">
					Silahkan masukkan keterangan produk yang telah dipilih. <br><br>
					@csrf
					<div class="row">
						<label class="col-md-3 col-form-label">Type Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<select name="qc_status" class="form-control" required="">
									<option value="{{$row->qc_status}}"> {{$row->qc_status}}</option>
									<option value="Asli">Asli</option>
									<option value="Palsu">Palsu</option>
									<option value="Bekas">Bekas</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Nama Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" readonly="" class="form-control" value="{{$row->name}}">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Tgl Buat Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="date" class="form-control" name="tgl_produk" value="{{$row->tgl_buat_produk}}">

							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Tgl Exp Produk</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="date" class="form-control" name="exp_produk" value="{{$row->tgl_exp_produk}}">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-3 col-form-label">Perusahaan</label>
						<div class="col-md-9">
							<div class="form-group">
								<select name="supplier" class="form-control" required="">
									<option value="{{$row->supplier}}"> {{$row->supplier}} </option>
									@foreach($supplier as $sup)
									<option value="{{$sup->perusahaan}}">{{$sup->nama}} / {{$sup->perusahaan}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<input type="hidden" name="id" value="{{ $row->id}}">

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Update QC</button>
				</div>
			</form>

		</div>
	</div>
</div>
@endforeach
<!-- modal update QC controller -->

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{$title}}</h4>
				
			</form>
			<!-- Example split danger button -->

		</div>
		<div class="card-body filterable">
			<div class="toolbar">
			</div>
			<table id="table-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Cabang Toko</th>
						<th>Merk</th>
						<th>Stock</th>
						<th>Status</th>
						<th width="18%" class="disabled-sorting text-center">Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr class="filters">
						<th>#</th>
						<th><input type="text" class="form-control" placeholder="Nama" disabled></th>
						<th><input type="text" class="form-control" placeholder="Cabang Toko" disabled></th>
						<th><input type="text" class="form-control" placeholder="Merk" disabled></th>
						<th><input type="text" class="form-control" placeholder="Stock" disabled></th>
						<th><input type="text" class="form-control" placeholder="Status" disabled></th>
						<th><button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button></th>
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
					@foreach ($data as $row)
					@if((auth()->user()->level == 'Admin') && ($row->lokasi) == (auth()->user()->lokasi))
					<tr>
						<td>{{$nomor++}}</td>
						<?php 
						$num_char =15;
						?>
						<td width="30%">{{$row->name}}</td>
						<td>{{$row->lokasi}}</td>
						<td>{{$row->merk}}</td>
						<td>
							@if ($row->stock < $row->stock_minim )
							<b>{{$row->stock}}</b> {{$row->satuan}}
							@else
							{{$row->stock}} {{$row->satuan}}
							@endif
						</td>
						<td>{{$row->qc_status}}</td>
						<td class="text-right">

						</td>
					</tr>

					<!-- base owner -->
					@elseif((auth()->user()->level == 'Owner'))
					<tr>
						<td>{{$nomor++}}</td>
						<?php 
						$num_char =15;
						?>
						<td width="30%">{{$row->name}}</td>
						<td>{{$row->lokasi}}</td>
						<td>{{$row->merk}}</td>

						<td>
							@if ($row->stock < $row->stock_minim )
							<b>{{$row->stock}}</b> {{$row->satuan}}
							@else
							{{$row->stock}} {{$row->satuan}}
							@endif
						</td>
						<td>{{$row->qc_status}}</td>

						<td class="text-center">
							@if($row->qc_status == NULL && $row->qc == NULL)
							<button data-toggle="modal" data-target="#staticBackdrop-{{$row->id}}" type="button" class="btn btn-primary btn-sm">Create QC Product</button>
							@else
							<button data-toggle="modal" data-target="#scan-{{$row->id}}" type="button" >Qr {!! QrCode::size(50)->generate($row->qc); !!}</button>
							<!-- modal buat QC controller -->
							<div class="modal fade" id="scan-{{$row->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="staticBackdropLabel">Scan QR Code</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											{!! QrCode::size(250)->generate($row->qc); !!}
											<hr>
											<div class="row">
												<label class="col-md-4 col-form-label">Nama Produk</label>
												<div class="col-md-7">
													<label class="col-form-label">{{$row->name}}</label>
												</div>
											</div>
											<div class="row">
												<label class="col-md-4 col-form-label">Tgl Buat Produk</label>
												<div class="col-md-7">
													<label class="col-form-label">{{$row->tgl_buat_produk}}</label>
												</div>
											</div>
											<div class="row">
												<label class="col-md-4 col-form-label">Tgl Exp Produk</label>
												<div class="col-md-7">
													<label class="col-form-label">{{$row->tgl_exp_produk}}</label>
												</div>
											</div>
											<div class="row">
												<label class="col-md-4 col-form-label">Perusahaan</label>
												<div class="col-md-7">
													<label class="col-form-label">{{$row->supplier}}</label>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<a href="{{ route('product.item.qc.view', $row->id)}}"><button type="button" class="btn btn-primary">Atur Pola Print QC</button></a>
											<button data-dismiss="modal" data-toggle="modal" data-target="#staticBackdrop2-{{$row->id}}" type="button" class="btn btn-success">Update QC Product</button>
										</div>
									</div>
								</div>
							</div>
							<!-- modal buat QC controller -->
							@endif
						</td>
					</tr>
					@elseif((auth()->user()->level == 'Purchase') && ($row->stock < $row->stock_minim ))
					<tr>
						<td>{{$nomor++}}</td>
						<?php 
						$num_char =15;
						?>
						<td width="30%">{{$row->name}}</td>
						<td>{{$row->lokasi}}</td>
						<td>{{$row->merk}}</td>
						<td>
							@if ($row->stock < $row->stock_minim )
							<b>{{$row->stock}}</b> {{$row->satuan}}
							@else
							{{$row->stock}} {{$row->satuan}}
							@endif
						</td>
						<td>{{$row->qc_status}}</td>

						<td class="text-right">

						</td>
					</tr>
					@endif

					@endforeach
				</tbody>
			</table>
			@foreach ($data as $row)

			@include('backend.admin.produk.modal')  
			@include('backend.admin.produk.sold')  
			@endforeach

		</div>
	</div>
</div>
</div>


@section('script')
<script type="text/javascript"> 
	$(document).ready(function () {
		$('#table-datatables').DataTable({
			"scrollX": true,
			lengthMenu: [5, 10, 20, 50, 100, 200, 500, 1000],
			pagingType: 'numbers',
			dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
		});
	});
</script>
<script type="text/javascript"> 
	$(document).ready( function () {
		$('#table-sold').DataTable({
			dom: 'Bfrtip',
			"searching": false,
			"ordering": false,
			"bInfo": false,
			"bPaginate": false,
			buttons: [ 'excel'],
		});
	} );
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.filterable .btn-filter').click(function(){
			var $panel = $(this).parents('.filterable'),
			$filters = $panel.find('.filters input'),
			$tbody = $panel.find('.table tbody');
			if ($filters.prop('disabled') == true) {
				$filters.prop('disabled', false);
				$filters.first().focus();
			} else {
				$filters.val('').prop('disabled', true);
				$tbody.find('.no-result').remove();
				$tbody.find('tr').show();
			}
		});

		$('.filterable .filters input').keyup(function(e){
			/* Ignore tab key */
			var code = e.keyCode || e.which;
			if (code == '9') return;
			/* Useful DOM data and selectors */
			var $input = $(this),
			inputContent = $input.val().toLowerCase(),
			$panel = $input.parents('.filterable'),
			column = $panel.find('.filters th').index($input.parents('th')),
			$table = $panel.find('.table'),
			$rows = $table.find('tbody tr');
			/* Dirtiest filter function ever ;) */
			var $filteredRows = $rows.filter(function(){
				var value = $(this).find('td').eq(column).text().toLowerCase();
				return value.indexOf(inputContent) === -1;
			});
			/* Clean previous no-result if exist */
			$table.find('tbody .no-result').remove();
			/* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
			$rows.show();
			$filteredRows.hide();
			/* Prepend no-result row if all rows are filtered */
			if ($filteredRows.length === $rows.length) {
				$table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
			}
		});
	});
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')
@endsection
@endsection
