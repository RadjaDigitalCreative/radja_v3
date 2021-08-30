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
            <input name="name" type="text" class="form-control" required="">
            <input name="id_team" type="hidden" value="{{auth()->user()->id_team}}" class="form-control" required="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Email</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="email" name="email" class="form-control" required="">
          </div>
        </div>
      </div>

      <div class="row">
        <label class="col-md-3 col-form-label">Password</label>

        <div class="col-md-9">
          <div class="form-group">
            <input type="password" name="password" class="form-control" required="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Lokasi</label>
        <div class="col-md-9">
          <div class="form-group has-success">
            
            <select name="lokasi" class="form-control" required="">
             <option value=""> -- Silahkan Pilih Cabang -- </option>
             @foreach($data as $row)
             <option class="form-control" value="{{ $row->nama_cabang }}">{{ $row->nama_cabang }}</option>
             @endforeach
           </select>
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Jabatan</label>
        <div class="col-md-9">
          <div class="form-group has-success">
            <select name="level" class="form-control" required="">
             <option value=""> -- Silahkan Pilih Jabatan -- </option>
             <option class="form-control" value="Owner">Owner</option>
             <option class="form-control" value="Admin">Admin</option>
             <option class="form-control" value="Purchase">Purchase</option>
           </select>
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
