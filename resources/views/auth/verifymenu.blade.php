@extends('layout.verify')

@section('content')
@section('style')
<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />-->
@endsection
<?php 
$title = 'Silahkan lengkapi Data Berikut';
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-chart">
      <div class="card-header">
        <h5 class="card-category">Isi Kelengkapan</h5>
        <h4 class="card-title">Isi Kelengkapan</h4>
        <div class="dropdown">

        </div>
      </div>
      <div class="card-body">
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
          {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
        @endif

        Sebelum melanjutkan, silakan masukkan informasi lebih lanjut
        <br><br>
        <form  method="POST" action="{{ route('verifymenu.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <label class="col-md-2 col-form-label">Nama Perusahaan</label>
            <div class="col-md-5">
              <div class="form-group">
                <input type="text" name="perusahaan" class="form-control" required="">
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-2 col-form-label">Provinsi</label>
            <div class="col-md-5">
              <div class="form-group">
                <select class="form-control cari" name="provinsi">
                  <option value="">== Pilih Provinsi ==</option>
                  @foreach ( $provinsi as $name)
                  <option value="{{ $name->name }}">{{ $name->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-2 col-form-label">No. Telepon</label>
            <div class="col-md-5">
              <div class="form-group">
                <input type="text" name="notelp" class="form-control" required="">
              </div>
            </div>
          </div>
           <div class="row">
            <label class="col-md-2 col-form-label">Alamat Perusahaan</label>
            <div class="col-md-5">
              <div class="form-group">
                <input type="text" name="alamat" class="form-control" required="">
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-2 col-form-label">Foto Anda</label>
            <div class="col-md-5">
              <div class="form-group">
                <span class="btn btn-rose btn-round btn-file">
                  <span class="fileinput-new">Masukkan Foto Anda</span>
                  <input type="file" name="image" id="image" required="">
                </span>
              </div>
            </div>  
          </div>
          <div class="row">
            <label class="col-md-2 col-form-label">Logo Perusahaan</label>
            <div class="col-md-5">
              <div class="form-group">
                <span class="btn btn-rose btn-round btn-file">
                  <span class="fileinput-new">Masukkan Logo Perusahaan</span>
                  <input type="file" name="image_perusahaan" id="image" required="">
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <button class="btn btn-success" type="submit" >Simpan Perubahaan</button>
            <a href="{{ route('verifymenu.check', auth()->user()->id)}}" class="btn btn-danger"><i class="now-ui-icons arrows-1_refresh-69"></i> Saya Sudah Mengisi..</a>
          </div>
        </form>
      </div>
    </div>
  </div>
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

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('select').selectpicker();
    });
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  $('.cari').select2();
</script>

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
 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  </head>
@endsection
