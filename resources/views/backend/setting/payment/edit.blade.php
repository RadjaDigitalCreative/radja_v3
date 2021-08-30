@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <form method="post" action="{{route('transfer.update', $data->id)}}" class="form-horizontal" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">
        <label class="col-md-3 col-form-label">Nama</label>
        <div class="col-md-9">
          <div class="form-group">
            <input name="user_id" value="{{$data->id}}" type="text" class="form-control" readonly="" >
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Email</label>
        <div class="col-md-9">
          <div class="form-group">
            <input type="email" value="{{$data->email}}"  class="form-control" readonly="" >
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
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Pilih Paket</label>
        <div class="col-md-9">
          <div class="form-group">
            <div id="app">
              <?php function rupiah($m)
              {
                $rupiah = "Rp ".number_format($m,0,",",".").",-";
                return $rupiah;
              } ?>
              @foreach($pay as $row)
              <label class="btn btn-outline-primary btn-lg">
                <input type="radio" name="bulan" id="option2" v-model="pilih" value="{{ $row->bulan }}"> 
                <br>Paket {{ $row->bulan }} Bulan
                <br>{{ rupiah($row->harga) }}
              </label>
              @endforeach
              <br>
            
              <button type="button" class="btn btn-outline-success"><h5>Masa Pemakaian : @{{ pilih }} Bulan </h5></button>

            


            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Metode Pembayaran</label>
        <div class="col-md-4">
          <div class="form-group">
            <select name="bank" class="form-control" required="">
              <option value=""> -- Silahkan Pilih Bank -- </option>
              <option class="form-control" value="1140014145562 ">1140014145562  (Mandiri / CV Radja Advertise Indonesia)</option>
              
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Bukti Pembayaran</label>
        <div class="col-md-9">
          <div class="form-group">
            <span class="btn btn-rose btn-round btn-file">
              <span class="fileinput-new">Pilih Gambar</span>
              <input type="file" name="image" id="image" required="">
            </span>
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
@section('script')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data: {
      pilih: ''
    }
  })
</script>
@endsection
@endsection
