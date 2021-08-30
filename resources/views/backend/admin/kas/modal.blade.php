<div id="app">
  <div style="text-align: center;" class="modal fade" id="modal-edit{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 900px">
     <div class="modal-content">
      <div class="full-page invoice-page section-image" filter-color="black" data-image="../../assets/img/bg13.jpg">
        <div class="content">
          <div class="container">

            <div class="row">
              <div class="col-12 text-right">
                <!--   <button type="button" name="button" class="btn btn-primary btn-round btn-sm">Download</button> -->
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <h4 class="card-title">Invoice <span class="font-weight-light">#{{$row->table_number}} {{$row->keperluan}}</span></h4>
                <h5 class="card-description mt-3 font-weight-bold">
                  <hr> Radja Kasir 
                </h5>
                <a target="_blank" href="{{ URL::to('/') }}/images/{{ $row->image }}" class="btn btn-primary btn-round">Bukti File</a>
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
                      <tr>
                        <td>{{$no++}}</td>
                        <td>{{$row->keperluan}}</td>
                        <td>{{$row->note}}</td>
                        <td>{{rupiah($row->total)}}</td>
                        <td>1</td>
                        <td>{{rupiah($row->total)}}</td>
                      </tr>
                      <tr>
                        <td colspan="5">Total</td>
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
                  Keperluan <br>
                  {{$row->payment->name}}
                </p>
              </div>
            </div>
          </div>
          <hr class="hr">
          <div class="card-footer text-center">
            <button type="button" class="btn btn-primary btn-round w-50 mt-3" name="button">Kirim Email</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
</div>

