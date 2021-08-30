@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                    <!-- Example split danger button -->

                    <div class="btn-group">
                    </div>
                    <form class="form-inline float-right" action="{{ route('report.filter') }}" method="get">
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
                    <form class="form-inline float-right" action="{{ route('report.index') }}" method="get">
                        <div class="form-group mx-sm-3">
                            <input type="text" id="created_at" name="date" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('report.index') }}">
                            <button class="btn btn-success">Refresh</button>
                        </a>
                    </form>
                    <form class="form-inline float-right" action="{{route('report.index')}}" method="get">
                        @csrf
                        <div class="form-group mx-sm-3">
                            <input type="text" class="form-control" id="name" name="lokasi"
                                   placeholder="Masukkan Lokasi">
                            <button type="submit" class="btn btn-primary btn-round">Cari</button>
                        </div>
                    </form>
                    <br><br><br>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                    </div>
                    <table id="table-datatables" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Pembayaran</th>
                            <th>Kasir</th>
                            <!-- <th>Cabang</th> -->
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="4" class="text-center">Total</th>
                            <!-- <th>Cabang</th> -->
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th class="disabled-sorting text-center">Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php
                            $nomor = 1;
                            $total = 0;
                            function rupiah($m)
                            {
                              $rupiah = "Rp ".number_format($m,0,",",".");
                              return $rupiah;
                            }
                        @endphp
                        @foreach ($data as $row)
                            @if ($row->keperluan == 'Penjualan')
                                <tr>
                                    <td>{{$nomor++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->payment->name}}</td>
                                    <td>{{$row->user->name}}</td>
                                <!-- <td>{{$row->lokasi}}</td> -->
                                    <td>Rp <?php echo number_format($row->total) ?></td>
                                    <td>{{$row->created_at}}</td>
                                    <td class="text-center">
                                        <a href="{{url('admin/order/'.$row->id.'/edit')}}" data-toggle="modal"
                                           data-target="#modal-edit{{$row->id}}"
                                           class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                class="fas fa-heart"></i></a>
                                    </td>
                                </tr>
                                <?php $total += $row->total; ?>
                            @endif
                        @endforeach
                        </tbody>
                        <tr>
                            <td colspan='4' class='text-center'><b></b></td>

                            <td><b>Rp. {{number_format($total)}}</b></td>
                            <td class='text-center'><b></b></td>
                            <td class='text-center'><b></b></td>
                        </tr>
                    </table>
                    @foreach ($data as $row)
                        @include('backend.admin.order.modal')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Grade Pesanan</h4>
                    <!-- Example split danger button -->
                    <div class="btn-group">
                    </div>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                    </div>
                    <table id="table-datatables2" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Cabang</th>
                            <th width="15%">Barang Terjual</th>
                            <th>Tanggal</th>
                            <!-- <th class="disabled-sorting text-right">Actions</th> -->
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Cabang</th>
                            <th width="15%">Barang Terjual</th>
                            <th>Tanggal</th>
                            <!-- <th class="disabled-sorting text-center">Actions</th> -->
                        </tr>
                        </tfoot>
                        <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($terjual -> sortByDesc('terjual') as $row)
                            <tr>
                                @if($terjual -> max('terjual') == $row->terjual)
                                    <td bgcolor="success">{{$nomor++}}</td>
                                    <td bgcolor="success">{{$row->name}}</td>
                                    <td bgcolor="success">{{$row->cabang}}</td>
                                    <td class="text-center" bgcolor="success">{{$row->terjual}}</td>
                                    <td bgcolor="success">{{$row->created_at}}</td>
                                @else
                                    <td>{{$nomor++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->cabang}}</td>
                                    <td class="text-center">{{$row->terjual}}</td>
                                    <td>{{$row->created_at}}</td>
                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sortir Tiap Cabang</h4>
                    <!-- Example split danger button -->
                    <div class="btn-group">
                    </div>
                </div>

                @foreach ($link as $links)
                    <div class="accordion" id="accordionExample-{{$links->id}}">
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#modal-show{{$links->id}}"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                        <h6 style="font-size: 18px;">{{$links->cabang}}</h6>
                                    </button>
                                </h2>
                            </div>
                            <div id="modal-show{{$links->id}}" class="collapse" aria-labelledby="headingTwo"
                                 data-parent="#accordionExample-{{$links->id}}">
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Cabang</th>
                                            <th width="15%">Barang Terjual</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Cabang</th>
                                            <th width="15%">Barang Terjual</th>
                                            <th>Tanggal</th>
                                        </tr>

                                        </tfoot>
                                        <tbody>
                                        @php
                                            $nomor = 1;
                                        @endphp
                                        @foreach ($terjual-> sortbyDesc('terjual') as $row)
                                            @if ($links->cabang == $row->cabang)
                                                <tr>
                                                    <td>{{$nomor++}}</td>
                                                    <td>{{$row->name}}</td>
                                                    <td>{{$row->cabang}}</td>
                                                    <td class="text-center">{{$row->terjual}}</td>
                                                    <td>{{$row->created_at}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-datatables2').DataTable({
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\Rp,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };


                    // Total Uang Keluar
                    total2 = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal2 = api
                        .column(3, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(3).footer()).html(
                        pageTotal2 + ' Barang'
                    );
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-datatables3').DataTable({
                "scrollX": true,
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

