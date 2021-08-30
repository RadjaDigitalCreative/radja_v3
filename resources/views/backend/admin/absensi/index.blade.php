@extends('layout.main')
@section('title', $title)
@section('content')
<!-- modal cek -->
@foreach($pegawai as $p)
@foreach($absensi as $abs)
@if($abs->bulan == now()->month)
<div class="modal fade" id="staticBackdrop-{{$abs->id}}{{$p->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{$abs->date}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        Silahkan absen menurut keadaan hidup anda sekarang.


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        @foreach($cuti as $c)

        <?php 
        $tgl_mulai = date( "Y-m-d", strtotime($abs->date));
        $tgl_mulai_cuti = date( "Y-m-d", strtotime($c->tgl_mulai_cuti));
        $tgl_akhir_cuti = date( "Y-m-d", strtotime($c->tgl_akhir_cuti));

        ?>

        @if($ambil_cuti < $c->hari && $c->user_id == $p->id)
        @if( ($tgl_mulai >= $tgl_mulai_cuti) && ($tgl_mulai <= $tgl_akhir_cuti))
        <form action="{{ route('pegawai.absensi.cuti.status', $abs->id) }}" method="post">
          @csrf
          
          <input type="hidden" name="date" value="{{ $abs->date }}">
          <input type="hidden" name="bulan" value="{{ $abs->bulan }}">
          <input type="hidden" name="user_id" value="{{ $p->id }}">
          <button type="submit" class="btn btn-warning">Ambil Cuti</button>
        </form>
        @endif
        @endif

        @endforeach

        
        <form action="{{ route('pegawai.absensi.status', $abs->id) }}" method="post">
          @csrf
          <input type="hidden" name="date" value="{{ $abs->date }}">
          <input type="hidden" name="bulan" value="{{ $abs->bulan }}">
          <input type="hidden" name="user_id" value="{{ $p->id }}">
          <button type="submit" class="btn btn-primary">Hadir</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach
@endforeach
<!-- modal cek -->

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{$title}}</h4>
        @foreach($batas as $abs)
        @if($abs->id_team == auth()->user()->id_team)
        <button class="btn btn-lg btn-primary">Absen 15 menit sebelum jam, {{$abs->jam_masuk}}</button>
        @endif
        @endforeach
        <br><br>
        @if(auth()->user()->level == 'Owner') 
        <div class="btn-group">
          <form class="form-inline float-right" action="{{route('pegawai.absensi.filter')}}" method="POST">
            @csrf
            <div class="form-group ">
              <select name="filter" class="form-control">
                <option value="1">Januari</option>
                <option value="2">Febuari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
              <button type="submit" class="btn btn-outline-primary btn-round"><i class="fa fa-search"></i>&nbsp;Filter</button>
            </div>
          </form>
          @endif
        </div>
      </div>
      <div class="card-body">
        <div class="toolbar">
        </div>
        <table id="absen" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              @foreach($absensi as $abs)
              @if($abs->bulan == now()->month)
              <th style="font-size: 15px;" align="center" >{{ $abs->date }}</th>
              @endif
              @endforeach
            </tr>
          </thead>
          <tbody>
            @php
            $nomor = 1;
            @endphp
            @foreach($pegawai as $p)
            <tr>
              <td>{{ $nomor++ }}</td>
              <td>{{ $p->name }}</td>
              @foreach($absensi as $abs)
              @if($abs->bulan == now()->month)
              <td align="center" >
                @foreach($kerja as $k)

                @if($k->date == $abs->date && $k->user_id == $p->id && $k->status == 1)
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-absen{{$k->id}}">Masuk</button>
                @include('backend.admin.absensi.view')


                @elseif($k->date == $abs->date && $k->user_id == $p->id && $k->status == 2)
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-absen{{$k->id}}">Masuk</button>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-absen{{$k->id}}">Keluar</button>

                @include('backend.admin.absensi.view')
                @elseif($k->date == $abs->date && $k->user_id == $p->id && $k->cuti == 1)
                <button type="button" class="btn btn-warning btn-sm">Cuti</button>
                @else
                @endif
                @endforeach
                <br>
                <br>
                <button data-toggle="modal" data-target="#staticBackdrop-{{$abs->id}}{{$p->id}}" type="button" class="btn btn-primary btn-sm">Absen</button>
              </td>
              @endif
              @endforeach

            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Absen Lembur</h4>
        @foreach($lembur as $abs)
        @if($abs->id_team == auth()->user()->id_team)
        <button class="btn btn-lg btn-success">Silahkan Absen Lembur sampai jam {{$abs->jam_keluar_lembur}}, jika lembur telah selesai.</button>
        @endif
        @endforeach
        <br><br>

        
      </div>
      <div class="card-body">
        <div class="toolbar">
        </div>
        <table id="lembur" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              @foreach($absensi_lembur as $abs)
              @if($abs->bulan == now()->month)
              <th style="font-size: 15px;" align="center" >{{ $abs->date }}</th>
              @endif
              @endforeach
            </tr>
          </thead>
          <tbody>
            @php
            $nomor = 1;
            @endphp
            @foreach($pegawai as $p)
            <tr>
              <td>{{ $nomor++ }}</td>
              <td>{{ $p->name }}</td>
              @foreach($absensi_lembur as $abs)
              @if($abs->bulan == now()->month)
              <td align="center" >
                <form action="{{ route('pegawai.lembur.status', $abs->id) }}" method="post">
                  @csrf
                  <input type="hidden" name="date" value="{{ $abs->date }}">
                  <input type="hidden" name="bulan" value="{{ $abs->bulan }}">
                  <input type="hidden" name="user_id" value="{{ $p->id }}">
                  @foreach($kerja as $k)

                  @if($k->date == $abs->date && $k->user_id == $p->id && $k->lembur >= 1)
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lembur{{$k->id}}">Masuk Lembur</button>
                  @include('backend.admin.absensi.view2')
                  @else
                  @endif
                  @endforeach
                  <br>
                  <br>
                  <button type="submit" class="btn btn-warning btn-sm">Absen Lembur</button>
                </form>
              </td>
              @endif
              @endforeach

            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@section('script')
<script>
  $(document).ready( function () {
    $('#absen').DataTable({
      "scrollX": true,
    });
  } );
  $(document).ready( function () {
    $('#lembur').DataTable({
      "scrollX": true,
    });
  } );
</script>
@endsection
@endsection
