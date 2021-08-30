
@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-user">
            <div class="image">
                <img src="{{asset('10493.jpg')}}" alt="...">
            </div>
            <div class="card-body">
                <div class="author">
                   <a href="#">
                       @if(auth()->user()->image == NULL)
                       <img class="avatar border-gray" src="{{asset('/images/radja.png')}}" alt="...">
                       @else
                       <img class="avatar border-gray" src="{{ URL::to('/') }}/images/{{ auth()->user()->image }}" alt="...">
                       @endif
                       <h5 class="title">{{auth()->user()->name}}</h5>
                   </a>
                   <p class="description">
                    {{auth()->user()->lokasi}}
                </p>
            </div>
            <p class="description text-center">
                {{auth()->user()->email}} <br>
                {{auth()->user()->notelp}} <br><br>
                <b>{{auth()->user()->level}}</b>
            </p>
        </div>
        <hr>
        <div id="googleMap" style="width:100%;height:380px;"></div>
        <div class="button-container">
            <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-facebook-f"></i>
            </button>
            <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-twitter"></i>
            </button>
            <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-google-plus-g"></i>
            </button>

        </div>
    </div>
</div>

</div>

@endsection
@section('script')
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>

    function initialize() {
        var propertiPeta = {
            center:new google.maps.LatLng(-7.5375824,110.8195408),
            zoom:9,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection
