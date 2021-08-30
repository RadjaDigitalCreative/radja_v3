@extends('layout.main')
@section('title', $title)
@section('content')
@php
function rupiah($m)
{
	$rupiah = "Rp ".number_format($m,0,",",".").",-";
	return $rupiah;
}
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user">
			<div class="image">
				<!--<img src="http://www.prima-infodata.com/admin/ck/userfiles/images/TB/DSC04922.jpg" alt="...">-->
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="author">
							<a href="#">
								<img class="avatar border-gray" src="{{asset('logo_depan.png')}}" alt="...">
								<h5 class="title">Notifikasi Pembayaran</h5>
							</a>
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Sudah Lunas</a>
									<a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Menunggu Konfirmasi</a>
									<a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Belum Bayar</a>
								</div>
							</nav>
							<br><br>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Email</th>
												<th>Masa Pemakaian</th>
												<th>Status</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Email</th>
												<th>Masa Pemakaian</th>
												<th>Status</th>
											</tr>
										</tfoot>
										<tbody>
											@php 
											$nomor =1;
											@endphp
											@foreach($sudah_bayar as $abs)
											<tr>
												<td>{{$nomor++}}</td>
												<td>{{$abs->name}}</td>
												<td>{{$abs->email}}</td>
												<!-- abs bayar -->
												@if($abs->dibayar >= now() && $abs->pay == 2 && $abs->level == 'super')
												<td>Selamanya</td>
												<td align="center"><button class="btn btn-success">Super Unlimited</button></td>
												@elseif($abs->dibayar >= now() && $abs->pay == 2 )
												<td>Terlunasi</td>
												<td align="center"><button class="btn btn-success">
													<?php 
													$date = date('Y-m-d', strtotime(now()));
													$date2 = date('Y-m-d', strtotime($abs->dibayar));

													$datetime1 = new DateTime($date);
													$datetime2 = new DateTime($date2);
													$interval = $datetime1->diff($datetime2);
													$days = $interval->format('%a');

													echo $days.' hari lagi';
													?>
												</button></td>
												@elseif($abs->pay ==1)
												<form action="{{ route('users.pay.konfirmasi')}}" method="post">
													@csrf
													<input type="hidden" name="user_id" value="{{$abs->id}}">
													<input type="hidden" name="bulan" value="{{$abs->bulan}}">
													<td>Terlunasi</td>
													<td><button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button></td>
												</form>
												@else
												<td>Belum Terlunasi</td>
												<td >Telah Berakhir</span></td>
												<!-- abs bayar -->
												@endif
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
									<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Email</th>
												<th>Masa Pemakaian</th>
												<th>Status</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Email</th>
												<th>Masa Pemakaian</th>
												<th>Status</th>
											</tr>
										</tfoot>
										<tbody>
											@php 
											$nomor =1;
											@endphp
											@foreach($konfirmasi as $abs)
											<tr>
												<td>{{$nomor++}}</td>
												<td>{{$abs->name}}</td>
												<td>{{$abs->email}}</td>
												<!-- abs bayar -->
												@if($abs->dibayar >= now() && $abs->pay == 2 && $abs->level == 'super')
												<td>Selamanya</td>
												<td align="center"><button class="btn btn-success">Super Unlimited</button></td>
												@elseif($abs->dibayar >= now() && $abs->pay == 2 )
												<td>Terlunasi</td>
												<td align="center"><button class="btn btn-success">
													<?php 
													$date = date('Y-m-d', strtotime(now()));
													$date2 = date('Y-m-d', strtotime($abs->dibayar));

													$datetime1 = new DateTime($date);
													$datetime2 = new DateTime($date2);
													$interval = $datetime1->diff($datetime2);
													$days = $interval->format('%a');

													echo $days.' hari lagi';
													?>
												</button></td>
												@elseif($abs->pay ==1)
												<td>Menunggu Konfirmasi</td>
												<td><a href="{{url('admin/user/'.$abs->id.'/edit')}}" data-toggle="modal" data-target="#modal-bukti{{$abs->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-file"></i></a></td>
												@else
												<td>Belum Terlunasi</td>
												<td >Telah Berakhir</span></td>
												<!-- abs bayar -->
												@endif
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
									<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Email</th>
												<th>Masa Pemakaian</th>
												<th>Status</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Email</th>
												<th>Masa Pemakaian</th>
												<th>Status</th>
											</tr>
										</tfoot>
										<tbody>
											@php 
											$nomor =1;
											@endphp
											@foreach($belum_bayar as $abs)
											<tr>
												<td>{{$nomor++}}</td>
												<td>{{$abs->name}}</td>
												<td>{{$abs->email}}</td>
												<!-- abs bayar -->
												@if($abs->dibayar >= now() && $abs->pay == 2 && $abs->level == 'super')
												<td>Selamanya</td>
												<td align="center"><button class="btn btn-success">Super Unlimited</button></td>
												@elseif($abs->dibayar >= now() && $abs->pay == 2 )
												<td>Terlunasi</td>
												<td align="center"><button class="btn btn-success">
													<?php 
													$date = date('Y-m-d', strtotime(now()));
													$date2 = date('Y-m-d', strtotime($abs->dibayar));

													$datetime1 = new DateTime($date);
													$datetime2 = new DateTime($date2);
													$interval = $datetime1->diff($datetime2);
													$days = $interval->format('%a');

													echo $days.' hari lagi';
													?>
												</button></td>
												@elseif($abs->pay ==1)
												<td>Belum Terlunasi</td>
												<td >Telah Berakhir</span></td>
												@else
												<td>Belum Terlunasi</td>
												<td >Telah Berakhir</span></td>
												<!-- abs bayar -->
												@endif
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal konfirmasi -->
@foreach($konfirmasi as $abs)

<div style="text-align: center;" class="modal fade" id="modal-bukti{{$abs->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Bukti Pembayaran</h3>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="now-ui-icons ui-1_simple-remove"></i>
				</button>
			</div>
			<div id="#{{$abs->id}}" class="modal-body">
				<div class="instruction">
					<div class="row">
						<div class="col-md-12">
							@if($abs->image == NULL)
							<h3>Belum Mengirim Bukti Pembayaran</h3>
							@else
							<img width="50%" height="50%" src="{{ URL::to('/') }}/images/{{ $abs->image }}">
							<hr>
							<div class="row">
								<label class="col-md-3 col-form-label">Total Pembayaran</label>
								<div class="col-md-9">
									<div class="form-group">
										<input type="text" value="{{ rupiah($abs->harga) }}" class="form-control" readonly="" >
									</div>
								</div>
								<label class="col-md-3 col-form-label">Bank</label>
								<div class="col-md-9">
									<div class="form-group">
										<input type="text" value="{{ $abs->bank }}" class="form-control" readonly="" >
									</div>
								</div>
								<label class="col-md-3 col-form-label">Rentan Pemakaian</label>
								<div class="col-md-9">
									<div class="form-group">
										<input type="text" value="{{ $abs->tgl_bayar }}" class="form-control" readonly="" >
									</div>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-center">
				<form action="{{route('transfer.konfirmasi', $abs->id)}}" method="post">
					{{ csrf_field() }}
					{{ method_field('PATCH')}}
					<input type="hidden" name="user_id" value="{{$abs->id}}">
					<input type="hidden" name="dibayar" value="{{$abs->tgl_bayar}}">
					<td><button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button></td>
				</form>
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection
