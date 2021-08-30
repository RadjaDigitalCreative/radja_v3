<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Radja Sistem
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{asset('assets/demo/demo.css')}}" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
  @yield('style')

  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
  <style type="text/css">
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
  }
  .preloader .loading {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    font: 14px arial;
  }
</style>
</head>
<body onload="window.print();">
  <div style="margin-top: 45px;" class="content">
    <div class="container">
      @if($logo->image != NULL)
      <img style=" width: 40%; height: 40%; text-align: center; display: block; margin: auto;"  src="{{ URL::to('/') }}/images/{{ $logo->image }}">
      @else
      <img style=" width: 40%; height: 40%; text-align: center; display: block; margin: auto;"  src="{{asset('/images/radja.png')}}">
      @endif
    </div>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h4 class="card-title">Invoice <span class="font-weight-light">#{{$data->table_number}} </span></h4>
          <h5 class="card-description mt-3 font-weight-bold">
            <hr> {{$logo->perusahaan}} 
          </h5>
          <p align="right">Alamat: {{$logo->alamat}}</p>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table mt-3">
              <thead>
                <tr>
                  <th class="pl-0">
                    <h6 class="font-weight-bold text-capitalize">No</h6>
                  </th>
                  <th class="px-0 ">
                    <h6 class="font-weight-bold text-capitalize">Pesanan</h6>
                  </th>
                  <th class="pr-0 text-center">
                    <h6 class="font-weight-bold text-capitalize">Catatan</h6>
                  </th>
                  <th class="pr-0 text-center">
                    <h6 class="font-weight-bold text-capitalize">Price</h6>
                  </th>
                  <th class="pr-0 text-center">
                    <h6 class="font-weight-bold text-capitalize">Jumlah</h6>
                  </th>
                  <th class="pr-0 text-center">
                    <h6 class="font-weight-bold text-capitalize">Subtotal</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                @php
                $no = 1;
                function rupiah($m)
                {
                  $rupiah = "Rp ".number_format($m,0,",",".").",-";
                  return $rupiah;
                }
                @endphp
                @foreach ($data->orderDetail as $odt)
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$odt->product_name}}</td>
                  <td>{{$odt->note}}</td>
                  <td>{{rupiah($odt->product_price)}}</td>
                  <td>{{$odt->quantity}}</td>
                  <td>{{rupiah($odt->subtotal)}}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="5">Total Bayar</td>
                  <td>{{rupiah($data->orderDetail->sum('subtotal'))}}</td>
                </tr>
                <tr>
                  <td colspan="5">Bayar</td>
                  <td>{{rupiah($data->discount)}}</td>
                </tr>
                <tr>
                  <td colspan="5"><b>Kembali</b></td>
                  <td><b>{{rupiah($data->discount - $data->orderDetail->sum('subtotal'))}}</b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12 col-md-6">

          <h6 class="text-uppercase card-description font-weight-bold mb-3">
            Invoiced from
          </h6>
          <p class="mb-4">
            <strong>{{$data->user->name}}</strong> <br>
            {{date('d F Y', strtotime($data->created_at))}} <br>
            {{date('H:i', strtotime($data->created_at))}} WIB
          </p>
        </div>
        <div class="col-12 col-md-6 ">
          <h6 class="text-uppercase card-description font-weight-bold mb-3">
            Invoiced to
          </h6>
          <p class="mb-4">
            <strong>{{$data->name}}</strong> <br>
            Metode Pembayaran <br>
            {{$data->payment->name}}
          </p>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <h4 class="card-title">Terimakasih<span class="font-weight-light"></span></h4>
    </div>
  </div>
</div>
</div>

</body>
</html>
