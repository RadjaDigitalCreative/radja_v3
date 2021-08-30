<?php 
function rupiah($m)
{
  $rupiah = "Rp ".number_format($m,0,",",".").",-";
  return $rupiah;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Kasir Online
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
  <div style="margin-top: 15px;" class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h4 class="card-title">Slip Gaji <span class="font-weight-light"># {{ $pegawai->name }}  </span></h4>
          <h5 class="card-description mt-3 font-weight-bold">
            <hr> Radja Digital Creative
          </h5>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="mx-auto d-block">
              @if($pegawai->image == NULL)
              <img class="rounded-circle mx-auto d-block" width="20%" height="20%" src="{{ asset('images/logo.png') }}" alt="Card image cap">
              @else
              <img class="rounded-circle mx-auto d-block" width="20%" height="20%" src="{{ URL::to('/') }}/images/{{ $pegawai->image }}" alt="Card image cap">
              @endif
              <h5 class="text-sm-center mt-2 mb-1">{{$pegawai->name}}</h5>
              <div class="location text-sm-center"><i class="fa fa-mail"></i> {{$pegawai->email}}</div>
            </div>
            <hr>
            <div class="card-text text-sm-center">
              <h4><strong class="card-title mb-5">Total Gaji : {{rupiah($hasil)}}</strong></h4>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <strong class="card-title mb-3">Hari Kerja Saya</strong>
                </div>
                <div class="card-body">
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Jumlah Hari Kerja</label></div>
                    <div class="col-12 col-md-9">{{$data4->total}} Hari</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masuk Kerja</label></div>
                    <div class="col-12 col-md-9">{{$data3->total}} Hari</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Lembur</label></div>
                    <div class="col-12 col-md-9">{{$data3->total_lembur}} Hari</div>
                  </div>
                  

                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <strong class="card-title mb-3">Gaji Saya</strong>
                </div>
                <div class="card-body">
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Total Gaji Pokok</label></div>
                    <div class="col-12 col-md-9">{{rupiah($data->total)}}</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Total Potongan</label></div>
                    <div class="col-12 col-md-9">{{rupiah($data2->total)}}</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Gaji Perhari</label></div>
                    <div class="col-12 col-md-9">{{rupiah($hasil2)}}</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Gaji Lembur Perhari</label></div>
                    <div class="col-12 col-md-9">{{rupiah($data->total_lembur)}}</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Gaji Lembur Saat ini</label></div>
                    <div class="col-12 col-md-9">{{rupiah($hasil3)}}</div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Gaji Keseluruhan Saat Ini</label></div>
                    <div class="col-12 col-md-9"><b>{{rupiah($hasil)}}</b></div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Rekening</label></div>
                    <div class="col-12 col-md-9"></div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <strong class="card-title mb-3">Komponen Gaji</strong>
                </div>
                <div class="card-body">
                  <div class="row form-group">
                    @foreach($data5 as $row)
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">{{$row->komponen}}</label></div>
                    <div class="col-12 col-md-9">{{rupiah($row->total)}}</div>
                    @endforeach
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <strong class="card-title mb-3">Komponen Potongan</strong>
                </div>
                <div class="card-body">
                  <div class="row form-group">
                    @foreach($data6 as $row)
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">{{$row->komponen}}</label></div>
                    <div class="col-12 col-md-9">{{rupiah($row->total)}}</div>
                    @endforeach
                  </div>

                </div>
              </div>
            </div>
          </div>
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
