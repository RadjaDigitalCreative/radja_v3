@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                    <form class="form-inline float-right" action="{{ route('order.filter') }}" method="get">
                        <div class="form-group mx-sm-3">
                            <select name="jenis_penjualan" id="" class="form-control">
                                <option value="">Jenis Penjualan</option>
                                @foreach($jenis_penjualan as $row)
                                    <option value="{{ $row->nama_jenis }}">{{ $row->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                    <form class="form-inline float-right" action="{{route('order.index')}}" method="get">
                        @csrf
                        <div class="form-group mx-sm-3">
                            <input type="text" class="form-control" id="name" name="lokasi"
                                   placeholder="Masukkan Lokasi">
                            <button type="submit" class="btn btn-primary btn-round">Cari</button>
                        </div>
                    </form>

                    <!-- Example split danger button -->
                    <div class="btn-group">
                        <a href="{{route('order.create')}}">
                            <button type="button" class="btn btn-success"><i class="now-ui-icons ui-1_simple-add"></i>
                                Tambah
                            </button>
                        </a>
                    </div>
                    <form class="form-inline float-right" action="{{ route('order.index') }}" method="get">
                        <div class="form-group mx-sm-3">
                            <input type="text" id="created_at" name="date" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('order.index') }}">
                            <button class="btn btn-success">Refresh</button>
                        </a>
                    </form>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                    </div>
                    <table id="table-datatables" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th width="12%">Nomor Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Kasir</th>
                            <th>Cabang</th>
                            <th>No Telepon</th>
                            <th>Dipesan</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nomor Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Kasir</th>
                            <th>Cabang</th>
                            <th>No Telepon</th>
                            <th>Dipesan</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php
                            $nomor = 1;
                            function rupiah($m)
                            {
                                $rupiah = "Rp ".number_format($m,0,",",".").",-";
                                return $rupiah;
                            }
                        @endphp
                        @foreach ($data as $row)
                            @if ($row->keperluan == 'Penjualan')
                                <tr>
                                    <td>{{$nomor++}}</td>
                                    <td>{{$row->table_number}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->user->name}}</td>
                                    <td>{{$row->lokasi}}</td>
                                    <td><a target="_blank" href="https://api.whatsapp.com/send?phone={{$row->notelp}}"
                                           class="btn btn-success"><i class="fas fa-upload"></i> {{$row->notelp}}</a>
                                    </td>
                                    <td>{{$row->created_at}}</td>
                                    <td class="text-center">
                                        <form id="data-{{ $row->id }}" action="{{route('order.destroy',$row->id)}}"
                                              method="post">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                        </form>
                                        <a href="{{url('admin/order/'.$row->id.'/edit')}}" data-toggle="modal"
                                           data-target="#modal-edit{{$row->id}}"
                                           class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                class="fas fa-heart"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        @if(auth()->user()->level == 'Owner')
                                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i
                                                    class="fas fa-times"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    @foreach ($data as $row)
                        @include('backend.admin.order.modal')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-datatables').DataTable({
                "scrollX": true,
                lengthMenu: [10, 20, 50, 100, 200, 500, 1000],
            });
        });
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script>
        $(document).ready(function () {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            $('#exportpdf').attr('href', '/administrator/reports/order/pdf/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

            $('#created_at').daterangepicker({
                startDate: start,
                endDate: end
            }, function (first, last) {
                $('#exportpdf').attr('href', '/administrator/reports/order/pdf/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
            })
        })
    </script>
@endsection
@endsection
