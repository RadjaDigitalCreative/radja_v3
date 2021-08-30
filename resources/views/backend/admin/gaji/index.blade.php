@extends('layout.main')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                    <form class="form-inline float-right" action="{{route('pegawai.gaji.filter')}}" method="POST">
                        @csrf
                        <div class="form-group ">
                            <select name="filter" class="form-control">
                                <option value="1">Januari</option>
                                <option value="2">Febuari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary btn-round"><i class="fa fa-search"></i>&nbsp;Filter
                            </button>
                        </div>
                    </form>
                    @if(auth()->user()->level == 'Owner')
                        <div class="btn-group">
                            <a href="{{route('pegawai.gaji.create')}}">
                                <button type="button" class="btn btn-success"><i
                                        class="now-ui-icons ui-1_simple-add"></i> Buat Gaji Pegawai
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="toolbar">
                    </div>
                    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Total Gaji</th>
                            <th>Total Potongan</th>
                            <th>Total Lembur</th>
                            <th>Total Pelanggaran</th>
                            <th>Gaji Saat Ini</th>
                            <th>Bulan</th>
                            <th>Dibuat</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Total Gaji</th>
                            <th>Total Potongan</th>
                            <th>Total Lembur</th>
                            <th>Total Pelanggaran</th>
                            <th>Gaji Saat Ini</th>
                            <th>Bulan</th>
                            <th>Dibuat</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        function rupiah($m)
                        {
                            $rupiah = "Rp " . number_format($m, 0, ",", ".") . ",-";
                            return $rupiah;
                        }
                        $nomor = 1;
                        ?>

                        @foreach($data as $row)
                            <tr>
                                <td>{{$nomor++}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{rupiah($row->total)}}</td>
                                <td>
                                    <?php foreach ($data2 as $key) {
                                        if ($key->name == $row->name) {
                                            $potongan = $key->total;
                                            echo rupiah($potongan);
                                        }
                                    }?>
                                </td>

                                <td>
                                    <?php foreach ($data3 as $key) {
                                        if ($key->name == $row->name) {
                                            $masuk = $key->total;
                                            if ($key->lembur >= 1) {
                                                echo rupiah($row->gaji_lembur * $key->total_lembur);
                                            } else {
                                                echo "-";
                                            }
                                        }
                                    }?>
                                </td>
                                <td>
                                    <?php foreach ($data3 as $key) {
                                        if ($key->name == $row->name) {
                                            echo rupiah($key->total_telat * $key->telat), $key->total_telat . " x";
                                        }
                                    }?>
                                </td>
                                <td>
                                    <b>
                                        <?php foreach ($data3 as $key) {
                                            if ($key->name == $row->name) {
                                                $masuk = $key->total;
                                                if ($key->lembur >= 1) {
                                                    echo rupiah(((($row->total - $potongan) / $hari) * $masuk) + ($row->gaji_lembur * $key->total_lembur) - ($key->total_telat * $key->telat));
                                                } else {
                                                    echo rupiah(((($row->total - $potongan) / $hari) * $masuk) - ($key->total_telat * $key->telat));
                                                }
                                            }
                                        }?>
                                    </b>
                                </td>
                                <td>
                                    <?php foreach ($data3 as $key) {
                                        if ($key->bulan == now()->month && $key->name == $row->name){
                                            switch ($key->bulan) {
                                                case '1':
                                                    $bulan = 'Januari';
                                                    break;
                                                case '2':
                                                    $bulan = 'Februari';
                                                    break;
                                                case '3':
                                                    $bulan = 'Maret';
                                                    break;
                                                case '4':
                                                    $bulan = 'April';
                                                    break;
                                                case '5':
                                                    $bulan = 'Mei';
                                                    break;
                                                case '6':
                                                    $bulan = 'Juni';
                                                    break;
                                                case '7':
                                                    $bulan = 'Juli';
                                                    break;
                                                case '8':
                                                    $bulan = 'Agustus';
                                                    break;
                                                case '9':
                                                    $bulan = 'September';
                                                    break;
                                                case '10':
                                                    $bulan = 'Oktober';
                                                    break;
                                                case '11':
                                                    $bulan = 'November';
                                                    break;
                                                case '12':
                                                    $bulan = 'Desember';
                                                    break;
                                                default:
                                                    $bulan = 'Bulan Tidak Ada';
                                                    break;
                                            }
                                            echo $bulan;
                                        }
                                    }?>
                                </td>
                                <td>{{$row->created_at}}</td>
                                <td align="center">
                                    <a href="{{  route('pegawai.gaji.edit', $row->id_gaji) }}">
                                        <button type="button" class="btn btn-outline-primary "><i
                                                class="fa fa-edit"></i>&nbsp;Edit
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
