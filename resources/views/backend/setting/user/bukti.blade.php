
<div style="text-align: center;" class="modal fade" id="modal-bukti{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Bukti Pembayaran</h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
      </div>
      <div id="#{{$row->id}}" class="modal-body">
        <div class="instruction">
          <div class="row">
            <div class="col-md-12">
              @if($row->image == NULL)
              <h3>Belum Mengirim Bukti Pembayaran</h3>
              @else
              <img width="50%" height="50%" src="{{ URL::to('/') }}/images/{{ $row->image }}">
              <hr>
              <div class="row">
                <label class="col-md-3 col-form-label">Total Pembayaran</label>
                <div class="col-md-9">
                  <div class="form-group">
                    <input type="text" value="{{ rupiah($row->harga) }}" class="form-control" readonly="" >
                  </div>
                </div>
                <label class="col-md-3 col-form-label">Bank</label>
                <div class="col-md-9">
                  <div class="form-group">
                    <input type="text" value="{{ $row->bank }}" class="form-control" readonly="" >
                  </div>
                </div>
                <label class="col-md-3 col-form-label">Rentan Pemakaian</label>
                <div class="col-md-9">
                  <div class="form-group">
                    <input type="text" value="{{ $row->tgl_bayar }}" class="form-control" readonly="" >
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <form action="{{route('transfer.konfirmasi', $row->id)}}" method="post">
          {{ csrf_field() }}
          {{ method_field('PATCH')}}
          <input type="hidden" name="user_id" value="{{$row->id}}">
          <input type="hidden" name="dibayar" value="{{$row->tgl_bayar}}">
          <td><button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button></td>
        </form>
      </div>
    </div>
  </div>
</div>

