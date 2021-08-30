@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('cities.store')}}" class="form-horizontal">
      @csrf
      <div class="row">
        <label class="col-md-3 col-form-label">Cabang Toko</label>
      </div><br>
      <div class="row">
        <label class="col-md-3 col-form-label">Provinsi</label>
        <div class="col-md-5">
          <div class="form-group">
            <select name="provinsi" id="province" class="form-control">
              <option value="">== Pilih Provinsi ==</option>
              @foreach ( $provinsi as $id => $name)
              <option value="{{ $id }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Kota</label>
        <div class="col-md-5">
          <div class="form-group">
            <select name="nama_cabang" id="city" class="form-control">
              <option value="">== Pilih Kota ==</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Pointer</label>
        <div class="col-md-5">
          <div id="googleMap" style="width:100%;height:180px;"></div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Get LangLong</label>
        <div class="col-md-1">
          <input type="text" id="long" name="long"  class="form-control" placeholder="Longitude">
          <input type="text" id="lang" name="lang" class="form-control" placeholder="Latitude">
          <a class="btn btn-fill btn-warning text-center" onclick="getLocation()">Lokasi Otomatis</a>
        </div>
      </div>
    </div>

    <div class="card-footer ">
      <div class="row">
        <label class="col-md-3"></label>
        <div class="col-md-9">
          <button type="reset" class="btn btn-fill btn-danger">Reset</button>
          <button type="submit" class="btn btn-fill btn-success">Masuk</button>
        </div>
      </div>
    </div>
  </form>
</div>



@endsection
@section('script')
<script>

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.watchPosition(showPosition);
    } else { 
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  function showPosition(position) {
    $('#long').val(position.coords.longitude);
      $('#lang').val(position.coords.latitude);
  }

  function initialize() {
    var propertiPeta = {
      center:new google.maps.LatLng(-7.550274699999999,110.8216113),
      zoom:9,
      mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>

<script>
  $(function () {
    $('#province').on('change', function () {
      axios.post('{{ route('cabang.store') }}', {id: $(this).val()})
      .then(function (response) {
        $('#city').empty();
        $.each(response.data, function (id, name) {
          $('#city').append(new Option(name))
        })
      });
    });
  });
</script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@endsection


