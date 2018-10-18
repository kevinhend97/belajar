@extends('Master.master')

@section('title')
@if ($data->id == Auth::user()->id) 
{{$data->username}} 
@else
ERROR !!!
@endif
@endsection

@section('main')
<section class="content-header">
  <h1>
    Data Master
    <small>Profile</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('profile.index')}}"></a>Pegawai</li>
    <li class="active">{{$data->username}}</li>
  </ol>
</section>
<section class="content">
  <div class="row">

    <div class="col-md-12">
       @if (session('alert'))
         <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Notification</h4>
            {{session('alert')}}
          </div>
        @endif
      <div class="box box-primary">
        @if ($data->id == Auth::user()->id)
        <div class="box-header with-border">
          <h3 class="box-title">Ubah Profile</h3>
        </div>
            <!-- /.box-header -->
            <!-- form start -->
            
        <form role="form" enctype="multipart/form-data" action="{{route('profile.update_data', Auth::user()->id)}}" method="POST">
              {{csrf_field()}}
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" value="{{ $data->name }}" name="name" placeholder="Name" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Username</label>
              <input type="text" value="{{ $data->username }}" name="username" placeholder="Username" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('username') }}</strong></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">E-mail</label>
              <input type="text" value="{{ $data->email }}" name="email" placeholder="E-mail" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">No. Telp</label>
              <input type="text" value="{{ $data->no_telp }}" onkeypress="return hanyaAngka(event)" name="no_telp" placeholder="no.Telp" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('no_telp') }}</strong></span>
            </div>
            <hr>
            <div class="form-group">
              <label for="exampleInputEmail1">Password Lama</label>
              <input type="password" name="current_password" placeholder="Password Lama" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('current_password') }}</strong></span>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Password Baru</label>
               <input type="password" name="password" placeholder="Password Baru" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Konfirmasi Password</label>
              <input type="password" name="confirm_password" placeholder="Konfirmasi password Baru" class="form-control">
              <span class="text-danger"><strong>{{ $errors->first('confirm_password ') }}</strong></span>
            </div>
            <hr>
            <div class="form-group">
              <label for="exampleInputFile">File input</label>
              <input type="file" id="exampleInputFile" name="avatar">
              <p class="help-block">Masukan Gambar atau Foto disini</p>
            </div>
          </div>
          <!-- /.box-body -->
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
      @else
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Warning !!!</h4>
            Maaf, anda hanya bisa mengakses Data Tersebut !
        </div>
      @endif
      <!-- /.box primary -->
    </div>
  </div>
</section>
@endsection

@section('script')
<script type="text/javascript">
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
 
    return false;
    return true;
  }
</script>
@endsection