@extends('layout.main')
@section('title', $title)
@section('style')
@endsection
<style type="text/css">
body {
	background: rgb(204,204,204); 
}
page {
	background: white;
	display: block;
	margin: 0 auto;
	margin-bottom: 0.5cm;
	box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
	padding: 10;
	width: 23cm;
	height: 29.7cm; 
}
page[size="A4"][layout="landscape"] {
	width: 29.7cm;
	height: 21cm;  
}
page[size="A3"] {
	width: 29.7cm;
	height: 42cm;
}
page[size="A3"][layout="landscape"] {
	width: 42cm;
	height: 29.7cm;  
}
page[size="A5"] {
	width: 14.8cm;
	height: 21cm;
}
page[size="A5"][layout="landscape"] {
	width: 21cm;
	height: 14.8cm;  
}
@media print {
	body, page {
		margin: 0;
		box-shadow: 0;
	}
}
.line{
	margin-bottom: 0.5cm;

}
.center {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 20px;
}
.ami {
	font-size: 5px;
	line-height: 0.01%;
	text-align: center;
}
</style>
@section('content')
<div class="card ">
	<div class="card-header ">
		<h4 class="card-title">{{$title}}</h4>
	</div>
	<div class="card-body ">
		@foreach($data as $row)
		<form method="post" method="post" action="{{route('product.item.qc.copy.store', $row->id)}}" class="form-horizontal">
			@csrf
			<div class="row">
				<label class="col-md-3 col-form-label">Ukuran Pola QR</label>
				<div class="col-md-5">
					<div class="form-group">
						<input type="number" name="qc_print" class="form-control" required="">
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-md-3 col-form-label">Jumlah Copian</label>
				<div class="col-md-5">
					<div class="form-group">
						<input type="number" name="qc_copy" class="form-control" required="">
					</div>
				</div>
			</div>

			<div class="card-footer ">
				<div class="row">
					<label class="col-md-3"></label>
					<div class="col-md-9">
						<button type="reset" class="btn btn-fill btn-danger">Reset</button>
						<button type="submit" class="btn btn-fill btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</form>
		@endforeach

	</div>
</div>

<page size="A4">
	<div class="row">
		<?php 
		foreach ($data as $row) {
			if ($row->qc_print == NULL && $row->qc_copy == NULL) {
				$ukuran = 400;
				$copy = 1;
			}elseif($row->qc_print != NULL && $row->qc_copy != NULL){
				$ukuran = $row->qc_print;
				$copy = $row->qc_copy;
			}
			
			?>

			<?php 
			for ($i=0; $i < $copy ; $i++) {
		
				?>
				<div class="col-md-3">
					<div class="card">
						<p class="card-text text-center">{!! QrCode::size($ukuran)->generate($row->qc); !!}</p>
						<p class="ami">Nama Produk: {{$row->name}}</p>
						<p class="ami">Tgl Produksi: {{$row->tgl_buat_produk}}</p>
						<p class="ami">Exp Produksi: {{$row->tgl_exp_produk}}</p>
						<p class="ami">Perusahaan: {{$row->supplier}}</p>
					</div>
				</div>
				<?php
			}
		}?>
	</div>
</page>
<div class="card ">
	<div class="card-header ">
	</div>
	<div class="card-body ">

		<a class="center" target="_blank" href="{{ route('product.item.qc.print', $row->id)}}"><button type="button" class="btn btn-fill btn-warning">Print</button></a>

	</div>
	<div class="card-footer ">

	</div>
</div>

@endsection
