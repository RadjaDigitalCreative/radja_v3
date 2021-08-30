@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="card ">
        <div class="card-header ">
            <h4 class="card-title">{{$title}}</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Hari Biasa</h5>

            <form action="{{route('pegawai.jam.store')}}" method="post" class="form-horizontal">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-9">
                        <div id="app">
                            <div class="row" v-for="(order, index) in orders" :key="index">
                                <label class="col-md-2 col-form-label"><b>Jam Masuk Kerja</b></label>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input placeholder="jam masuk awal" type="time" name="jam_masuk"
                                               class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <label class="col-md-2 col-form-label"><b>Keterangan Jam Kerja</b></label>
                        <label class="col-md-2 col-form-label">00.00 - 12.00 = AM</label>
                        <label class="col-md-2 col-form-label">12.00 - 24.00 = PM</label>
                    </div>
                </div>
                <br><br>
                <hr>
                <div class="row">
                    <div class="col-md-9">
                        <div id="app">
                            <div class="row" v-for="(order, index) in orders" :key="index">
                                <label class="col-md-2 col-form-label"><b>Jam Keluar Kerja</b></label>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input placeholder="jam keluar awal" type="time" name="jam_keluar"
                                               class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <hr>
                <div class="row">
                    <div class="col-md-9">
                        <div id="app">
                            <div class="row" v-for="(order, index) in orders" :key="index">
                                <label class="col-md-2 col-form-label"><b>Potogan Telat</b></label>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input placeholder="Potogan gaji harian jika telat" type="number" name="telat"
                                               class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <hr>
                <h5 class="card-title">Hari Tertentu (Sabtu)</h5>
                <div class="row">
                    <div class="col-md-9">
                        <div id="app">
                            <div class="row" v-for="(order, index) in orders" :key="index">
                                <label class="col-md-2 col-form-label"><b>Jam Masuk Kerja</b></label>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input placeholder="jam masuk awal" type="time"
                                               class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div id="app">
                            <div class="row" v-for="(order, index) in orders" :key="index">
                                <label class="col-md-2 col-form-label"><b>Jam Keluar Kerja</b></label>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input placeholder="jam keluar awal" type="time" name="jam_keluar2"
                                               class="form-control" required="">
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
                            <a href="{{route('pegawai.jam.edit', auth()->user()->id_team)}}">
                                <button type="button" class="btn btn-fill btn-primary">Edit</button>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
