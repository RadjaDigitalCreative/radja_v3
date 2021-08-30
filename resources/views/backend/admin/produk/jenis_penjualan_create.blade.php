@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="card ">
        <div class="card-header ">
            <h4 class="card-title">{{$title}}</h4>
        </div>
        <div class="card-body ">
            <form method="post" method="post" action="{{route('item.jenis.penjualan.store')}}" class="form-horizontal">
                @csrf
                <div class="row">
                    <label class="col-md-3 col-form-label">Nama</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" name="jenis_penjualan" class="form-control" required="">
                        </div>
                    </div>
                </div>

        </div>
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
@endsection
