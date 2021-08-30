@extends('layout.main')
@section('title', $title)
@section('content')
@include('backend.admin.report.import')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Report Pembeli</h4>
        <!-- Example split danger button -->
        <form class="form-inline float-right" action="{{route('report.pembeli')}}" method="get">
          @csrf
          <div class="form-group mx-sm-3">
            <input type="text" class="form-control" id="name" name="lokasi" placeholder="Masukkan Lokasi">
            <button type="submit" class="btn btn-primary btn-round">Cari</button>
          </div>
        </form>
        <!-- Example split danger button -->
        <div  class="btn-group">
          <a class="btn btn-success btn-round" href="#" data-toggle="modal" data-target="#modal-edit">Import Produk(Excel)</a>
          <a href="{{asset('format_excel_pembeli.xlsx')}}" class="btn btn-primary btn-round" >Format Produk(Excel)</a>
          <a href="{{route('pembeli.delete')}}"><button type="button" class="btn btn-danger"><i class="now-ui-icons ui-1_simple-remove"></i> Hapus Semua</button></a>
        </div>
      </div>

      <div class="card-body">
        <div class="toolbar">
        </div>
        <table id="table-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>No. Telepon</th>
              <th>Cabang</th>
              <th>Tanggal</th>
              <th class="disabled-sorting text-right">Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>No. Telepon</th>
              <th>Cabang</th>
              <th>Tanggal</th>
              <th class="disabled-sorting text-right">Actions</th>
            </tr>
          </tfoot>
          <tbody>
            @php
            $nomor = 1;
            @endphp
            @foreach ($data as $row)
            @if($row->name != 'NAMA PELANGGAN')
            <tr>
             <td>{{$nomor++}}</td>
             <td>{{$row->name}}</td>
             <td>+62{{$row->notelp}}</td>
             <td>{{$row->cabang}}</td>
             <td>{{$row->created_at}}</td>
             <td class="text-center">
              <a target="_blank" href="https://api.whatsapp.com/send?phone=+62{{$row->notelp}}"  class="btn btn-round btn-success btn-icon btn-sm edit"><i class="far fa-address-book"></i></a>

              <!-- <a href="{{url('admin/order/'.$row->id.'/edit')}}" data-toggle="modal" data-target="#modal-edit{{$row->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-heart"></i></a> -->
            </td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
@section('script')
<script type="text/javascript"> 
  $(document).ready(function () {
    $('#table-datatables').DataTable({
      "scrollX": true,
      lengthMenu: [10, 20, 50, 100, 200, 500, 1000],

    });
  });
</script>
@endsection
@endsection