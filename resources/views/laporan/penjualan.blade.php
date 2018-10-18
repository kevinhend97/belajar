@extends('Master.master')
@section('title')Laporan Penjualan @endsection
@section('main')

<section class="content-header">
  <h1>
    Laporan {{$judul}} periode {{tanggal_indonesia($awal, false)}} s/d {{tanggal_indonesia($akhir, false)}}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Laporan</li>
    <li class="active">Laporan Penjualan</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a onclick="periodeForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Ubah Periode</a>
              <!-- <a href=" laporan/pdf/{{--$awal--}}/{{--$akhir--}} " target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export PDF</a> -->
        </div>
        <div class="box-body">
          <table class="table table-striped tabel-laporan">
            <thead>
              <tr>
                  <th width="30">No</th>
                  <th>Tanggal Penjualan</th>
                  <th>Total Item</th>
                  <th>Total Belanja</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include('laporan.form')
</section>
@endsection
@section('script')
<script type="text/javascript">
  $(function(){
    var table, awal, akhir;
    //Date picker
      $('#awal, #akhir').datepicker({
          format : 'yyyy-mm-dd',
          autoclose: true
      });

      table = $('.tabel-laporan').DataTable({
        "dom" : 'Brt',
        "bSort" : false,
        "bPaginate" : false,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          "url" : "{{$judul}}/data/{{$awal}}/{{$akhir}}",
          "type" : "GET"
        }
      }); 
  });
  function periodeForm(){
    $('#modal-form').modal('show');
    $('#jenis').val('Penjualan');
    $('#formnya').attr({Action : "{{ route('laporan.refresh', $jenis = 'Penjualan') }}"});
  }
</script>
@endsection