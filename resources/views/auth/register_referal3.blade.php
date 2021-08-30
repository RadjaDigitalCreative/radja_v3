<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Radja Sistem</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

  <!-- CSS Files -->
  <link href="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/css/now-ui-kit.css?v=1.2.0" rel="stylesheet" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/css/demo.css" rel="stylesheet" />

  <!-- Canonical SEO -->
  <link rel="canonical" href="https://www.creative-tim.com/product/now-ui-kit-pro" />
  <!--  Social tags      -->
</head>
<body  class="login-page">
  <div  class="page-header" filter-color="green">
    <div class="page-header-image" style="background-image:url('{{asset('10493.jpg')}}')"></div>
    <div class="content">
      <div  class="container">
        <div class="col-md-5 ml-auto mr-auto">
          <div style="margin-top: -100px;" class="card card-login card-plain">
            <form class="form" action="{{route('register')}}" method="post">
              @csrf
              <div class="card-header text-center">
                <div class="logo">
                  <img src="{{asset('logo_login.png')}}" alt="">
                </div>
              </div><br><br>
              <h6>Silahkan Daftar</h6>
              <div class="card-body">
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons ui-1_email-85"></i></span>
                  </div>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan Email">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons users_single-02"></i></span>
                  </div>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan Nama....">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons business_badge"></i></span>
                  </div>
                  <input required="" type="text" name="notelp" class="form-control" placeholder="Masukkan Telepon...">
                </div>
                
                <input  type="hidden" name="level" value="Owner"  >

                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons text_caps-small"></i></span>
                  </div>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Masukkan Password....">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons text_caps-small"></i></span>
                  </div>
                  <input id="password-confirm" placeholder="Konfirmasi Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <!-- KODE REFERAL -->
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons design_vector"></i></span>
                  </div>
                  <input id="referal" readonly="" value="{{$data3->referal3}}" type="text" name="referal" class="form-control" placeholder="Masukkan Code Referal..." data-toggle="popover" title="Kode Referal" data-content="Code Referal Anda Sudah Terpasang Silahkan Lanjutkan!!">
                </div>

              </div>
              <div style="margin-top: -40px;" class="card-footer text-center">
                <button type="submit" class="btn btn-primary  ">Daftar</button>
                 <!-- <a href="{{ url('auth/google') }}" class="btn  btn-danger">Google Sign In</a>  -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer " >
      <div class="container">
        <div class="copyright">
          &copy; <script>document.write(new Date().getFullYear())</script>, Coded by <a href="http://radjadigitalcreative.com/">Radja Digital Creative</a>
        </div>
      </div>
    </footer>
  </div>
</body>

<!--   Core JS Files   -->
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/moment.min.js"></script>
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/bootstrap-switch.js"></script>
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/bootstrap-tagsinput.js"></script>

<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/jasny-bootstrap.min.js"></script>

<!--  Plugin for the Sliders, full documentation here: https://refreshless.com/nouislider/ -->
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>

<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/plugins/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<!-- Plugins for Presentation Page -->

<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/now-ui-kit.js?v=1.2.0" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
  // Facebook Pixel Code Don't Delete
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
      document,'script','//connect.facebook.net/en_US/fbevents.js');

    try{
      fbq('init', '111649226022273');
      fbq('track', "PageView");

    }catch(err) {
      console.log('Facebook Track Error:', err);
    }
    $('.popover-dismiss').popover({
      trigger: 'focus'
    })
  </script>

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


  </html>

