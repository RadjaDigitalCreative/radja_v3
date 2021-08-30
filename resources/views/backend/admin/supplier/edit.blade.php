@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('supplier.update', $data->id)}}" class="form-horizontal">
     @csrf
     @method('PUT')
     <div class="row">
      <label class="col-md-3 col-form-label">Nama</label>
      <div class="col-md-9">
        <div class="form-group">
          <input type="text" name="nama" value="{{$data->nama}}" class="form-control" required="">
        </div>
      </div>
    </div>
    <div class="row">
      <label class="col-md-3 col-form-label">Perusahaan</label>
      <div class="col-md-9">
        <div class="form-group">
          <input type="text" name="perusahaan" value="{{$data->perusahaan}}" class="form-control" required="">
        </div>
      </div>
    </div>
    <div class="row">
      <label class="col-md-3 col-form-label">Produk</label>
      <div class="col-md-9">
        <div class="form-group">
          <input type="text" name="produk" value="{{$data->produk}}" class="form-control" required="">
        </div>
      </div>
    </div>
    <div class="row">
      <label class="col-md-3 col-form-label">Nomor Telepon</label>
      <div class="col-md-5">
        <div class="form-group">
          <input type="text" name="notelp" value="{{$data->notelp}}" class="form-control" required="">
        </div>
      </div>
    </div>
    <div class="row">
      <label class="col-md-3"></label>
      <div class="col-md-9">
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox">
            <span class="form-check-sign"></span>
            Ingatkan Saya 
          </label>
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
