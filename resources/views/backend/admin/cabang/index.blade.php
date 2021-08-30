@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
                @if(auth()->user()->level == 'Owner') 
                <div  class="btn-group">
                  <a href="{{route('cabang.create')}}"><button type="button" class="btn btn-success"><i class="now-ui-icons ui-1_simple-add"></i> Tambah</button></a>
                 
            </div>
            @endif
            
        </div>
        <div class="card-body">
            <div class="toolbar">
            </div>
            <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cabang Toko</th>
                        <th>Dibuat</th>
                        <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Cabang Toko</th>
                        <th>Dibuat</th>
                        <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                    $nomor = 1;
                    @endphp
                    @foreach ($data as $row)
                    <tr>
                       <td>{{$nomor++}}</td>
                       <td>{{$row->nama_cabang}}</td>
                       <td>{{$row->created_at}}</td>
                       <td class="text-right">
                        <form id="data-{{ $row->id }}" action="{{route('cabang.destroy',$row->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                        </form>

                        @if(auth()->user()->level == 'Owner') 

                        <a href="{{url('admin/cabang/'.$row->id.'/edit')}}" data-toggle="modal" data-target="#modal-edit{{$row->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-heart"></i></a>
                        <a href="{{url('admin/cabang/'.$row->id.'/edit')}}"  class="btn btn-round btn-warning btn-icon btn-sm edit"><i class="far fa-calendar-alt"></i></a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @foreach ($data as $row)
        @include('backend.admin.cabang.modal')  
        @endforeach
    </div>
</div>
</div>
</div>
@endsection
