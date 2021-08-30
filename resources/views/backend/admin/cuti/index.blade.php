@extends('layout.main')
@section('title', $title)
@section('content')
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
                    <button type="submit" class="btn btn-outline-success">Simpan dan Berikan</button>

                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
                @if(auth()->user()->level == 'Owner' or auth()->user()->id_team == 1) 
                <div  class="btn-group">
                    <a href="{{route('cuti.create')}}"><button type="button" class="btn btn-success"><i class="now-ui-icons ui-1_simple-add"></i> Setting Cuti</button></a>
                </div>
                @endif
                <div  class="btn-group">
                    <a href="{{route('cuti.ajukan.create')}}"><button type="button" class="btn btn-danger"><i class="now-ui-icons ui-1_simple-add"></i> Ajukan Cuti</button></a>
                </div>

            </div>
            <div class="card-body">
                <div class="toolbar">
                </div>
                <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            @php
                            $hitung2 = count($tanggal)
                            @endphp 
                           
                            <th colspan="2" style="text-align: center;">Tanggal Pengajuan</th>
                         

                            <th>Nominal Cuti(tidak diambil)</th>
                            <th>Pengajuan Cuti</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            @php
                            $hitung2 = count($tanggal)
                            @endphp 
                    
                            <th colspan="2" style="text-align: center;">Tanggal Pengajuan</th>

                            <th>Nominal Cuti(tidak diambil)</th>
                            <th>Pengajuan Cuti</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
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
                            <td>{{$abs->name}}</td>
                            @foreach($tanggal as $ami)
                            <?php 
                            $tgl_mulai = date( "l, d F Y", strtotime($ami->tgl_mulai_cuti));
                            ?>
                            <td >{{$tgl_mulai}}</td>
                            @endforeach
                            <td>{{rupiah($abs->gaji)}}</td>
                            <td>{{$abs->hari}} hari</td>
                            <td align="center">
                                <form id="data-{{ $abs->id }}" action="{{route('cuti.destroy',$abs->id)}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field('delete')}}
                                </form>
                                @if($abs->status == 0)
                                <a href="{{  route('cuti.approve', $abs->id_cuti) }}"><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i>&nbsp;Approve</button></a>
                                @elseif($abs->status >= 1)
                                <a href="{{  route('cuti.unapprove', $abs->id_cuti) }}"><button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-edit"></i>&nbsp;Unapprove</button></a>
                                @endif
                                <button type="submit" onclick="deleteRow( {{ $abs->id }} )" class="btn btn-outline-danger btn-sm remove"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
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
