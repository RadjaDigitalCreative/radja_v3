@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" action="{{route('user.store')}}" class="form-horizontal">
      @csrf
      <div class="row">
        <label class="col-md-3 col-form-label">Nama</label>
        <div class="col-md-9">
          <div class="form-group">
            <input name="name" value="" type="text" class="form-control" required="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Email</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="email" value="" name="email" class="form-control" required="">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Dari Tanggal</label>
        <div class="col-md-2">
          <div class="form-group">
            <input type="text" name="updated_at" value="{{now()}}" class="form-control" readonly="">
          </div>
        </div>
        <label class="col-md-3 col-form-label">Bayar Sampai</label>

        <div class="col-md-2">
          <div class="form-group">
            <input type="date" name="created_at" class="form-control" required="">
          </div>
        </div>
      </div>


      <div class="row">
        <label class="col-md-3 col-form-label">No Telepon</label>
        <div class="col-md-6">
          <div class="form-group">
            <input name="notelp" type="text" class="form-control" required="" placeholder="Masukkan Nomor Telepon">
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
          <button type="submit" class="btn btn-fill btn-success">Daftar</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
