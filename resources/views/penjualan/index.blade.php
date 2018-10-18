@extends('Master.master')
@section('title')Manajemen Penjualan @endsection
@section('main')

<section class="content-header">
  <h1>
    Barang
    <small>Penjualan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{Route('penjualan.index')}}">Barang</a></li>
    <li class="active">Manajemen Penjualan</li>
  </ol>
</section>

<section class="content">
	<div class="row">
  		<div class="col-xs-12">
    		<div class="box">
      			<div class="box-body">  

					<table class="table table-striped tabel-penjualan">
						<thead>
   							<tr>
						      <th width="30">No</th>
                  <th>Kode Transaksi</th>
						      <th>Tanggal</th>
						      <th>Kode Pelanggan</th>
						      <th>Total Item</th>
						      <th>Total Harga</th>
						      <th>Diskon</th>
						      <th>Total Bayar</th>
						      <th>Kasir</th>
						      <th width="100">Pilihan</th>
						   	</tr>
						</thead>
						<tbody></tbody>
					</table>
      			</div>
    		</div>
  		</div>
	</div>
</section>
@endsection
@include('penjualan.detail')
@section('script')
<script type="text/javascript">
var table, save_method, table1;
$(function(){
   table = $('.tabel-penjualan').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('penjualan.data') }}",
       "type" : "GET"
     }
   }); 
   
   table1 = $('.tabel-detail').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true
    });

   $('.tabel-supplier').DataTable();
});

function addForm(){
   $('#modal-supplier').modal('show');        
}

function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("penjualan/"+id+"/lihat");
    table1.ajax.reload();
}

function deleteData(id){
  var csrf_token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Yakin hapus data ini ?',
    text: "Kamu tidak dapat mengembalikan data ini!",
    type: 'warning',
    showCancelButton: true,
    cancelButtonColor: '#d33',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus data Tersebut!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url :"penjualan" + "/" + id,
        type : "POST",
        data : {'_method' : 'DELETE', '_token' : csrf_token},
        success : function(data)
        {
          table.ajax.reload();
          swal({
              title: 'Berhasil!',
              text: 'Data Berhasil di Hapus!',
              type: 'success',
              timer: '1500'
            })
        },
        error : function()
        {
          swal({
              title: 'Oops...',
              text: 'Tidak dapat menghapus data!',
              type: 'error',
              timer: '1500'
            })
          }      
        });
      }
    });
  }
</script>
@endsection