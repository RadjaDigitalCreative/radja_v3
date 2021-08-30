@extends('layout.main')
@section('title', $title)
@section('content')
<!-- modal tambah bonus cuti -->
@foreach($cuti as $abs)

<div class="modal fade" id="staticBackdrop-{{$abs->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Nominal Cuti Jika Tidak Diambil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=" {{ route('cuti.nominal')}}" method="post" >
        @csrf
        <div class="modal-body">
          <div class="row">
            <label class="col-md-3 col-form-label">Masukkan Nominal</label>
            <div class="col-md-5">
              <div class="form-group">
                <input type="number" name="gaji" class="form-control" required="">
                <input type="hidden" name="user_id" value="{{$abs->user_id}}" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-success"><h5>Simpan dan Berikan</h5></button>

        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">Ajukan Cuti</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('cuti.ajukan.store')}}" class="form-horizontal">
      @csrf

      <div class="row">
        <label class="col-md-3 col-form-label">Pegawai</label>
        <div class="col-md-8">
          <div class="form-group">
            <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control" readonly="">
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}" class="form-control" readonly="">
          </div>
        </div>
      </div>
      <div id="app">
        <div class="row" v-for="(order, index) in orders" :key="index">
          <label class="col-md-3 col-form-label">Tanggal Cuti</label>
          <div class="col-md-8">
            <div class="form-group">
              <input  type="date" placeholder="Tanggal yang diambil" name="tgl_mulai_cuti[]" class="form-control" required="">
            </div>
          </div>
          <button type="button" class="btn btn-danger btn-sm" @click="delOrder(index)"><i class="fa fa-trash"></i></button>
          <button type="button" class="btn btn-success btn-sm" @click="addOrder()" ><i class="fa fa-plus"></i></button>
        </div>
      </div>
      <div class="row">
        <label class="col-md-3 col-form-label">Keperluan</label>
        <div class="col-md-8">
          <div class="form-group">
            <input type="text" name="keperluan" class="form-control" placeholder="Keperluan pengambilan cuti" required="">
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

<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Data Pengajuan Cuti Saya</strong>
          </div>
          <div class="card-body">
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  
                  @php
                  $hitung2 = count($tanggal)
                  @endphp 
                  <th colspan="2" style="text-align: center;">Tanggal Pengajuan</th>
                  <th>Nominal Cuti(tidak diambil)</th>
                  <th>Pengajuan Cuti</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php 
                $nomor =1;
                function rupiah($m)
                {
                  $rupiah = "Rp ".number_format($m,0,",",".").",-";
                  return $rupiah;
                }
                @endphp
                @foreach($cuti as $abs)

                <tr>
                  <td>{{$nomor++}}</td>

                  @foreach($tanggal as $ami)
                  <?php 
                  $tgl_mulai = date( "l, d F Y", strtotime($ami->tgl_mulai_cuti));
                  ?>
                  <td >{{$tgl_mulai}}</td>
                  @endforeach
                  <td>{{rupiah($abs->gaji)}}</td>
                  <td>{{$abs->hari}} hari</td>
                  <td>
                    @if($abs->status == 0)
                    <a href="#"><button type="button" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i>&nbsp;Belum Terkonfirmasi</button></a>
                    @elseif($abs->status >= 1)
                    <a href="#"><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i>&nbsp;Terkonfirmasi</button></a>
                    @endif
                  </td>
                  <td align="center">
                    <form id="data-{{ $abs->id }}" action="{{route('cuti.destroy',$abs->id)}}" method="post">
                      {{csrf_field()}}
                      {{method_field('delete')}}
                    </form>

                    <button type="submit" onclick="deleteRow( {{ $abs->id }} )" class="btn btn-outline-danger btn-sm remove"><i class="fa fa-trash"></i>&nbsp;Batalkan</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- .animated -->
</div><!-- .content -->

@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  $('.cari').select2();
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script type="text/javascript">
  new Vue({
    el: '#app',
    data: {
      orders: [
      {pesanan: 0, nama: "", tgl_mulai_cuti: 0, jumlah: 1, subtotal: 0},
      ],
      discount: 0,
      note: "",
    },
    methods: {
      addOrder(){
        var orders = {pesanan: 0, nama: "", tgl_mulai_cuti: 0, jumlah: 1, subtotal: 0};
        this.orders.push(orders);
      },
      delOrder(index){
        if (index > 0){
          this.orders.splice(index,1);
        }
      },
    },
  });
</script>

@endsection
@endsection
