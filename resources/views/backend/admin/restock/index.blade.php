@extends('layout.main')
@section('title', $title)
@section('content')
@if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase'))

<div class="card ">
    <div class="card-header ">
        <h4 class="card-title">{{$title}}</h4>
    </div>
    <div class="card-body ">
        <form method="post" method="post" action="{{route('restock.store')}}" class="form-horizontal">
            @csrf
            <div class="row">
                <label class="col-md-2 col-form-label">Cabang Toko</label>
                <div class="col-md-8">
                    <div class="form-group">
                        <select class="form-control" name="lokasi" required="">
                            <option value=""> --Pilih Lokasi--</option>
                            @foreach ($cab as $cab)
                            <option value="{{$cab->lokasi}}">{{$cab->lokasi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-md-2 col-form-label">Petugas Kasir</label>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control"
                               readonly="">
                    </div>
                </div>
                <label class="col-md-2 col-form-label">Tanggal Restock</label>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="created_at" value="{{date('d F Y')}}" class="form-control" readonly="">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-md-2 col-form-label">Supplier</label>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" name="supplier" required="">
                            <option value=""> --Pilih Supplier--</option>
                            @foreach ($supplier as $sup)
                            <option value="{{$sup->perusahaan}}">{{$sup->perusahaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="app">
                <div v-for="(order, index) in orders" :key="index">
                    <div class="row">
                        <label class="col-md-2 col-form-label">Stock Barang</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" name="pesanan[]" v-model="order.pesanan">
                                    @foreach ($pro as $mow)
                                    @if ($mow->status)
                                    <option value="{{$mow->id}}">{{$mow->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <input type="hidden" name="nama[]" :value="product_name(order.pesanan, index)">
                                <input type="hidden" name="harga[]" :value="product_price(order.pesanan, index)">
                                <input type="hidden" name="status[]" value="0">
                            </div>
                        </div>
                        <label class="col-md-2 col-form-label">Jumlah</label>
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="number" name="jumlah[]" class="form-control" value="{{old('jumlah')}}"
                                       id="inputJumlah" placeholder="ex: 2" v-model="order.jumlah">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="satuan[]" class="form-control" placeholder="Satuan"
                                       required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-form-label">Harga Beli</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="number" name="jumlah2[]" class="form-control" value="{{old('jumlah2')}}"
                                       id="inputJumlah2" placeholder="ex: 2" v-model="order.jumlah2" required="">
                            </div>
                        </div>

                        <label class="col-md-2 col-form-label">Subtotal</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="subtotal[]" class="form-control" readonly
                                       v-model="order.subtotal" :value="subtotal(order.jumlah2, order.jumlah, index)">
                                <button type="button" class="btn btn-danger btn-sm" @click="delOrder(index)"><i
                                        class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-success btn-sm" @click="addOrder()"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                </div>
                <br>
                <div style="text-align: center; font-size: 24px;" class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="discount" class="form-control" v-model="discount" required="">
                        <input type="hidden" name="total" :value="total" readonly="">
                        <b>Total Rp @{{rupiah(total)}}</b>
                    </div>
                </div>
            </div>


    </div>
    <br>
    <div class="card-footer ">
        <div class="row">
            <label class="col-md-3"></label>
            <div class="col-md-9">
                <button type="reset" class="btn btn-fill btn-danger">Reset</button>
                <button type="submit" class="btn btn-fill btn-success">Masuk</button>
            </div>
        </div>
    </div>
    </form>

</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Barang Inden</h4>
                <form class="form-inline float-right" action="{{route('restock.index')}}" method="get">
                    @csrf
                    <div class="form-group mx-sm-3">
                        <input type="text" class="form-control" id="name" name="lokasi" placeholder="Masukkan Lokasi">
                        <button type="submit" class="btn btn-primary btn-round">Cari</button>
                    </div>
                </form>
                <div class="btn-group">
                    <br><br><br>
                </div>
                <!-- Example split danger button -->

            </div>
            <div class="card-body">
                <div class="toolbar">
                </div>
                <table id="table-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead style="font-size: 11px;">
                    <tr>
                        <th>No</th>
                        <th>Penanggung Jawab</th>
                        <th>Cabang</th>
                        <th>Barang</th>
                        <th>Harga Beli</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Input</th>
                        <th class="disabled-sorting text-right">Hapus</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>

                        <th colspan="4" class="text-center">Total</th>
                        <th>Harga Beli</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Input</th>
                        <th class="disabled-sorting text-right">Hapus</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @php
                    $nomor = 1;
                    @endphp
                    @foreach ($stock as $row)
                    @if(($row->lokasi) == (auth()->user()->lokasi) && (auth()->user()->level) =='Admin')
                    <tr>
                        <td>{{$nomor++}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->lokasi}}</td>
                        <td>{{$row->product_name}}</td>
<!--                        <td>Rp --><?php //echo number_format($row->product_price) ?><!--</td>-->
                        <td> - </td>
                        <td>{{$row->quantity}} {{$row->satuan}}</td>
<!--                        <td>Rp --><?php //echo number_format($row->subtotal) ?><!--</td>-->
                        <td> - </td>
                        <td>
                            @if($row->status == 0 && auth()->user()->level == 'Owner')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="1" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Konfirmasi</button>
                            </form>
                            @elseif($row->status == 1 && auth()->user()->level == 'Owner')
                            <span class="label bg-blue">Pengiriman</span>
                            @elseif($row->status == 0 && auth()->user()->level == 'Purchase')
                            <span class="label bg-red">Belum Terkonfirmasi</span>
                            @elseif($row->status == 1 && auth()->user()->level == 'Purchase')
                            <span class="label bg-blue">Pengiriman</span>
                            @elseif($row->status == 0 && auth()->user()->level == 'Admin')
                            <span class="label bg-blue">Proses</span>
                            @elseif($row->status == 1 && auth()->user()->level == 'Admin')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="2" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Terima Barang</button>
                            </form>
                            @elseif($row->status == 2 && auth()->user()->level == 'Owner')
                            <span class="label bg-green">Barang diterima</span>
                            @elseif($row->status == 2 && auth()->user()->level == 'Purchase')
                            <span class="label bg-green">Barang diterima</span>
                            @elseif($row->status == 2 && auth()->user()->level == 'Admin')
                            <span class="label bg-green">Barang diterima</span>
                            @endif

                        </td>
                        <td>
                            @if($row->status == 2)
                            <form action="{{route('restock.stock',$row->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="{{$row->stock}}" type="hidden" name="stock" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->quantity}}" type="hidden" name="hasil" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->product_name}}" type="hidden" name="barang" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->lokasi}}" type="hidden" name="lokasi" class="form-control"
                                       placeholder="Masukkan Kode lokasi">
                                <input value="{{$row->id_produk}}" type="hidden" name="product_id" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="3" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->product_price}}" type="hidden" name="harga_beli"
                                       class="form-control" placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="btn btn-primary btn-sm"
                                        onclick='javascript:return confirm("Apakah anda yakin ingin mengkonfirmasi data ini?")'>
                                    <i class="fa fa-plus"></i></button>
                            </form>
                        </td>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @elseif($row->status <= 2)
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @elseif($row->status = 3)
                        <span class="label bg-green">Tersimpan</span>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @endif
                    </tr>

                    <!-- BASE OWNERR --><!-- BASE OWNERR --><!-- BASE OWNERR --><!-- BASE OWNERR -->
                    @elseif(auth()->user()->level =='Owner')
                    <tr role="row" class="odd">
                        <td>{{$nomor++}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->lokasi}}</td>
                        <td>{{$row->product_name}}</td>
                        <td>Rp <?php echo number_format($row->product_price) ?></td>
                        <td>{{$row->quantity}} {{$row->satuan}}</td>
                        <td>Rp <?php echo number_format($row->subtotal) ?></td>
                        <td>
                            @if($row->status == 0 && auth()->user()->level == 'Owner')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="1" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Konfirmasi</button>
                            </form>
                            @elseif($row->status == 1 && auth()->user()->level == 'Owner')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="2" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Terima Barang</button>
                            </form>
                            @elseif($row->status == 0 && auth()->user()->level == 'Purchase')
                            <span class="label bg-red">Belum Terkonfirmasi</span>
                            @elseif($row->status == 1 && auth()->user()->level == 'Purchase')
                            <span class="label bg-blue">Pengiriman</span>
                            @elseif($row->status == 0 && auth()->user()->level == 'Admin')
                            <span class="label bg-blue">Proses</span>
                            @elseif($row->status == 1 && auth()->user()->level == 'Admin')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="2" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Terima Barang</button>
                            </form>
                            @elseif($row->status == 2 && auth()->user()->level == 'Owner')
                            <span class="label bg-green">Barang diterima</span>
                            @elseif($row->status == 2 && auth()->user()->level == 'Purchase')
                            <span class="label bg-green">Barang diterima</span>
                            @elseif($row->status == 2 && auth()->user()->level == 'Admin')
                            <span class="label bg-green">Barang diterima</span>
                            @endif
                        </td>

                        <td>
                            @if($row->status == 2)
                            <form action="{{route('restock.stock',$row->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="{{$row->stock}}" type="hidden" name="stock" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->quantity}}" type="hidden" name="hasil" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->product_name}}" type="hidden" name="barang" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->lokasi}}" type="hidden" name="lokasi" class="form-control"
                                       placeholder="Masukkan Kode lokasi">
                                <input value="{{$row->id_produk}}" type="hidden" name="product_id" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="3" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->product_price}}" type="hidden" name="harga_beli"
                                       class="form-control" placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="btn btn-primary btn-sm"
                                        onclick='javascript:return confirm("Apakah anda yakin ingin mengkonfirmasi data ini?")'>
                                    <i class="fa fa-plus"></i></button>
                            </form>
                        </td>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @elseif($row->status <= 2)
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @elseif($row->status = 3)
                        <span class="label bg-green">Tersimpan</span>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @endif
                    </tr>

                    <!-- BASE PURCAHSE --><!-- BASE PURCAHSE --><!-- BASE PURCAHSE --><!-- BASE PURCAHSE -->
                    @elseif(auth()->user()->level =='Purchase')
                    @foreach ($role_cabang as $teling)
                    @if(($teling->user_id) == (auth()->user()->id))

                    <tr role="row" class="odd">
                        <td>{{$nomor++}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->lokasi}}</td>
                        <td>{{$row->product_name}}</td>
                        <td>Rp <?php echo number_format($row->product_price) ?></td>
                        <td>{{$row->quantity}} {{$row->satuan}}</td>
                        <td>Rp <?php echo number_format($row->subtotal) ?></td>
                        <td>
                            @if($row->status == 0 && auth()->user()->level == 'Owner')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="1" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Konfirmasi</button>
                            </form>
                            @elseif($row->status == 1 && auth()->user()->level == 'Owner')
                            <span class="label bg-blue">Pengiriman</span>
                            @elseif($row->status == 0 && auth()->user()->level == 'Purchase')
                            <span class="label bg-red">Belum Terkonfirmasi</span>
                            @elseif($row->status == 1 && auth()->user()->level == 'Purchase')
                            <span class="label bg-blue">Pengiriman</span>
                            @elseif($row->status == 0 && auth()->user()->level == 'Admin')
                            <span class="label bg-blue">Proses</span>
                            @elseif($row->status == 1 && auth()->user()->level == 'Admin')
                            <form action="{{route('restock.status',$row->id)}}" method="post" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="2" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="label bg-red">Terima Barang</button>
                            </form>
                            @elseif($row->status == 2 && auth()->user()->level == 'Owner')
                            <span class="label bg-green">Barang diterima</span>
                            @elseif($row->status == 2 && auth()->user()->level == 'Purchase')
                            <span class="label bg-green">Barang diterima</span>
                            @elseif($row->status == 2 && auth()->user()->level == 'Admin')
                            <span class="label bg-green">Barang diterima</span>
                            @endif
                        </td>
                        @if($row->status == 2)
                        <td>
                            <form action="{{route('restock.stock',$row->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input value="{{$row->stock}}" type="hidden" name="stock" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->quantity}}" type="hidden" name="hasil" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->product_name}}" type="hidden" name="barang" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->id_produk}}" type="hidden" name="product_id" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->lokasi}}" type="hidden" name="lokasi" class="form-control"
                                       placeholder="Masukkan Kode lokasi">
                                <input value="3" type="hidden" name="status" class="form-control"
                                       placeholder="Masukkan Kode Inventaris">
                                <input value="{{$row->product_price}}" type="hidden" name="harga_beli"
                                       class="form-control" placeholder="Masukkan Kode Inventaris">
                                <button type="submit" class="btn btn-primary btn-sm"
                                        onclick='javascript:return confirm("Apakah anda yakin ingin mengkonfirmasi data ini?")'>
                                    <i class="fa fa-plus"></i></button>
                            </form>
                        </td>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form id="data-{{ $row->id }}" action="{{route('restock.destroy',$row->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="deleteRow( {{ $row->id }} )"
                                    class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i>
                            </button>
                            @endif
                        </td>
                        @elseif($row->status <= 2)
                        <td></td>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form action="{{route('restock.destroy',$row->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick='javascript:return confirm("Apakah anda yakin ingin mengkonfirmasi data ini?")'>
                                    <i class="fa fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                        @elseif($row->status = 3)
                        <td><span class="label bg-green">Tersimpan</span></td>
                        <td>
                            @if((auth()->user()->level == 'Owner') or (auth()->user()->level == 'Purchase') )
                            <form action="{{route('restock.destroy',$row->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick='javascript:return confirm("Apakah anda yakin ingin mengkonfirmasi data ini?")'>
                                    <i class="fa fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>

                    @endif
                    @endforeach
                    @endif
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script type="text/javascript">
        new Vue({
            el: '#app',
            data: {
                orders: [
                    {pesanan: 0, nama: "", harga: 0, jumlah: 1, jumlah2: 1, subtotal: 0},
                ],
                discount: 0,
            },
            methods: {
                addOrder() {
                    var orders = {pesanan: 0, nama: "", harga: 0, jumlah: 1, jumlah2: 1, subtotal: 0};
                    this.orders.push(orders);
                },
                delOrder(index) {
                    if (index > 0) {
                        this.orders.splice(index, 1);
                    }
                },
                subtotal(jumlah2, jumlah, index) {
                    var subtotal = jumlah2 * jumlah;
                    this.orders[index].subtotal = subtotal;
                    return subtotal;
                },
                rupiah(total) {
                    let val = (total / 1).toFixed(2).replace('.', ',')
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                },
                product_name(pesanan, index) {
                    var product_name = this.nama[pesanan];
                    this.orders[index].nama = product_name;
                    return product_name;
                },
                product_price(pesanan, index) {
                    var product_price = this.produk[pesanan];
                    this.orders[index].harga = product_price;
                    return product_price;
                },
            },
            computed: {
                produk() {
                    let produk = [];
                    produk[0] = 0;
                    @foreach ($pro as $produk)
                        produk[{{$produk->id}}] =
                    {{$produk->price}}
                    @endforeach
                        return produk;
                },
                nama() {
                    let produk = [];
                    produk[0] = 0;
                    @foreach ($pro as $produk)
                        produk[{{$produk->id}}] = "{{$produk->name}}"
                    @endforeach
                        return produk;
                },
                total() {
                    var total = this.orders
                        .map(order => order.subtotal)
                        .reduce((prev, next) => prev + next);
                    return total - (total * this.discount / 100);
                },
            }
        });
    </script>
    <script type="text/javascript">
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function (e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_id').DataTable();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-datatables').DataTable({
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
                    // Total over all pages
                    total = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(4, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var reverse = pageTotal.toString().split('').reverse().join(''),
                        a = reverse.match(/\d{1,3}/g);
                    a = a.join('.').split('').reverse().join('');
                    // Update footer
                    $(api.column(4).footer()).html(
                        'Rp ' + a
                    );

                    // total 2
                    total = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(5, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        pageTotal
                    );

                    // total 3
                    total = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(6, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var reverse = pageTotal.toString().split('').reverse().join(''),
                        b = reverse.match(/\d{1,3}/g);
                    b = b.join('.').split('').reverse().join('');
                    // Update footer
                    $(api.column(6).footer()).html(
                        'Rp ' + b
                    );
                }
            });
        });
    </script>
@endsection

@endsection
