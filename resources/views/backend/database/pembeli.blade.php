<?php 
$title = "Kirim Semua Pesan";
?>
@extends('layout.main')
@section('title', $title)
@section('content')
@include('backend.waweb.import')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Kirim Semua Pesan</h4>
        <div  class="btn-group">
         <a href="#"><button type="button" class="btn btn-success"><i class="now-ui-icons ui-1_simple-add"></i> Tambah</button></a>
         <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-edit">Import Excel</a>
          <a href="{{asset('format_wa_excel.xlsx')}}" class="dropdown-item" >Format Excel</a>
        </div>
        <form action="{{route('wa.send')}}" method="post">
          @csrf
          @foreach ($data as $row)
          <input type="hidden" name="send[]" value="https://api.whatsapp.com/send?text={{$row->text}}&phone=+62{{$row->number}}">
          @endforeach
          <button type="submit" class="btn btn-primary"><i class="now-ui-icons ui-1_email-85"></i> &nbsp;Kirim Semua</button>
        </form>
        <a href="{{route('database.pembeli.deleteAll')}}"><button type="button" class="btn btn-danger"><i class="now-ui-icons ui-1_simple-remove"></i> Hapus Semua</button></a>
      </div>

    </div>
    <div class="card-body">
      <div class="toolbar">
      </div>
      <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>No. Telepon</th>
            <th>Pesan</th>
            <th class="disabled-sorting text-right">Send</th>
            <th class="disabled-sorting text-right">Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>No. Telepon</th>
            <th>Pesan</th>
            <th class="disabled-sorting text-right">Send</th>
            <th class="disabled-sorting text-right">Action</th>
          </tr>
        </tfoot>
        <tbody>
          @php
          $nomor = 1;
          @endphp
          @foreach ($data as $row)
          @if($row->status != 1 && $row->name != 'NAMA' )
          <tr>
            <td>{{$nomor++}}</td>
            <td>{{$row->name}}</td>
            <td>+62{{$row->number}}</td>
            <form action="{{route('wa.status')}}" method="post">
              @csrf
              <td>
                Order Produk/Jasa
              </td>
              <td align="center">  
                <input type="hidden" name="id" value="{{$row->id}}">
                <button class="btn btn-warning" type="submit"><i class="now-ui-icons ui-1_email-85"></i> Kirim Pesan</button>
              </form>
            </td>
            <td align="center">
              <form id="data-{{ $row->id }}" action="{{route('database.pembeli.delete',$row->id)}}" method="post">
                {{csrf_field()}}
                {{method_field('delete')}}
              </form>
              @csrf
              @method('DELETE')
              <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i></button>
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
@endsection