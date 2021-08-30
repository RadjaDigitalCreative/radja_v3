<div style="text-align: center;" class="modal fade" id="modal-edit{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>{{$title}}</h3>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
      </div>
      <div class="modal-header center">
        <img style="display: block; margin: 0 auto;" width="20%" height="20%" src="{{ URL::to('/') }}/images/{{ $row->image }}">
    </div>
    <div id="#{{$row->id}}" class="modal-body">
      <div class="instruction">
        <div class="row">
          <div class="col-md-12">
           <table class="table table-striped">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Merk</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Status</th>
                <th>Stock</th>
                <th>Stock Minim</th>
                <th>Cabang</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$row->name}}</td>
                <td>{{$row->merk}}</td>
                <td>Rp <?php echo number_format($row->purchase_price) ?></td>
                <td>Rp <?php echo number_format($row->price) ?></td>
                @if ($row->status == 1)
                <td>Ada</td>
                @else
                <td>Kosong</td>
                @endif
                <td>{{$row->stock}} {{$row->satuan}}</td>
                <td>{{$row->stock_minim}} {{$row->satuan}}</td>
                <td>{{$row->lokasi}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-center">
    <a href="{{url('admin/item/'.$row->id.'/edit')}}" class="btn btn-warning btn-icon edit"><i class="far fa-calendar-alt"></i></a>
    <form id="data-{{ $row->id }}" action="{{route('item.destroy',$row->id)}}" method="post">
      {{csrf_field()}}
      {{method_field('delete')}}
    </form>
    @csrf
    @method('DELETE')
    <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-round btn-danger btn-icon remove"><i class="fas fa-times"></i></button>
  </div>
</div>
</div>
</div>

