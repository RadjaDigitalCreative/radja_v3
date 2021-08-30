@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-chart">
			<div class="card-header">
				<h5 class="card-category">Referal Code</h5>
				<h4 class="card-title">Silahkan sebarkan code ini agar anda mendapatkan bonus dari kami</h4>
				<div class="dropdown">

				</div>
			</div>
			<div class="card-body">

				Your url code referal is <b><br><br>
				</b>
				@if(auth()->user()->agen == 1)

				<input type="text" class="form-control" value="https://radjasistem.com/public/auth/referal/{{auth()->user()->referal}}" id="myInput">
				@elseif(auth()->user()->agen == 2)
				<input type="text" class="form-control" value="https://radjasistem.com/public/auth/referal/{{auth()->user()->referal2}}" id="myInput">
				@elseif(auth()->user()->agen == 3)
				<input type="text" class="form-control" value="https://radjasistem.com/public/auth/referal/{{auth()->user()->referal3}}" id="myInput">
				@endif
				<div class="card-footer">
					<div class="stats">
						<i class="now-ui-icons business_money-coins"></i>  <button onclick="myFunction()" class="btn btn-link p-0 m-0 align-baseline">Copy referal</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@section('script')
<script>
	function myFunction() {
		const  copyText = document.getElementById("myInput");
		copyText.select();
		copyText.setSelectionRange(0, 99999)
		document.execCommand("copy");
		alert("Alamat Referal berhasil di salin: " + copyText.value);
	}
</script>
@endsection
@endsection