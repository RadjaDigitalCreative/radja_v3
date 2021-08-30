@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{$title}}</h4>
        @if(auth()->user()->id_team == 1) 
        <div  class="btn-group">
          <a href="{{route('agen.create')}}"><button type="button" class="btn btn-primary"><i class="now-ui-icons ui-1_simple-add"></i> Generate Code Agen</button></a>
        </div>
        @endif

      </div>
      <div class="card-body">
        <div class="toolbar">

        </div>
        @foreach ($link as $links)
        @if($links->referal != NULL)
        @if($links->id_team == auth()->user()->id_team)

        <div class="accordion" id="accordionExample-{{$links->id}}">
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h2 class="mb-0">

                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#modal-show{{$links->id}}" aria-expanded="false" aria-controls="collapseTwo">
                  <h6 style="font-size: 18px;">{{$links->name}}</h6>
                  <h6 style="font-size: 18px; float: right;">#{{$links->referal}}</h6>
                </button>
              </h2>
            </div>
            <div id="modal-show{{$links->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample-{{$links->id}}">
              <div class="card-body">
                <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Referal</th>
                      <th>Payment</th>
                      <th>Masa Pemakaian</th>
                      <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Referal</th>
                      <th>Payment</th>
                      <th>Masa Pemakaian</th>
                      <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @php
                    $nomor = 1;
                    @endphp
                    @foreach ($data-> sortbyDesc('dibayar') as $row)
                    @if ($links->referal == $row->referal && $row->agen == 2)
                    <tr>
                     <td>{{$nomor++}}</td>
                     <td>{{$row->name}}</td>
                     <td>
                      @if(auth()->user()->id_team == 1 && $row->id_team == 1)
                      Super
                      @endif
                      {{$row->level}}
                    </td>
                    @if ($row->referal2 == NULL)
                    <td><a href="{{ route('agen.kedua', $row->id)}}" class="btn btn-success"><i class="now-ui-icons business_money-coins"></i> Create Agen Kedua</a></td>
                    @else
                    <td>{{$row->referal2}}</td>
                    @endif
                    @if($row->dibayar >= now() && $row->pay == 2 )
                    <td>Terlunasi</td>
                    <td><button class="btn btn-success"><span class="clock" data-countdown="{{$row->dibayar}}"></span></button></td>
                    @elseif($row->pay ==1)
                    <form action="{{route('transfer.konfirmasi', $row->id)}}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('PATCH')}}
                      <input type="hidden" name="user_id" value="{{$row->id}}">
                      <input type="hidden" name="dibayar" value="{{$row->tgl_bayar}}">
                      <td>Terlunasi</td>
                      <td><button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button></td>
                    </form>
                    @else
                    <td>Belum Terlunasi</td>
                    <td>Telah Berakhir</span></td>
                    @endif
                    <td class="text-right">
                      @if(auth()->user()->level == 'Owner') 
                      @if($row->dibayar >= now() && $row->pay == 2 ) 
                      <form id="data-{{ $row->id }}" action="{{route('user.destroy',$row->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                      </form>
                      <a target="_blank" href="https://wa.me/{{$row->notelp}}"  class="btn btn-round btn-success btn-icon btn-sm edit"><i class="far fa-address-book"></i></a>
                      <a href="{{url('admin/user/'.$row->id.'/edit')}}" data-toggle="modal" data-target="#modal-edit{{$row->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-heart"></i></a>
                      <a href="{{url('admin/user/'.$row->id.'/edit')}}"  class="btn btn-round btn-warning btn-icon btn-sm edit"><i class="far fa-calendar-alt"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i></button>
                      @elseif ( $row->pay == 1 ) 
                      <a href="{{url('admin/user/'.$row->id.'/edit')}}" data-toggle="modal" data-target="#modal-bukti{{$row->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-file"></i></a>
                      @else
                      <a href="{{url('admin/transfer/'.$row->id.'/edit')}}"><button type="button" class="btn btn-danger"><i class="now-ui-icons business_money-coins"></i> Bayar Sekarang</button></a>
                      @endif
                      @endif
                    </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
      @elseif(auth()->user()->id_team == 1)
        <div class="accordion" id="accordionExample-{{$links->id}}">
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h2 class="mb-0">

                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#modal-show{{$links->id}}" aria-expanded="false" aria-controls="collapseTwo">
                  <h6 style="font-size: 18px;">{{$links->name}}</h6>
                  <h6 style="font-size: 18px; float: right;">#{{$links->referal}}</h6>
                </button>
              </h2>
            </div>
            <div id="modal-show{{$links->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample-{{$links->id}}">
              <div class="card-body">
                <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Referal</th>
                      <th>Payment</th>
                      <th>Masa Pemakaian</th>
                      <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Referal</th>
                      <th>Payment</th>
                      <th>Masa Pemakaian</th>
                      <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @php
                    $nomor = 1;
                    @endphp
                    @foreach ($data-> sortbyDesc('dibayar') as $row)
                    @if ($links->referal == $row->referal && $row->agen == 2)
                    <tr>
                     <td>{{$nomor++}}</td>
                     <td>{{$row->name}}</td>
                     <td>
                      @if(auth()->user()->id_team == 1 && $row->id_team == 1)
                      Super
                      @endif
                      {{$row->level}}
                    </td>
                    @if ($row->referal2 == NULL)
                    <td><a href="{{ route('agen.kedua', $row->id)}}" class="btn btn-success"><i class="now-ui-icons business_money-coins"></i> Create Agen Kedua</a></td>
                    @else
                    <td>{{$row->referal2}}</td>

                    @endif
                    @if($row->dibayar >= now() && $row->pay == 2 )
                    <td>Terlunasi</td>
                    <td><button class="btn btn-success"><span class="clock" data-countdown="{{$row->dibayar}}"></span></button></td>
                    @elseif($row->pay ==1)
                    <form action="{{route('transfer.konfirmasi', $row->id)}}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('PATCH')}}
                      <input type="hidden" name="user_id" value="{{$row->id}}">
                      <input type="hidden" name="dibayar" value="{{$row->tgl_bayar}}">
                      <td>Terlunasi</td>
                      <td><button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button></td>
                    </form>
                    @else
                    <td>Belum Terlunasi</td>
                    <td>Telah Berakhir</span></td>
                    @endif
                    <td class="text-right">
                      @if(auth()->user()->level == 'Owner') 
                      @if($row->dibayar >= now() && $row->pay == 2 ) 
                      <form id="data-{{ $row->id }}" action="{{route('user.destroy',$row->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                      </form>
                      <a target="_blank" href="https://wa.me/{{$row->notelp}}"  class="btn btn-round btn-success btn-icon btn-sm edit"><i class="far fa-address-book"></i></a>
                      <a href="{{url('admin/user/'.$row->id.'/edit')}}" data-toggle="modal" data-target="#modal-edit{{$row->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-heart"></i></a>
                      <a href="{{url('admin/user/'.$row->id.'/edit')}}"  class="btn btn-round btn-warning btn-icon btn-sm edit"><i class="far fa-calendar-alt"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="deleteRow( {{ $row->id }} )" class="btn btn-round btn-danger btn-icon btn-sm remove"><i class="fas fa-times"></i></button>
                      @elseif ( $row->pay == 1 ) 
                      <a href="{{url('admin/user/'.$row->id.'/edit')}}" data-toggle="modal" data-target="#modal-bukti{{$row->id}}"  class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-file"></i></a>
                      @else
                      <a href="{{url('admin/transfer/'.$row->id.'/edit')}}"><button type="button" class="btn btn-danger"><i class="now-ui-icons business_money-coins"></i> Bayar Sekarang</button></a>
                      @endif
                      @endif
                    </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
      @endif

      @endif
      @endforeach

    </div>
  </div>
</div>
</div>
@endsection
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
