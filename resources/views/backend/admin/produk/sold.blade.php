<div style="text-align: center;" class="modal fade" id="modal-sold{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Record {{$title}}</h3>
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
                  <th>Keperluan</th>
                  <th>Masuk/Keluar</th>
                  <th>Cabang</th>
                  <th>Tanggal </th>
                </tr>
              </thead>

              <tbody>
                <?php $stock =0; ?>
                <?php $stock2 =0; ?>
                <?php $hasil =0; ?>

                @foreach ($terjual as $teling)
                @if ($row->name == $teling->name )
                <tr>
                  <td>{{$teling->name}}</td>
                  <td>{{$teling->keperluan}}</td>
                  @if($teling->keperluan == 'Penjualan')
                  <td><span class="badge badge-pill badge-success">{{$teling->terjual}}</span> barang</td>
                  @else
                  <td><span class="badge badge-pill badge-danger">{{$teling->terjual}}</span> barang</td>
                  @endif
                  <td>{{$teling->cabang}}</td>
                  <td>{{$teling->updated_at}}</td>
                </tr>
                @if ($teling->keperluan =='Penjualan')
                <?php $stock += $teling->terjual ; ?>
                @elseif ($teling->keperluan !='Penjualan')
                <?php $stock2 += $teling->terjual ; ?>
                @endif
                <?php $hasil = $stock2 - $stock ; ?>
                @endif
                @endforeach
              </tbody>
              
                <tr>
                 <td>{{$teling->name}}</td>
                 <td>Stock Akhir</td>
                 <td><span class="badge badge-pill badge-success">{{$hasil}}</span> barang</td>
                 <td>{{$teling->cabang}}</td>
                 <td>{{$teling->updated_at}}</td>
               </tr>
  
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

<img src="">

