@extends('Master.master')
@section('title')
Dashboard TB.Wuni
@endsection
@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="row">
  		<div class="col-xs-12">
    		<div class="box">
       			<div class="box-body text-center">
            		<h1>Selamat Datang</h1>
            		<h2>Anda login sebagai KARYAWAN</h2>
            		<br><br>
            		<a class="btn btn-success btn-lg" href="{{ route('barang.index') }}">Cek Stok Barang</a>
            		<br><br><br>
      			</div>
   			</div>
 		 </div>
	</div>
</section>
@stop