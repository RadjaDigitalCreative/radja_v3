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
                    <form class="form-inline float-right" action="{{ route('laba.filter') }}" method="get">
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
                    <form class="form-inline float-right" action="{{ route('laba.create') }}" method="get">
                        <div class="form-group mx-sm-3">
                            <input type="text" id="created_at" name="date" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('laba.index') }}">
                            <button class="btn btn-success">Refresh</button>
                        </a>
                    </form>
                    <form class="form-inline float-right" action="{{route('laba.create')}}" method="get">
                        @csrf
                        <div class="form-group mx-sm-3">
                            <input type="text" class="form-control" id="name" name="lokasi"
                                   placeholder="Masukkan Lokasi">
                            <button type="submit" class="btn btn-primary btn-round">Cari</button>
                        </div>
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
                            <th width="12%">Nama Produk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Laba Perproduk</th>
                            <th>Jumlah</th>
                            <th>Total Laba</th>
                            <th>Cabang</th>
                            <th>Customer</th>
                            <th>Dipesan</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th width="12%">Nama Produk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Laba Perproduk</th>
                            <th>Total Laba</th>
                            <th>Jumlah</th>
                            <th>Cabang</th>
                            <th>Customer</th>
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
                        <?php
                        $untung = 0;
                        $jml = 0;
                        $harga_beli = 0;
                        $harga_untung = 0;
                        $total = 0;
                        ?>
                        @foreach ($data as $row)
                            @if($row->id_team == auth()->user()->id_team)
                                <?php
                                $laba = $row->product_price - $row->purchase_price;
                                $jumlah = $laba * $row->quantity;
                                ?>
                                <tr>
                                    <td>{{$nomor++}}</td>
                                    <td>{{$row->product_name}}</td>
                                    <td>{{rupiah($row->purchase_price)}}</td>
                                    <td>{{rupiah($row->product_price)}}</td>
                                    <td>{{rupiah($laba)}}</td>
                                    <td>{{$row->quantity}} barang</td>
                                    <td>{{rupiah($jumlah)}}</td>
                                    <td>{{$row->lokasi}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td></td>
                                </tr>
                                <?php $harga_beli += $row->purchase_price; ?>
                                <?php $harga_untung += $row->product_price; ?>
                                <?php $untung += $laba; ?>
                                <?php $jml += $row->quantity; ?>
                                <?php $total += $jumlah; ?>
                            @elseif(auth()->user()->id_team == 1)
                                <?php
                                $laba = $row->product_price - $row->purchase_price;
                                $jumlah = $laba * $row->quantity;
                                ?>
                                <tr>
                                    <td>{{$nomor++}}</td>
                                    <td>{{$row->product_name}}</td>
                                    <td>{{rupiah($row->purchase_price)}}</td>
                                    <td>{{rupiah($row->product_price)}}</td>
                                    <td>{{rupiah($laba)}}</td>
                                    <td>{{$row->quantity}} barang</td>
                                    <td>{{rupiah($jumlah)}}</td>
                                    <td>{{$row->lokasi}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td></td>
                                </tr>
                                <?php $harga_beli += $row->purchase_price; ?>
                                <?php $harga_untung += $row->product_price; ?>
                                <?php $untung += $laba; ?>
                                <?php $jml += $row->quantity; ?>
                                <?php $total += $jumlah; ?>
                            @endif
                        @endforeach
                        </tbody>
                        <tr>
                            <td colspan="2" class="text-center"><b>Total</b></td>
                            <td><b>Rp. {{number_format($harga_beli)}}</b></td>
                            <td><b>Rp. {{number_format($harga_untung)}}</b></td>
                            <td><b>Rp. {{number_format($untung)}}</b></td>
                            <td><b>{{$jml}} barang</b></td>
                            <td><b>Rp. {{number_format($total)}}</b></td>
                            <td colspan="4"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@section('script')
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
