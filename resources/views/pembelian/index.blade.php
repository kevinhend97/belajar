@extends('Master.master')
@section('title')Pembelian @endsection
@section('main')

<section class="content-header">
  <h1>
    Barang
    <small>Pembelian</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{Route('pembelian.index')}}">Barang</a></li>
    <li class="active">Pembelian</li>
  </ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				@if(Auth::user()->jabatan == "Pemilik")
				<div class="box-header">
					<a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Transaksi Baru</a>
					@if(!empty(session('idpembelian')))
						<a href="{{ route('detail_pembelian.index') }}" class="btn btn-info"><i class="fa fa-plus-circle"></i> Transaksi Aktif</a>
					@endif
				</div>
				@endif
				<div class="box-body">
					<table class="table table-striped tabel-pembelian">
						<thead>
							<tr>
								<th width="30">No</th>
								<th>Kode Transaksi</th>
								<th>Tanggal</th>
								<th>Supplier</th>
								<th>Total Item</th>
								<th>Total Harga</th>
								<th>Diskon</th>
								<th>Total Bayar</th>
								<th width="100">Pilihan</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@include('pembelian.detail')
@include('pembelian.supplier')
@endsection

@section('script')
<script type="text/javascript">
	var table, save_method, table1;

	$(function(){
		table = $('.tabel-pembelian').DataTable({
			"processing" : true,
			"serverside" : true,
			"ajax" : {
				"url" : "{{ route('pembelian.data') }}",
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

	function addForm()
	{
		$('#modal-supplier').modal('show');
	}

	function showDetail(id){
		$('#modal-detail').modal('show');

		table1.ajax.url("pembelian/"+id+"/lihat");
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
	      url :"pembelian" + "/" + id,
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
