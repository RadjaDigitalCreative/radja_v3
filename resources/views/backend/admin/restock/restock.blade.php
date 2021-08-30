@extends('layout.main')
@section('title', $title)
@section('content')
<div class="card ">
  <div class="card-header ">
    <h4 class="card-title">{{$title}} Terpilih</h4>
  </div>
  <div class="card-body ">
    <form method="post" method="post" action="{{route('restock.store2')}}" class="form-horizontal">
      @csrf
      <div class="row">
        <label class="col-md-2 col-form-label">Cabang Toko</label>
        <div class="col-md-8">
          <div class="form-group">
            @if(auth()->user()->level == 'Owner')
            <select class="form-control" name="lokasi" required="">
              <option value=""> --Pilih Cabang-- </option>
              @foreach ($cab as $cab)
              <option value="{{$cab->lokasi}}">{{$cab->lokasi}}</option>
              @endforeach
            </select>
            @elseif(auth()->user()->level != 'Owner')
            <input type="text" name="lokasi" value="{{$req2}}" class="form-control" readonly="">
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-2 col-form-label">Petugas Kasir</label>
        <div class="col-md-3">
          <div class="form-group">
            <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control" readonly="">
          </div>
        </div>
        <label class="col-md-2 col-form-label">Tanggal Restock</label>
        <div class="col-md-3">
          <div class="form-group">
            <input type="text" name="created_at" value="{{date('d F Y')}}" class="form-control" readonly="">
          </div>
        </div>
      </div>
      <div class="row">
        <label class="col-md-2 col-form-label">Supplier</label>
        <div class="col-md-3">
          <div class="form-group">
           <select class="form-control" name="supplier" required="">
            <option value=""> --Pilih Supplier-- </option>
            @foreach ($supplier as $sup)
            <option value="{{$sup->perusahaan}}">{{$sup->perusahaan}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <div id="app">
      <div  v-for="(order, index) in orders" :key="index">
        <div class="row">
          <label class="col-md-2 col-form-label">Stock Barang</label>
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" name="barang[]"   value="{{$req1}}" class="form-control" readonly="">
              <input type="hidden" name="nama[]" :value="product_name(order.pesanan, index)">
              <input type="hidden" name="harga[]" :value="product_price(order.pesanan, index)">
              <input type="hidden" name="status[]" value="0"> 
            </div>
          </div>
          <label class="col-md-2 col-form-label">Jumlah</label>
          <div class="col-md-2">
            <div class="form-group">
              <input type="number" name="jumlah[]" class="form-control" value="{{old('jumlah')}}" id="inputJumlah" placeholder="ex: 2" v-model="order.jumlah">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <input type="text" name="satuan[]" class="form-control" value="{{$req3}}" id="inputJumlah" readonly="">
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-md-2 col-form-label">Harga Beli</label>
          <div class="col-md-4">
            <div class="form-group">
             <input  type="number" name="jumlah2[]" class="form-control" value="{{old('jumlah2')}}" id="inputJumlah2" placeholder="ex: 2" v-model="order.jumlah2" required="">
           </div>
         </div>

         <label class="col-md-2 col-form-label">Subtotal</label>
         <div class="col-md-3">
          <div class="form-group">
            <input  type="text" name="subtotal[]" class="form-control" readonly v-model="order.subtotal" :value="subtotal(order.jumlah2, order.jumlah, index)">
            <button type="button" class="btn btn-danger btn-sm" @click="delOrder(index)"><i class="fa fa-trash"></i></button>
            <button type="button" class="btn btn-success btn-sm" @click="addOrder()" ><i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">

    </div><br>
    <div style="text-align: center; font-size: 24px;" class="row">
     <div class="col-md-12">
      <input type="hidden" name="discount" class="form-control" v-model="discount" required="">
      <input type="hidden" name="total" :value="total" readonly="">
      <b>Total Rp @{{rupiah(total)}}</b>
    </div>
  </div>
</div>

</div><br>
<div class="card-footer ">
  <div class="row">
    <label class="col-md-3"></label>
    <div class="col-md-9">
      <button type="reset" class="btn btn-fill btn-danger">Reset</button>
      <button type="submit" class="btn btn-fill btn-success">Masuk</button>
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
      {pesanan: 0, nama: "", harga: 0, jumlah: 1, jumlah2: 1, subtotal: 0},
      ],
      discount: 0,
    },
    methods: {
      addOrder(){
        var orders = {pesanan: 0, nama: "", harga: 0, jumlah: 1, jumlah2: 1, subtotal: 0};
        this.orders.push(orders);
      },
      delOrder(index){
        if (index > 0){
          this.orders.splice(index,1);
        }
      },
      subtotal( jumlah2, jumlah, index){
        var subtotal  = jumlah2*jumlah;
        this.orders[index].subtotal = subtotal;
        return subtotal;
      },
      rupiah(total){
        let val = (total/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      },
      product_name(pesanan, index){
        var product_name = this.nama[pesanan];
        this.orders[index].nama = product_name;
        return product_name;
      },
      product_price(pesanan, index){
        var product_price = this.produk[pesanan];
        this.orders[index].harga = product_price;
        return product_price;
      },
    },
    computed: {
      produk(){
        let produk  = [];
        produk[0] = 0;
        @foreach ($pro as $produk)
        produk[{{$produk->id}}]  = {{$produk->price}}
        @endforeach
        return produk;
      },
      nama(){
        let produk  = [];
        produk[0] = 0;
        @foreach ($pro as $produk)
        produk[{{$produk->id}}]  = "{{$produk->name}}"
        @endforeach
        return produk;
      },
      total(){
        var total = this.orders
        .map(order=>order.subtotal)
        .reduce((prev, next)=>prev+next);
        return total - (total * this.discount / 100);
      },
    }
  });
</script>
<script type="text/javascript">
  var rupiah = document.getElementById('rupiah');
  rupiah.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
      rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

  /* Fungsi formatRupiah */
  function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split       = number_string.split(','),
    sisa        = split[0].length % 3,
    rupiah        = split[0].substr(0, sisa),
    ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
  </script>
  <script type="text/javascript">
    $(document).ready( function () {
      $('#table_id').DataTable();
    } );
  </script>

  @endsection
  @endsection
