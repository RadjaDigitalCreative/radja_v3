@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="card ">
        <div class="card-header ">
            <h4 class="card-title">{{$title}}</h4>
        </div>
        <div class="card-body ">
            <form method="post" method="post" action="{{route('pegawai.hari.store')}}" class="form-horizontal">
                @csrf
                <div class="row">
                    <label class="col-md-3 col-form-label">Bulan</label>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" id="input-normal" name="input-normal" readonly="" value="{{$bulan}}"
                                   placeholder="Normal" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label">Tahun</label>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" id="input-normal" name="input-normal" readonly="" value="{{$tahun}}"
                                   placeholder="Normal" class="form-control">
                        </div>
                    </div>
                </div>
        </div>
        @foreach ($workdays as $key => $dateval)
            <input type="hidden" name="dateval[]" value="{{$dateval}}">
        @endforeach
        <input type="hidden" name="bulan" value="{{$month}}">

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


@endsection
