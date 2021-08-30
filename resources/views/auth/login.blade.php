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
<body class="login-page" >


  <!-- End Navbar -->

  <div class="page-header" filter-color="green">
    <div class="page-header-image" style="background-image:url('{{asset('10493.jpg')}}')"></div>
    <div class="content">
      <div class="container">
        <div class="col-md-5 ml-auto mr-auto">
          <div class="card card-login card-plain">
            <form class="form" action="{{route('login')}}" method="post">
              @csrf
              <div class="card-header text-center">
                <div class="logo">
                  <img src="{{asset('logo_login.png')}}" alt="">
                </div>
              </div><br><br>
              <h6>Silahkan Login</h6>
              <div class="card-body">
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons users_circle-08"></i></span>
                  </div>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan Email....">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="now-ui-icons text_caps-small"></i></span>
                  </div>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password....">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- <a href="{{ route('login.provider', 'google') }}" class="btn btn-danger">{{ __('Google Sign in') }}</a> -->
              <div style="margin-top: -35px;" class="card-footer text-center">
                <button type="submit" class="btn btn-primary btn-lg btn-round">Masuk</button>
                <a href="{{url('/register')}}" class="btn btn-red btn-lg btn-round">Daftar</a>
                <!-- <a href="#pablo" class="btn btn-primary btn-round btn-lg btn-block">Get Started</a> -->
               <!--  <a href="{{ url('auth/google') }}" style="margin-top: 20px;" class="btn btn-lg btn-danger ">
                  <strong>{{ __('Google Sign in') }}</strong>
                </a>  -->
                @if (Route::has('password.request'))
                <a class="btn  btn-primary btn-link" href="{{ route('password.request') }}">
                  {{ __('Lupa Password?') }}
                </a>
                @endif

              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer " >
      <div class="container">
        <div class="copyright">
          &copy; <script>document.write(new Date().getFullYear())</script>. Coded by <a href="http://radjadigitalcreative.com/">Radja Digital Creative</a>.
        </div>
      </div>
    </footer>
  </div>



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
  <script src="https://demos.creative-tim.com/marketplace/now-ui-kit-pro/assets/js/now-ui-kit.js?v=1.2.0" type="text/javascript"></script>

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
  </script>
</body>

</html>

