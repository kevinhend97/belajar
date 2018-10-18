@extends('admin.layout')
@section('main')
<header>
	<div class="page-header">
        <h2 class="no-margin-bottom">Data Master</h2>
    </div>
</header>
<ul class="breadcrumb">
    <div class="container-fluid">
        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{route('kategori.index')}}">Kategori</a></li>
        <li class="breadcrumb-item active">Ubah Kategori</li>
    </div>
</ul>

<section class="forms">
	<div class="row">
	<div class="col-lg-12">
         @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                </ul>
            </div>
        @endif
		<div class="card">
			<div class="card-header d-flex align-items-center">
                <h3 class="h4">Inline Form</h3>
            </div>
            <div class="card-body">
            	<form class="form-inline" action="{{route('kategori.update', $kategori->id_kategori)}}" method="POST">
                    {{ csrf_field() }} {{method_field('PATCH')}}


                 	<div class="form-group">
                    	<label for="inlineFormInput" class="sr-only">Nama Kategori</label>
                    	<div class="col-lg-9">
                    		<input id="inlineFormInput" type="text" name="nama_kategori" autofocus="autofocus" placeholder="Ex. Besi" class="form-control" maxlength="100" value="{{ $kategori->nama_kategori }}">	
                    	</div>
                    	
                	</div>
                 	<div class="form-group">
                        <input type="submit" value="Simpan" class="mx-sm-3 btn btn-primary">
                        <a href="{{route('kategori.index')}}" class="btn btn-danger">Batal</a>
                    </div>
                 </form>
            </div>
		</div>
	</div>	
	</div>
	
</section>
@stop