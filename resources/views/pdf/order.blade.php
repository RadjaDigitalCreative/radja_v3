<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  Radja Sistem <br><br><br>

  id : {{$data->id}} <br>
  note : {{$data->note}} <br>
  no. pesanan : {{$data->table_number}} <br>
  bayar : {{$data->discount}} <br>
  total : {{$data->total_semua}} <br>
  payment : {{$data->name}} <br>
  user : {{$data->name}} <br>
  lokasi : {{$data->lokasi}} <br>
  notelp : {{$data->notelp}} <br>
  kasir : {{$data->kasir}} <br>

  detail pembelian <br>
  @foreach($data2 as $row) <br>
  nama produk: {{$row->product_name}} <br>
  harga produk: {{$row->product_price}} <br>
  quantity: {{$row->quantity}} <br>
  note: {{$row->note}} <br>
  subtotal: {{$row->subtotal}} <br>
  created_at: {{$row->created_at}} <br>
  @endforeach

  <br><br><br>
  <p align="center"><b>TOTAL KESELEURUHAN: {{$data->total_semua}}</b><br><br>
    <b>TERIMAKASIH</b>
  </p>
</body>
</html>