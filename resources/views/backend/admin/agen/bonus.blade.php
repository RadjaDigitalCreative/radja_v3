@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{$title}} Distributor</h4>

			</div>
			<div class="card-body">
				<div class="toolbar">

				</div>
				<?php 
				function rupiah($m)
				{
					$rupiah = "Rp ".number_format($m,0,",",".").",-";
					return $rupiah;
				} ?>
				@foreach ($link as $links)
				@if($links->referal != NULL && $links->agen == 1)
				<div class="accordion" id="accordionExample-{{$links->id}}">
					<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#modal-show{{$links->id}}" aria-expanded="false" aria-controls="collapseTwo">
									<h6 style="font-size: 18px;">{{$links->name}}</h6>
									<h6 style="font-size: 18px; float: right;"> #{{$links->referal}}</h6>&nbsp;
								</button>
							</h2>
						</div>
						<div id="modal-show{{$links->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample-{{$links->id}}">
							<div class="card-body">
								<h6 class="card-title">Member Saat Ini</h6>
								<table id="table_bonus-{{$links->id}}" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Jabatan</th>
											<th>Lokasi</th>
											<th>Payment</th>
											<th>Masa Pemakaian</th>
											<th>Kelas</th>
											<th>Bayar</th>
											<th>Bonus %</th>
											<th>Upah</th>
										</tr>
									</thead>
									<tbody>
										@php
										$nomor = 1;
										$bonus = 0; 

										@endphp
										@foreach ($data-> sortbyDesc('dibayar') as $row)
										@if ($links->referal == $row->referal && $row->agen != 1)
										<tr>
											<td>{{$nomor++}}</td>
											<td>{{$row->name}}</td>
											<td>
												@if(auth()->user()->id_team == 1 && $row->id_team == 1)
												Super
												@endif
												{{$row->level}}
											</td>
											<td>{{$row->lokasi}}</td>
											@if($row->dibayar >= now() && $row->pay == 2 )
											<td>Terlunasi</td>
											<td><button class="btn btn-success"><span class="clock" data-countdown="{{$row->dibayar}}"></span></button></td>
											@elseif($row->pay ==1)
											<form action="{{route('transfer.konfirmasi', $row->id)}}" method="post">
												{{ csrf_field() }}
												{{ method_field('PATCH')}}
												<input type="hidden" name="user_id" value="{{$row->id}}">
												<input type="hidden" name="dibayar" value="{{$row->tgl_bayar}}">
												<td>Terlunasi</td>
												<td><button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button></td>
											</form>
											@else
											<td>Belum Terlunasi</td>
											<td>Telah Berakhir</span></td>
											@endif
											@if ($row->agen == 2)
											<td>Super Agen</td>
											@elseif ($row->agen == 3)
											<td>Agen Biasa</td>
											@elseif ($row->agen == 4)
											<td>Member</td>
											@endif
											<td>{{ rupiah($row->harga)}}</td>

											@foreach ($upah as $bagi)
											@if ($bagi->user_id == $links->id && $bagi->agen_status == $row->agen)
											<td>{{$bagi->persen}} %</td>
											@endif
											@endforeach

											<td>
												@foreach ($upah as $bagi)
												@if ($bagi->user_id == $links->id && $bagi->agen_status == $row->agen)
												<?php 
												$upah_bersih = $row->harga *($bagi->persen / 100);
												echo rupiah($upah_bersih);
												?>
												<?php $bonus += $upah_bersih; ?>

												@endif
												@endforeach
											</td>
										</tr>
										@endif
										@endforeach
									</tbody>
									<tr>
										<!-- <td class="text-center"><button type="button" class="btn btn-danger">Cairkan</button></td> -->
										<td colspan="9" class="text-center"><b>Total Bonus</b></td>
										<td><b>{{rupiah($bonus)}}</b></td>
									</tr>
								</table>
							</div>
							<div class="card-body">
								<a data-toggle="modal" data-target="#modal-bonus{{$links->id}}" href=""><button type="button" class="btn btn-danger"><i class="now-ui-icons business_bulb-63"></i> Edit Bonus </button></a>
								
							</div>
						</div>
					</div>
				</div>

				<!-- modal bonus -->
				<div style="text-align: center;" class="modal fade" id="modal-bonus{{$links->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="card-title">Berikan Dia Upah</h6>
							</div>
							<form class="form" method="post" action="{{ route('agen.upah')}}">
								<div class="modal-body">
									@csrf
									<div class="row">
										<label class="col-md-3 col-form-label">Bonus Member Distributor</label>
										<div class="col-md-8">
											<div class="form-group">
												<input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "2" placeholder="%" required="" name="persen" class="form-control">
											</div>
										</div>
										<label class="col-md-3 col-form-label">Bonus Member Super Agen</label>
										<div class="col-md-8">
											<div class="form-group">
												<input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "2" placeholder="%" required="" name="persen2" class="form-control">
											</div>
										</div>
										<label class="col-md-3 col-form-label">Bonus Member Agen Biasa</label>
										<div class="col-md-8">
											<div class="form-group">
												<input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "2" placeholder="%" required="" name="persen3" class="form-control">
											</div>
										</div>
										<input type="hidden"  value="{{$links->id}}" name="user_id">
									</div>
								</div>
								<div class="modal-footer justify-content-center">
									<button style="float: right;" type="submit" class="btn btn-primary">Berbagi</button>

								</div>
							</form>

						</div>
					</div>
				</div>
				<!-- modal bonus -->
				@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
			$this.html(event.strftime('%D hari %H:%M:%S'));
		});
	});
	$(document).ready( function () {
		@foreach ($link as $links)
		$('#table_bonus-{{$links->id}}').DataTable({
			"scrollX": true,
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
		});
		@endforeach
	} );
</script>
@endsection
