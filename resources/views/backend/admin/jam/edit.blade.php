@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
	<div class="card-header ">
		<h4 class="card-title">Edit Jam Absensi</h4>
	</div>
	<div class="card-body">
		<form action="{{route('pegawai.jam.update', auth()->user()->id_team)}}" method="post"  class="form-horizontal">
			@csrf
			@method('POST')
			<div class="row">
				<div class="col-md-9">
					<div id="app">
						<div class="row" v-for="(order, index) in orders" :key="index">
							<label class="col-md-2 col-form-label"><b>Jam Masuk Kerja</b></label>
							<div class="col-md-6">
								<div class="form-group">
									<input placeholder="jam masuk awal" value="{{$jam->jam_masuk}}" type="time" name="jam_masuk" class="form-control" required="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					
					<label class="col-md-2 col-form-label"><b>Keterangan Jam Kerja</b></label>
					<label class="col-md-2 col-form-label">00.00 - 12.00 = AM</label>
					<label class="col-md-2 col-form-label">12.00 - 24.00 = PM</label>
				</div>
			</div>
			<br><br><hr>
			<div class="row">
				<div class="col-md-9">
					<div id="app">
						<div class="row" v-for="(order, index) in orders" :key="index">
							<label class="col-md-2 col-form-label"><b>Jam Keluar Kerja</b></label>

							<div class="col-md-6">
								<div class="form-group">
									<input value="{{$jam->jam_keluar}}" placeholder="jam keluar awal"  type="time" name="jam_keluar" class="form-control" required="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br><br><hr>
			<div class="row">
				<div class="col-md-9">
					<div id="app">
						<div class="row" v-for="(order, index) in orders" :key="index">
							<label class="col-md-2 col-form-label"><b>Potogan Telat</b></label>

							<div class="col-md-6">
								<div class="form-group">
									<input value="{{$jam->telat}}" placeholder="Potogan gaji harian jika telat"  type="number" name="telat" class="form-control" required="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<div class="row">
				<label class="col-md-3"></label>
				<div class="col-md-9">
					<button type="reset" class="btn btn-fill btn-danger">Reset</button>
					<button type="submit" class="btn btn-fill btn-success">update</button>
				</div>
			</div>
		</div>
	</form>

</div>
@endsection