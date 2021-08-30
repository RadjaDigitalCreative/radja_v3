<div id="app">
    <div style="text-align: center;" class="modal fade" id="modal-edit{{$row->id}}" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 900px">
            <div class="modal-content">
                <div class="full-page invoice-page section-image" filter-color="black"
                     data-image="../../assets/img/bg13.jpg">
                    <div class="content">
                        <div class="container">

                            <div class="row">
                                <div class="col-12 text-right">

                                </div>
                            </div>
                        <!--   <a id="modal-edit{{$row->id}}" href="{{ route('order.show', $row->id) }}" target="_blank" class="btn btn-default btn-sm pull-left"><i class="fa fa-print"></i> Cetak</a> -->
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title">Invoice <span
                                            class="font-weight-light">#{{$row->table_number}}</span></h4>
                                    <h5 class="card-description mt-3 font-weight-bold">
                                        <hr>
                                        Radja Sistem <br>

                                    </h5>
                                    ( {{$row->jenis_penjualan}} )
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-3">
                                            <thead>
                                            <tr>
                                                <th class="pl-0">
                                                    <h6 class="font-weight-bold text-capitalize">No</h6>
                                                </th>
                                                <th class="px-0 ">
                                                    <h6 class="font-weight-bold text-capitalize">Pesanan</h6>
                                                </th>
                                                <th class="pr-0 text-center">
                                                    <h6 class="font-weight-bold text-capitalize">Catatan</h6>
                                                </th>
                                                <th class="pr-0 text-center">
                                                    <h6 class="font-weight-bold text-capitalize">Price</h6>
                                                </th>
                                                <th class="pr-0 text-center">
                                                    <h6 class="font-weight-bold text-capitalize">Jumlah</h6>
                                                </th>
                                                <th class="pr-0 text-center">
                                                    <h6 class="font-weight-bold text-capitalize">Subtotal</h6>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($row->orderDetail as $odt)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$odt->product_name}}</td>
                                                    <td>{{$odt->note}}</td>
                                                    <td>{{rupiah($odt->product_price)}}</td>
                                                    <td>{{$odt->quantity}}</td>
                                                    <td>{{rupiah($odt->subtotal)}}</td>
                                                </tr>
                                            @endforeach
                                            @if($row->disc != NULL)
                                                <tr>
                                                    <td colspan="5">Discount</td>
                                                    <td>{{($row->disc)}} %</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="5">Total Bayar</td>
                                                <td>{{rupiah( ($row->orderDetail->sum('subtotal')) - $row->orderDetail->sum('subtotal') * ($row->disc / 100) ) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Bayar</td>
                                                <td>{{rupiah($row->discount)}} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><b>Kembali</b></td>
                                                <td>
                                                    <b>{{rupiah($row->discount - (($row->orderDetail->sum('subtotal')) - ($row->orderDetail->sum('subtotal') * ($row->disc / 100))) )}}</b>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 col-md-6">

                                    <h6 class="text-uppercase card-description font-weight-bold mb-3">
                                        Invoiced from
                                    </h6>
                                    <p class="mb-4">
                                        <strong>{{$row->user->name}}</strong> <br>
                                        {{date('d F Y', strtotime($row->created_at))}} <br>
                                        {{date('H:i', strtotime($row->created_at))}} WIB
                                    </p>
                                </div>
                                <div class="col-12 col-md-6 ">
                                    <h6 class="text-uppercase card-description font-weight-bold mb-3">
                                        Invoiced to
                                    </h6>
                                    <p class="mb-4">
                                        <strong>{{$row->name}}</strong> <br>
                                        Metode Pembayaran <br>
                                        {{$row->payment->name}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr class="hr">
                        <div class="card-footer text-center">

                            <form method="post" action="{{ route('order.mail', $row->id) }}">
                            @csrf
                            <!--      <a href="{{ route('order.show', $row->id) }}" target="_blank" class="btn btn-default btn-sm pull-left"><i class="fa fa-print"></i> Cetak</a>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-send"></i> Kirim via Email</button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button> -->
                                <!--<button type="submit" class="btn btn-primary btn-round w-5 mt-1" name="button">Kirim Email</button>-->
                                <a id="modal-edit{{$row->id}}" href="{{ route('order.show', $row->id) }}"
                                   target="_blank" href="">
                                    <button type="button" name="button" class="btn btn-primary btn-round ">Download
                                    </button>
                                </a>
                                <a target="_blank" href="https://api.whatsapp.com/send?phone={{$row->notelp}}"
                                   class="btn btn-success btn-round w-5 mt-1"><i
                                        class="fas fa-upload"></i> {{$row->notelp}}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


