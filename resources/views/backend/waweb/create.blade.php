<?php 
$title = "Input Pesan Baru";
?>
@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('waweb.store')}}" class="form-horizontal">
      @csrf
      <div class="row">
        <label class="col-md-3 col-form-label">Nama</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="text" name="nama" class="form-control" required="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">No. Telepon</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="number" name="number" class="form-control" required="" placeholder="Tanpa 0 (843864343)">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Text</label>
        <div class="col-md-9">
          <div class="form-group">
            <textarea class="form-control" name="text" required=""></textarea>
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
