@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{$title}}</h4>

      </div>
      <div class="card-body">
        <div class="toolbar">
        </div>
        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pegawai</th>
              <th>Email</th>
              <th>Dibuat</th>
              <th class="disabled-sorting text-right">Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Nama Pegawai</th>
              <th>Email</th>
              <th>Dibuat</th>
              <th class="disabled-sorting text-right">Actions</th>
            </tr>
          </tfoot>
          <tbody>
            @php 
            $nomor =1;
            @endphp
            @foreach($pegawai as $abs)
            <tr>
              <td>{{$nomor++}}</td>
              <td>{{$abs->name}}</td>
              <td>{{$abs->email}}</td>
              <td>{{$abs->created_at}}</td>
              <td align="center">
               
                <a href="{{  route('pegawai.user.view', $abs->id) }}"><button type="button" class="btn btn-outline-success "><i class="fa fa-eye"></i>&nbsp;View</button></a>
                
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@endsection
