@extends('layout.verify')
@section('content')
<?php 
$title = 'Verifikasi Email';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">{{$title}}</h5>
                <h4 class="card-title">{{$title}}</h4>
                <div class="dropdown">

                </div>
            </div>
            <div class="card-body">
                @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif

               Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi. Jika Anda tidak menerima email,
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                   

                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="now-ui-icons arrows-1_refresh-69"></i>  <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Klik di sini untuk meminta request yang lain</button>.
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
