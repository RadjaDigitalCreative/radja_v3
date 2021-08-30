@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('user.update', $data->id)}}"  class="form-horizontal">
      @csrf
      @method('PUT')
      <div class="row">
        <label class="col-md-3 col-form-label">Nama</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="text" name="name" value="{{$data->name}}" class="form-control" required="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Email</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="email" name="email" value="{{$data->email}}" class="form-control" required="">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Password</label>

        <div class="col-md-9">
          <div class="form-group">
            <input type="password" value="{{$data->password}}" class="form-control" readonly="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Lokasi</label>
        <div class="col-md-9">
          <div class="form-group has-success">
            <input type="text" value="{{auth()->user()->lokasi}}" class="form-control" readonly="">
            
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Jabatan</label>
        <div class="col-md-9">
          <div class="form-group has-success">
            <select class="form-control" name="level" required="">
             <option value=""> -- Silahkan Pilih Jabatan -- </option>
             <option class="form-control" value="Owner">Owner</option>
             <option class="form-control" value="Admin">Admin</option>
             <option class="form-control" value="Purchase">Purchase</option>
           </select>
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
