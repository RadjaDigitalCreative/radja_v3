 @extends('layout.main')
 @section('title', $title)
 @section('content')

 <div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">
    <table class="table table-striped table-bordered">

      <thead>
        <tr>
          <th>No</th>
          <th>Komponen </th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        function rupiah($m)
        {
          $rupiah = "Rp ".number_format($m,0,",",".").",-";
          return $rupiah;
        }
        $nomor = 1;
        ?>
        @foreach($old_gaji as $row)
        <tr>
          <td>{{$nomor++}}</td>
          <td>{{$row->komponen}}</td>
          <td>+ {{rupiah($row->total)}}</td>
          <td align="center">
            <form id="data-{{ $row->id }}" action="{{route('pegawai.gaji.destroy',$row->id)}}" method="post">
              {{csrf_field()}}
              {{method_field('delete')}}

            </form>
            <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-outline-danger btn-sm remove"><i class="fa fa-trash"></i>&nbsp;Hapus</button>

          </td>
        </tr>
        @endforeach 
        @foreach($old_potongan as $row)
        <tr>
          <td>{{$nomor++}}</td>
          <td>{{$row->komponen}}</td>
          <td>- {{rupiah($row->total)}}</td>
          <td align="center">
            <form id="data-{{ $row->id }}" action="{{route('pegawai.gaji.destroy2',$row->id)}}" method="post">
              {{csrf_field()}}
              {{method_field('delete')}}
            </form>
            <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-outline-danger btn-sm remove"><i class="fa fa-trash"></i>&nbsp;Hapus</button>

          </td>
        </tr>
        @endforeach 

      </tbody>
    </table><br><br>
    <hr>
    <div class="card-header ">
      <h6 class="card-title">Tambah Komponen Gaji</h6>
    </div>
    <form action="{{route('pegawai.gaji.store')}}" method="post"  class="form-horizontal">
      @csrf
      @method('POST')
      <hr>
      <div class="row">
        <label class="col-md-3 col-form-label"><b>Komponen Gaji</b></label>
        <div class="col-md-9">
          <div id="app">
            <div class="row" v-for="(order, index) in orders" :key="index">
              <div class="col-md-4">
                <div class="form-group">
                  <input id="masking3[]" placeholder="Nama Gaji"  type="text" name="harga[]" class="form-control" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input  type="number" placeholder="Nominal" name="qty[]" class="form-control" >
                </div>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-sm" @click="delOrder(index)"><i class="fa fa-trash"></i></button>
                <button type="button" class="btn btn-success btn-sm" @click="addOrder()" ><i class="fa fa-plus"></i></button>
              </div>

            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <label class="col-md-3 col-form-label"><b>Komponen Potongan</b></label>
        <div class="col-md-9">
          <div id="appi">
            <div class="row" v-for="(order, index) in orders" :key="index">

              <div class="col-md-4">
                <div class="form-group">
                  <input id="masking3[]" placeholder="Nama Potongan"  type="text" name="potongan[]" class="form-control" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input  type="number" placeholder="Nominal" name="jumlah[]" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-sm" @click="delOrder(index)"><i class="fa fa-trash"></i></button>
                <button type="button" class="btn btn-success btn-sm" @click="addOrder()" ><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer ">
      <div class="row">
        <label class="col-md-3"></label>
        <div class="col-md-9">
          <button type="reset" class="btn btn-fill btn-danger">Reset</button>
          <button type="submit" class="btn btn-fill btn-success">Buat</button>
        </div>
      </div>
    </div>
  </form>
</div>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script type="text/javascript">
  new Vue({
    el: '#app',
    data: {
      orders: [
      {pesanan: 0, nama: "", harga: 0, jumlah: 1, subtotal: 0},
      ],
      discount: 0,
      note: "",
    },
    methods: {
      addOrder(){
        var orders = {pesanan: 0, nama: "", harga: 0, jumlah: 1, subtotal: 0};
        this.orders.push(orders);
      },
      delOrder(index){
        if (index > 0){
          this.orders.splice(index,1);
        }
      },
    },
  });
  new Vue({
    el: '#appi',
    data: {
      orders: [
      {pesanan: 0, nama: "", harga: 0, jumlah: 1, subtotal: 0},
      ],
      discount: 0,
      note: "",
    },
    methods: {
      addOrder(){
        var orders = {pesanan: 0, nama: "", harga: 0, jumlah: 1, subtotal: 0};
        this.orders.push(orders);
      },
      delOrder(index){
        if (index > 0){
          this.orders.splice(index,1);
        }
      },
    },
  });
</script>
@endsection
@endsection

