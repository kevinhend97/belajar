@extends('Master.master')
@section('title')Selesai Transaksi @endsection
@section('main')

<section class="content-header">
  <h1>
    Transaksi
    <small>Selesai</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
    <li class="active">Selesai</li>
  </ol>
</section>
<section class="content">
  <div class="row">
  <div class="col-xs-12">
    <div class="box">
       <div class="box-body">
          <div class="alert alert-success alert-dismissible">
            <i class="icon fa fa-check"></i>
            Data Transaksi telah disimpan.
          </div>

          <br><br>
          
            <!-- <a class="btn btn-warning btn-lg" href="{{ route('transaksi.cetak') }}">Cetak Ulang Nota</a> -->
          
            <a class="btn btn-warning btn-lg" onclick="tampilNota()">Cetak Nota Pdf</a>
            <script type="text/javascript">
              tampilNota();
              function tampilNota(){
                window.open("{{ route('transaksi.pdf') }}", "Nota PDF", "height=650,width=1024,left=150,scrollbars=yes");
              }              
            </script>
          
          <a class="btn btn-primary btn-lg" href="{{ route('transaksi.new') }}">Transaksi Baru</a>
          <br><br><br><br>
      </div>
   </div>
  </div>
</div>
</section>
@stop