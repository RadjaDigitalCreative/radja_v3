@extends('layout.main')
@section('title', $title)
@section('content')
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
				<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Menu</th>
							<th>Total Bayar</th>
							<th>Action</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Menu</th>
							<th>Total Bayar</th>
							<th>Action</th>

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
						@foreach ($bayar as $row)
						<tr>
							<td>{{$nomor++}}</td>
							<td>{{$row->name}}</td>
							<td>
								{{
									$row->is_admin + 
									$row->is_akses + 
									$row->is_supplier + 
									$row->is_kategori + 
									$row->is_produk + 
									$row->is_order + 
									$row->is_pay + 
									$row->is_report + 
									$row->is_kas + 
									$row->is_stok + 
									$row->is_cabang + 
									$row->is_user 
								}} Menu
							</td>
							<td>
								<?php 
								$admin= 0;
								$akses= 0;
								$supplier= 0;
								$kategori= 0;
								$produk= 0;
								$order= 0;
								$pay= 0;
								$report= 0;
								$kas= 0;
								$stok= 0;
								$cabang= 0;
								$user= 0;
								if ($row->is_admin == 1) {
									$admin= $role_bayar->adminpay;
								}
								if ($row->is_akses) {
									$akses= $role_bayar->aksespay;
								}
								if ($row->is_supplier) {
									$supplier= $role_bayar->supplierpay;
								}
								if ($row->is_kategori) {
									$kategori= $role_bayar->kategoripay;
								}
								if ($row->is_produk) {
									$produk= $role_bayar->produkpay;
								}
								if ($row->is_order) {
									$order= $role_bayar->orderpay;
								}
								if ($row->is_pay) {
									$pay= $role_bayar->payementpay;
								}
								if ($row->is_report) {
									$report= $role_bayar->reportpay;
								}
								if ($row->is_kas) {
									$kas= $role_bayar->kaspay;
								}
								if ($row->is_stok) {
									$stok= $role_bayar->stockpay;
								}
								if ($row->is_cabang) {
									$cabang= $role_bayar->cabangpay;
								}
								$total = $admin + $akses + $supplier + $kategori + $produk + $order + $pay + $report + $kas + $stok +$cabang;
								echo rupiah($total);
								?>
							</td>
							<td>
							
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
@endsection