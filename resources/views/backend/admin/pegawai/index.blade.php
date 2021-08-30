@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                    <form class="form-inline float-right" action="{{route('pegawai.hari.filter')}}" method="POST">
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
                            <button type="submit" class="btn btn-outline-primary btn-round"><i class="fa fa-search"></i>&nbsp;Filter
                            </button>
                        </div>
                    </form>
                    @if(auth()->user()->level == 'Owner')
                        <div class="btn-group">
                            <a href="{{route('pegawai.hari.create')}}">
                                <button type="button" class="btn btn-warning"><i
                                        class="now-ui-icons ui-1_simple-add"></i> Buat Hari Kerja Pegawai
                                </button>
                            </a>
                            <a href="{{route('pegawai.jam.create')}}">
                                <button type="button" class="btn btn-primary"><i class="now-ui-icons ui-1_bell-53"></i>
                                    Buat Jam Absensi
                                </button>
                            </a>
                            <a href="{{route('pegawai.hari.destroyAll')}}">
                                <button style="float: right;" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus
                                    Semua Hari
                                </button>
                            </a>
                        </div>
                        <br>
                    @endif

                </div>
                <div class="card-body">
                    <div class="toolbar">
                    </div>
                    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Kerja</th>
                            <th>Dibuat</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Kerja</th>
                            <th>Dibuat</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php
                            $nomor =1;
                        @endphp
                        @foreach($absensi as $abs)
                            <tr>
                                <td>{{$nomor++}}</td>
                                <td>{{$abs->date}}</td>
                                @if(stripos($abs->date, 'Saturday') !== FALSE)
                                    <td>{{$abs->jam_masuk}} - {{$abs->jam_keluar2}}</td>
                                @else
                                    <td>{{$abs->jam_masuk}} - {{$abs->jam_keluar}}</td>
                                @endif
                                <td>{{$abs->created_at}}</td>
                                <td align="center">
                                    <form id="data-{{ $abs->id }}" action="{{route('pegawai.hari.destroy',$abs->id)}}"
                                          method="post">
                                        {{csrf_field()}}
                                        {{method_field('delete')}}
                                    </form>
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="deleteRow( {{ $abs->id }} )"
                                            class="btn btn-outline-danger btn-sm remove"><i class="fa fa-trash"></i>&nbsp;Hapus
                                    </button>
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
