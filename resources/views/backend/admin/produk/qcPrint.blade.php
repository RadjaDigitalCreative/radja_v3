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
  body {
    background: rgb(204,204,204); 
  }
  page {
    background: white;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  }
  page[size="A4"] {  
    padding: 10;
    width: 21cm;
    height: 29.7cm; 
  }
 
  page[size="A4"][layout="landscape"] {
    width: 29.7cm;
    height: 21cm;  
  }
  page[size="A3"] {
    width: 29.7cm;
    height: 42cm;
  }
  page[size="A3"][layout="landscape"] {
    width: 42cm;
    height: 29.7cm;  
  }
  page[size="A5"] {
    width: 14.8cm;
    height: 21cm;
  }
  page[size="A5"][layout="landscape"] {
    width: 21cm;
    height: 14.8cm;  
  }
  @media print {
    body, page {
      margin: 0;
      box-shadow: 0;
    }
  }
  .line{
    margin-bottom: 0.5cm;

  }
</style>

</head>
<body onload="window.print();">
  <page size="A4">
    <?php 
    foreach ($data as $row) {
      if ($row->qc_print == NULL && $row->qc_copy == NULL) {
        $ukuran = 400;
        $copy = 1;
      }elseif($row->qc_print != NULL && $row->qc_copy != NULL){
        $ukuran = $row->qc_print;
        $copy = $row->qc_copy;
      }
      ?>
      <?php 
      for ($i=0; $i < $copy ; $i++) { 
        ?>
        {!! QrCode::size($ukuran)->generate($row->qc); !!}
        <?php
      }

    }?>
  </page>
</body>
</html>
