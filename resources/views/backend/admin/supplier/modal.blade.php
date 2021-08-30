<div style="text-align: center;" class="modal fade" id="modal-edit{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>{{$row->nama}} ({{$row->notelp}}) </h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
      </div>
      <div id="#{{$row->id}}" class="modal-body">
        <div class="instruction">
          <div class="row">
            <div class="col-md-12">
             <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Perusahaan</th>
                  <th>Produk</th>
                  <th>Dibuat pada</th>
                  <th>Dirubah Pada</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$row->nama}}</td>
                  <td>{{$row->perusahaan}}</td>
                  <td>{{$row->produk}}</td>
                  <td>{{date('d F Y', strtotime($row->created_at))}} - {{date('H:i', strtotime($row->created_at))}} WIB</td>
                  <td>{{date('d F Y', strtotime($row->updated_at))}} - {{date('H:i', strtotime($row->updated_at))}} WIB</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-center">
      <a href="{{url('admin/supplier/'.$row->id.'/edit')}}" class="btn btn-warning btn-icon edit"><i class="far fa-calendar-alt"></i></a>
      <form id="data-{{ $row->id }}" action="{{route('supplier.destroy',$row->id)}}" method="post">
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

