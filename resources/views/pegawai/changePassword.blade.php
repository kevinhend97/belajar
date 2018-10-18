@extends('admin.layout')

@section('main')
<header class="page-header">
     <div class="container-fluid">
        <h2 class="no-margin-bottom">{{ Auth::user()->name }}'s Profile</h2>
    </div>
</header>
<ul class="breadcrumb">
    <div class="container-fluid">
        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </div>
</ul>
<section class="form-horizontal">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (session('alert'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert"">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{route('profile.changePass', Auth::user()->id)}}" method="POST">
                           {{csrf_field()}}
                        
                           <div class="line"></div>
                            <div class="form-group row {{ $errors->has('current_password') ? 'has-error' : '' }}">
                                <label class="col-sm-3 form-control-label">Password Lama</label>
                                <div class="col-sm-9">
                                    <input type="password" name="current_password" placeholder="Password Lama" class="form-control">
                                    <span class="text-danger"><strong>{{ $errors->first('current_password') }}</strong></span>
                                </div>
                            </div>

                            <div class="line"></div>
                            <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="col-sm-3 form-control-label">Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" placeholder="Password Baru" class="form-control">
                                    <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                                </div>
                            </div>

                            <div class="line"></div>
                            <div class="form-group row {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                <label class="col-sm-3 form-control-label">Konfirmasi Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" name="confirm_password" placeholder="Konfirmasi password Baru" class="form-control">
                                </div>
                            </div>

                        
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="line"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{url('/admin')}}" class="btn btn-danger">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection