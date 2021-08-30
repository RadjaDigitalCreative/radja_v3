@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('hargamenu.store')}}" class="form-horizontal">
      @csrf
      <div class="row">
        <label class="col-md-3 col-form-label">Menu Beranda</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->adminpay}}" id="harga1" type="text" name="adminpay" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Menu Akses</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->aksespay}}" id="harga2" type="text" name="aksespay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Supplier</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->supplierpay}}" id="harga3" type="text" name="supplierpay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Kategori</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->kategoripay}}" id="harga4" type="text" name="kategoripay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Produk</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->produkpay}}" id="harga5" type="text" name="produkpay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Orders</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->orderpay}}" id="harga6" type="text" name="orderpay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Payment</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->payementpay}}" id="harga7" type="text" name="payementpay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Report</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->reportpay}}" id="harga8" type="text" name="reportpay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Kas</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->kaspay}}" id="harga9" type="text" name="kaspay" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Menu Stock</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->stockpay}}" id="harga10" type="text" name="stockpay" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Menu Cabang</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->cabangpay}}" id="harga10" type="text" name="cabangpay" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Menu User</label>
        <div class="col-md-5">
          <div class="form-group">
            <input value="{{$role_bayar->userpay}}" id="harga10" type="text" name="userpay" class="form-control">
          </div>
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
  $(document).ready(function() {
    demo.initDashboardPageCharts();
  });
  $(document).ready(function(){
    $('#harga1').mask('#.##0', {reverse: true});
    $('#harga2').mask('#.##0', {reverse: true});
    $('#harga3').mask('#.##0', {reverse: true});
    $('#harga4').mask('#.##0', {reverse: true});
    $('#harga5').mask('#.##0', {reverse: true});
    $('#harga6').mask('#.##0', {reverse: true});
    $('#harga7').mask('#.##0', {reverse: true});
    $('#harga8').mask('#.##0', {reverse: true});
    $('#harga9').mask('#.##0', {reverse: true});
    $('#harga10').mask('#.##0', {reverse: true});
    $('#harga11').mask('#.##0', {reverse: true});
    $('#harga12').mask('#.##0', {reverse: true});
  })
</script>
@endsection
