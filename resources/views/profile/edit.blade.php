
@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Edit Profile</h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('profile.edit.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 pr-1">
                            <div class="form-group">
                                <label>Cabang Toko</label>
                                <input type="hidden" name="id" value="{{auth()->user()->id}}"> 
                                <input type="text" name="lokasi" class="form-control" disabled=""  placeholder="Company" value="{{auth()->user()->lokasi}}">
                            </div>
                        </div>
                        <div class="col-md-7 pl-1">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{auth()->user()->name}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email" value="{{auth()->user()->email}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" readonly="" class="form-control" placeholder="Password" value="{{auth()->user()->password}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Password Baru" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <textarea rows="4" cols="80" name="notelp" class="form-control" placeholder="Nomor Telepon" value="{{auth()->user()->notelp}}">{{auth()->user()->notelp}}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-user">
            <div class="image">
                <form>
                    <img src="http://www.prima-infodata.com/admin/ck/userfiles/images/TB/DSC04922.jpg" alt="...">
                </form>
            </div>
            <div class="card-body">
                <div class="author">

                    <form action="{{ route('profile.image.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(auth()->user()->image == NULL)
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                                <img class="avatar border-gray" src="{{asset('/images/radja.png')}}" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <br><br>
                            <div class="text-center">
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new"></span>
                                    <input type="hidden" name="id" value="{{auth()->user()->id}}"> 
                                    <input type="file" name="image" required="" />
                                    <button type="submit" class="">Ganti</button>
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                                <img class="avatar border-gray" src="{{ URL::to('/') }}/images/{{ auth()->user()->image }}" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <br><br>
                            <div class="text-center">
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new"></span>
                                    <input type="hidden" name="id" value="{{auth()->user()->id}}"> 
                                    <input type="file" name="image" required="" />
                                    <button type="submit" class="">Ganti</button>
                                </span>
                            </div>
                        </div>
                        @endif
                    </form>
                    <a href="#">
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
            <div class="button-container">
                <a target="_blank" href="http://radjadigitalcreative.com/">
                    <p class="title">Powered By Radja Digital Creative</p>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
