@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-user">
			<div class="image">
				<img src="http://www.prima-infodata.com/admin/ck/userfiles/images/TB/DSC04922.jpg" alt="...">
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="author">
							<a href="#">
								<img class="avatar border-gray" src="{{asset('logo_depan.png')}}" alt="...">
							<h5 class="title">Radja Digital Creative</h5>
							</a>

							<p class="description text-center">
								Email: admin@radjadigitalcreative.com <br>
								Kontak: 082133902001 <br>
									<a target="blank" href="http://radjadigitalcreative.com/">Website: http://radjadigitalcreative.com</a><br><br>
								Office: Jl. Mayang km.2 , Kartasura, Surakarta, Central Java
							</p>
						</div>
					</div>
				</div>
				

			</div>
			<hr>
			<div id="googleMap" style="width:100%;height:380px;"></div>
			<div class="button-container">
				<button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
					<i class="fab fa-facebook-f"></i>
				</button>
				<button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
					<i class="fab fa-twitter"></i>
				</button>
				<button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
					<i class="fab fa-google-plus-g"></i>
				</button>

			</div>
		</div>
	</div>

</div>

@endsection
@section('script')
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>

	function initialize() {
		var propertiPeta = {
			center:new google.maps.LatLng(-7.5375824,110.8195408),
			zoom:9,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};

		var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection
