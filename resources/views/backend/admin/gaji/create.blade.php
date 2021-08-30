 @extends('layout.main')
 @section('title', $title)
 @section('content')

 <div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}}</h4>
  </div>
  <div class="card-body ">


    <form action="{{route('pegawai.gaji.store')}}" method="post"  class="form-horizontal">
      @csrf
      @method('POST')
      <div class="row">
        <label class="col-md-3 col-form-label"><b>Pegawai</b></label>

        <div class="col-md-7">
          <select name="user_id" id="SelectLm" class="form-control form-control">
            <option >Silahkan Pilih Pegawai</option>
            @foreach($pegawai as $data)
            <option value="{{$data->id}}">{{$data->name}}</option>
            @endforeach
          </select>
        </div>
      </div><br> <hr>
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
                  <input  type="number" placeholder="Nominal" name="jumlah[]" class="form-control" >
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

<div class="accordion" id="accordionExample-lembur">
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#modal-showlembur" aria-expanded="false" aria-controls="collapseTwo">
          <h6 style="font-size: 18px;">tambah gaji lembur</h6>
          
        </button>
      </h2>
    </div>
    <div id="modal-showlembur" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample-lembur">
      <div class="card-body">
        <form action="{{route('pegawai.lembur.store')}}" method="post"  class="form-horizontal">
          @csrf
          @method('POST')
          <div class="row">
            <label class="col-md-3 col-form-label"><b>Jam </b></label>
            <div class="col-md-9">
              <div id="app">
                <div class="row" v-for="(order, index) in orders" :key="index">
                  <div class="col-md-4">
                    <div class="form-group">
                      <input  placeholder="jam mulai"  type="time" name="jam_masuk_lembur" class="form-control" >
                    </div>
                  </div>
                  <label class="col-form-label"><b>s/d </b></label>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input  type="time" placeholder="jam berakhir" name="jam_keluar_lembur" class="form-control" >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <label class="col-md-3 col-form-label"><b>Tambahan Gaji Lembur</b></label>
            <div class="col-md-9">
              <div id="appi">
                <div class="row" v-for="(order, index) in orders" :key="index">

                  <div class="col-md-5">
                    <div class="form-group">
                      <input placeholder="Nama Gaji Lembur"  type="text" name="nama" class="form-control" >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input  type="number" placeholder="Nominal Per Jam" name="gaji" class="form-control" >
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
                <button type="submit" class="btn btn-fill btn-success">Buat Gaji Lembur</button>
              </div>
            </div>
          </div>
        </div>
      </form>
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

