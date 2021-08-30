<div style="text-align: center;" class="modal fade" id="modal-absen{{$k->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                  <th>Masuk</th>
                  <th>Keluar</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>{{$k->created_at}}</td>
                  <td>{{$k->updated_at}}</td>
                </tr>
                
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


