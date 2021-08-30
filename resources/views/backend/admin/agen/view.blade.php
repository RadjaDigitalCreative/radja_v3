<div style="text-align: center;" class="modal fade" id="modal-bonus{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Member Agen Distributor</h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
      </div>
      <div  class="modal-body">
        <div class="instruction">
          <div class="row">
            <div class="col-md-12">
             <table id="table-sold" class="table table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>No. Telp</th>
                  <th>Cabang</th>
                  <th>Tanggal Daftar </th>
                </tr>
              </thead>

              <tbody>
                @php
                $nomor = 1;
                @endphp
                @foreach ($view as $links)
                @if($row->referal == $links->referal)
                <tr>
                  <td>{{$links->name}}</td>
                  <td>{{$links->email}}</td>
                  <td>{{$links->notelp}}</td>
                  <td>{{$links->lokasi}}</td>
                  <td>{{$links->created_at}}</td>

                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-center">
      <!--  -->
    </div>
  </div>
</div>
</div>

@section('script')
<script type="text/javascript">
  $('[data-countdown]').each(function() {
   var $this = $(this), finalDate = $(this).data('countdown');
   $this.countdown(finalDate, function(event) {
     $this.html(event.strftime('%D hari %H:%M:%S'));
   });
 });
</script>
@endsection