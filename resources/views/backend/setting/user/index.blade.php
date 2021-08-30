@extends('layout.main')
@section('title', $title)
@section('content')
    {{--    modal is_sales --}}

    @if(auth()->user()->id_team == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}}</h4>
                        <!-- Example split danger button -->
                        @if(auth()->user()->level == 'Owner')
                            <div style="float: left;" class="btn-group">
                                <a href="{{route('user.create')}}">
                                    <button type="button" class="btn btn-success"><i
                                            class="now-ui-icons ui-1_simple-add"></i> Tambah
                                    </button>
                                </a>
                                @if(auth()->user()->id_team  == 1)
                                    <a href="{{route('menuharga.create')}}">
                                        <button type="button" class="btn btn-warning"><i
                                                class="far fa-address-book"></i> Buat Menu Harga
                                        </button>
                                    </a>
                                @endif
                            </div>
                            <h4 style="float: right;" class="card-title">Filter Berdasarkan</h4>
                            <br><br><br>
                            <div style="float: right;" class="btn-group">

                                <form class="form-inline float-right" action="{{ route('users.filter') }}"
                                      method="post">
                                    @csrf

                                    <div class="form-group mx-sm-3">
                                        <select name="bayar" class="form-control">
                                            <option value="2">Terlunasi</option>
                                            <option value="1">Konfirmasi</option>
                                            <option value="NULL">Telah Berakhir</option>
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <input type="text" id="created_at" name="date" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                                <a href="{{ route('user.index') }}">
                                    <button class="btn btn-success">Refresh</button>
                                </a>

                            </div>
                        @endif
                        <br><br>
                        <br>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>

                        <table id="table-datatables" class="table table-striped table-bordered" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Lokasi</th>
                                <th>Total Bayar</th>
                                <th>Tgl Bayar</th>
                                <th>Payment</th>
                                <th>Masa Pemakaian</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Lokasi</th>
                                <th>Total Bayar</th>
                                <th>Tgl Bayar</th>
                                <th>Payment</th>
                                <th>Masa Pemakaian</th>
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
                            $harga = 0;
                            ?>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{$nomor++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>@if(auth()->user()->id_team == 1 && $row->id_team == 1)
                                            Super
                                        @endif
                                        {{$row->level}}
                                    </td>
                                    <td>{{$row->lokasi}}</td>
                                    <td>{{rupiah($row->harga)}}</td>
                                    <td>{{$row->dibayar}}</td>
                                    <!-- row bayar -->
                                    @if($row->dibayar >= now() && $row->pay == 2 && $row->id_team == 1)
                                        <td>Selamanya</td>
                                        <td>
                                            <button class="btn btn-success">Super Unlimited</button>
                                        </td>
                                    @elseif($row->dibayar >= now() && $row->pay == 2 )
                                        <td>Terlunasi</td>
                                        <td>
                                            <button class="btn btn-success"><span class="clock"
                                                                                  data-countdown="{{$row->dibayar}}"></span>
                                            </button>
                                        </td>
                                    @elseif($row->pay ==1)
                                        <form action="{{route('transfer.konfirmasi', $row->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH')}}
                                            <input type="hidden" name="user_id" value="{{$row->id}}">
                                            <input type="hidden" name="dibayar" value="{{$row->tgl_bayar}}">
                                            <td>Terlunasi</td>
                                            <td>
                                                <button type="submit" class="btn btn-success">Konfirmasi Pembayaran
                                                </button>
                                            </td>
                                        </form>
                                    @else
                                        <td>Belum Terlunasi</td>
                                        <td>Telah Berakhir</span></td>
                                        <!-- row bayar -->
                                    @endif
                                    <td class="text-right">
                                        @if(auth()->user()->level == 'Owner')
                                            @if($row->dibayar >= now() && $row->pay == 2 )
                                                <form id="data-{{ $row->id }}"
                                                      action="{{route('user.destroy',$row->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}
                                                </form>
                                                @if($row->is_sales == NULL)
                                                    <button data-toggle="modal"
                                                            data-target="#sales-{{$row->id}}"
                                                            class="btn btn-round btn-warning btn-icon btn-sm like">
                                                        <i
                                                            class="now-ui-icons transportation_bus-front-12"></i>
                                                    </button>
                                                @else
                                                    <button data-toggle="modal"
                                                            data-target="#sales-{{$row->id}}"
                                                            class="btn btn-round btn-success btn-icon btn-sm like">
                                                        <i
                                                            class="now-ui-icons transportation_bus-front-12"></i>
                                                    </button>
                                                @endif
                                                <a target="_blank" href="https://wa.me/{{$row->notelp}}"
                                                   class="btn btn-round btn-success btn-icon btn-sm edit"><i
                                                        class="far fa-address-book"></i></a>
                                                <a href="{{url('admin/user/'.$row->id.'/edit')}}" data-toggle="modal"
                                                   data-target="#modal-edit{{$row->id}}"
                                                   class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                        class="fas fa-heart"></i></a>
                                                <a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                   class="btn btn-round btn-warning btn-icon btn-sm edit"><i
                                                        class="far fa-calendar-alt"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                                        class="btn btn-round btn-danger btn-icon btn-sm remove"><i
                                                        class="fas fa-times"></i></button>
                                            @elseif ( $row->pay == 1 )
                                                <a href="{{url('admin/user/'.$row->id.'/edit')}}" data-toggle="modal"
                                                   data-target="#modal-bukti{{$row->id}}"
                                                   class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                        class="fas fa-file"></i></a>
                                            @else
                                                <a href="{{url('admin/transfer/'.$row->id.'/edit')}}">
                                                    <button type="button" class="btn btn-danger"><i
                                                            class="now-ui-icons business_money-coins"></i> Bayar
                                                        Sekarang
                                                    </button>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <?php $harga += $row->harga; ?>
                            @endforeach
                            </tbody>
                            <tr>
                                <td colspan="4" class="text-center"><b>Total</b></td>
                                <td><b>{{rupiah($harga)}}</b></td>
                                <td colspan="4" class="text-center"><b>Total</b></td>


                            </tr>
                        </table>
                        @foreach ($data as $row)
                            @include('backend.setting.user.modal')
                            @include('backend.setting.user.bukti')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Sortir Tiap Owner</h4>
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
                                    <h6 style="font-size: 18px;">{{$links->name}}</h6>
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
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Lokasi</th>
                                        <th>Payment</th>
                                        <th>Masa Pemakaian</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Lokasi</th>
                                        <th>Payment</th>
                                        <th>Masa Pemakaian</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @php
                                        $nomor = 1;
                                    @endphp
                                    @foreach ($data-> sortbyDesc('dibayar') as $row)
                                        @if ($links->id_team == $row->id_team && $row->id_team != 1)
                                            <tr>
                                                <td>{{$nomor++}}</td>
                                                <td>{{$row->name}}</td>
                                                <td>@if(auth()->user()->id_team == 1 && $row->id_team == 1)
                                                        Super
                                                    @endif
                                                    {{$row->level}}
                                                </td>
                                                <td>{{$row->lokasi}}</td>
                                                @if($row->dibayar >= now() && $row->pay == 2 )
                                                    <td>Terlunasi</td>
                                                    <td>
                                                        <button class="btn btn-success"><span class="clock"
                                                                                              data-countdown="{{$row->dibayar}}"></span>
                                                        </button>
                                                    </td>
                                                @elseif($row->pay ==1)
                                                    <form action="{{route('transfer.konfirmasi', $row->id)}}"
                                                          method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH')}}
                                                        <input type="hidden" name="user_id" value="{{$row->id}}">
                                                        <input type="hidden" name="dibayar" value="{{$row->tgl_bayar}}">
                                                        <td>Terlunasi</td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success">Konfirmasi
                                                                Pembayaran
                                                            </button>
                                                        </td>
                                                    </form>
                                                @else
                                                    <td>Belum Terlunasi</td>
                                                    <td>Telah Berakhir</span></td>
                                                @endif
                                                <td class="text-right">
                                                    @if(auth()->user()->level == 'Owner')
                                                        @if($row->dibayar >= now() && $row->pay == 2 )
                                                            <form id="data-{{ $row->id }}"
                                                                  action="{{route('user.destroy',$row->id)}}"
                                                                  method="post">
                                                                {{csrf_field()}}
                                                                {{method_field('delete')}}
                                                            </form>

                                                            <a target="_blank" href="https://wa.me/{{$row->notelp}}"
                                                               class="btn btn-round btn-success btn-icon btn-sm edit"><i
                                                                    class="far fa-address-book"></i></a>
                                                            <a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                               data-toggle="modal" data-target="#modal-edit{{$row->id}}"
                                                               class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                                    class="fas fa-heart"></i></a>
                                                            <a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                               class="btn btn-round btn-warning btn-icon btn-sm edit"><i
                                                                    class="far fa-calendar-alt"></i></a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                                                    class="btn btn-round btn-danger btn-icon btn-sm remove">
                                                                <i class="fas fa-times"></i></button>
                                                        @elseif ( $row->pay == 1 )
                                                            <a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                               data-toggle="modal"
                                                               data-target="#modal-bukti{{$row->id}}"
                                                               class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                                    class="fas fa-file"></i></a>
                                                        @else
                                                            <a href="{{url('admin/transfer/'.$row->id.'/edit')}}">
                                                                <button type="button" class="btn btn-danger"><i
                                                                        class="now-ui-icons business_money-coins"></i>
                                                                    Bayar Sekarang
                                                                </button>
                                                            </a>
                                                        @endif
                                                    @endif
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
            @endforeach

        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}}</h4>
                        <!-- Example split danger button -->
                        @if(auth()->user()->level == 'Owner')
                            <div class="btn-group">
                                <a href="{{route('user.create')}}">
                                    <button type="button" class="btn btn-success"><i
                                            class="now-ui-icons ui-1_simple-add"></i> Tambah
                                    </button>
                                </a>
                            <!-- <a href="{{route('transfer.create')}}"><button type="button" class="btn btn-danger"><i class="now-ui-icons business_money-coins"></i> Payment</button></a> -->
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        @if(auth()->user()->level == 'Owner')
                            <table id="table_id" class="table table-striped table-bordered" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Lokasi</th>
                                    <th>Payment</th>
                                    <th>Masa Pemakaian</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Lokasi</th>
                                    <th>Payment</th>
                                    <th>Masa Pemakaian</th>
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
                                    @if($row->id_team == auth()->user()->id_team)
                                        <tr>
                                            <td>{{$nomor++}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->level}}</td>
                                            <td>{{$row->lokasi}}</td>
                                            @if($row->dibayar >= now() && $row->pay == 2 )
                                                <td>Terlunasi</td>
                                                <td>
                                                    <button class="btn btn-success"><span class="clock"
                                                                                          data-countdown="{{$row->dibayar}}"></span>
                                                    </button>
                                                </td>
                                            @elseif($row->pay ==1)
                                                <td>Terlunasi</td>
                                                <td>
                                                    <button class="btn btn-success">Menunggu Konfirmasi</button>
                                                </td>
                                            @else
                                                <td>Belum Terlunasi</td>
                                                <td>Telah Berakhir</span></td>
                                            @endif
                                            <td class="text-right">
                                                @if(auth()->user()->level == 'Owner')
                                                    @if($row->dibayar >= now() && $row->pay == 2 )
                                                        <form id="data-{{ $row->id }}"
                                                              action="{{route('user.destroy',$row->id)}}" method="post">
                                                            {{csrf_field()}}
                                                            {{method_field('delete')}}
                                                        </form>
                                                        @if($row->is_sales == NULL)
                                                            <button data-toggle="modal"
                                                                    data-target="#sales-{{$row->id}}"
                                                                    class="btn btn-round btn-warning btn-icon btn-sm like">
                                                                <i
                                                                    class="now-ui-icons transportation_bus-front-12"></i>
                                                            </button>
                                                            @else
                                                            <button data-toggle="modal"
                                                                    data-target="#sales-{{$row->id}}"
                                                                    class="btn btn-round btn-success btn-icon btn-sm like">
                                                                <i
                                                                    class="now-ui-icons transportation_bus-front-12"></i>
                                                            </button>
                                                        @endif
                                                        <a target="_blank" href="https://wa.me/{{$row->notelp}}"
                                                           class="btn btn-round btn-success btn-icon btn-sm edit"><i
                                                                class="far fa-address-book"></i></a>
                                                        <a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                           data-toggle="modal" data-target="#modal-edit{{$row->id}}"
                                                           class="btn btn-round btn-info btn-icon btn-sm like"><i
                                                                class="fas fa-heart"></i></a>
                                                        <a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                           class="btn btn-round btn-warning btn-icon btn-sm edit"><i
                                                                class="far fa-calendar-alt"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                                                class="btn btn-round btn-danger btn-icon btn-sm remove">
                                                            <i class="fas fa-times"></i></button>
                                                    @elseif ( $row->pay == 1 )

                                                        <form action="{{route('transfer.cancel_konfirmasi', $row->id)}}"
                                                              method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH')}}
                                                            <button type="submit" class="btn btn-danger">Batalkan
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{url('admin/transfer/'.$row->id.'/edit')}}">
                                                            <button type="button" class="btn btn-danger"><i
                                                                    class="now-ui-icons business_money-coins"></i> Bayar
                                                                Sekarang
                                                            </button>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            Sebelum melanjutkan, silahkan melakukan konsultasi terhadap Owner toko anda
                                            untuk akses menu,
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @foreach ($data as $row)
                            @include('backend.setting.user.modal')
                            @include('backend.setting.user.bukti')
                            <form action="{{ route('users.sales') }}" method="post">
                                @csrf
                                <div class="modal fade" id="sales-{{ $row->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Ubah Sebagai
                                                    Sales/Biasa</h5>
                                                <input type="hidden" name="id" value="{{$row->id}}">
                                                <input type="hidden" name="is_sales" value="{{$row->is_sales}}">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p> Nama: {{ $row->name }}</p>
                                                <p> Level: {{ $row->level }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ubah</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- <div data-countdown="2021/01/01"></div> -->
@section('script')
    <script type="text/javascript">
        $('[data-countdown]').each(function () {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime('%D hari %H:%M:%S'));
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-datatables').DataTable({
                "scrollX": true,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500, 1000],
                pagingType: 'numbers',
                dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
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
