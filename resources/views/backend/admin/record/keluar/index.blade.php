@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
                @if(auth()->user()->level == 'Owner') 
                <div  class="btn-group">
                  <a href="{{route('cabang.create')}}"><button type="button" class="btn btn-success"><i class="now-ui-icons ui-1_simple-add"></i> Tambah</button></a>

              </div>
              @endif

          </div>
          <div class="card-body">
            <div class="toolbar">
            </div>
            

        </div>
    </div>
</div>
</div>
@endsection
