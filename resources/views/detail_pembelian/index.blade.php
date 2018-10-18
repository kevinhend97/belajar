@extends('Master.master')
@section('title')Pembelian @endsection
@section('main')

<section class="content-header">
  <h1>
    Barang
    <small>Pembelian</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('pembelian.index') }}">Pembelian</a></li>
    <li class="active">Transaksi Pembelian</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body">
					<table>
						<tr>
							<td width="150">Supplier</td>
							<td><b>{{ $supplier->nama }}</b></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td><b>{{ $supplier->alamat_kantor }}</b></td>
						</tr>
						<tr>
							<td>Telepon</td>
							<td><b>{{ $supplier->no_telp }}</b></td>
						</tr>
					</table>
					<hr>
					<form class="form form-horizontal form-produk" method="post">
						{{ csrf_field() }} 
						<input type="hidden" name="idpembelian" value="{{ $idPembelian }}">
						<div class="form-group">
							<label for="kode" class="col-md-2 control-label">Kode Barang</label>
							<div class="col-md-5">
								<div class="input-group">
									<input type="text" id="kode" class="form-control" name="kode" autofocus="autofocus" required="required">
									<span class="input-group-btn">
										 <a onclick="showProduct()" class="btn btn-info">...</a>
									</span>
								</div>
							</div>
						</div>
					</form>

					<form class="form-keranjang">
						{{ csrf_field() }} {{ method_field('PATCH') }}
						<table class="table table-striped tabel-pembelian">
							<thead>
								<tr>
									<th width="30">No</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th align="right">Harga</th>
									<th>Jumlah</th>
									<th align="right">Sub Total</th>
									<th width="100">Pilihan</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</form>

					<div class="col-md-8">
						<div id="tampil-bayar" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 100px">
						</div>
						<div id="tampil-terbilang" style="background: #3c8dbc; color: #fff; font-weight: bold; padding: 10px">
						</div>
					</div>
					<div class="col-md-4">
						<form class="form form-horizontal form-pembelian" method="post" action="{{ route('pembelian.store') }}">
							{{ csrf_field() }}
							<input type="hidden" name="idpembelian" value="{{ $idPembelian }}">
							
							<input type="hidden" name="total" id="total">
							<input type="hidden" name="totalitem" id="totalitem">
							<input type="hidden" name="bayar" id="bayar">

							<div class="form-group">
								<label for="kodepem" class="col-md-4 control-label">No. Nota</label>
								<div class="col-md-8">
									<input required="required" type="text" name="kodepembelian" class="form-control" id="kodepembelian">
								</div>
							</div>

							<div class="form-group">
								<label for="totalrp" class="col-md-4 control-label">Total</label>
								<div class="col-md-8">
									<input type="text" class="form-control" id="totalrp" readonly="readonly">
								</div>
							</div>

							<div class="form-group">
					        	<label for="diskon" class="col-md-4 control-label">Diskon</label>
					        	<div class="col-md-8">
					          		<input type="number" class="form-control" id="diskon" name="diskon" value="0">
					        	</div>
					      	</div>

							<div class="form-group">
								<label for="bayarrp" class="col-md-4 control-label">Bayar</label>
								<div class="col-md-8">
									<input type="text" class="form-control" id="bayarrp" readonly="readonly">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
				</div>
			</div>
		</div>
	</div>
</section>
@include('detail_pembelian.barang')
@endsection
@section('script')
	<script type="text/javascript">
		var table;
		$(function (){
			$('.tabel-produk').DataTable();

			table = $('.tabel-pembelian').DataTable({
				"dom" : "Brt",
				"bSort" : false,
				"processing" : true,
				"ajax" : {
					"url" : "{{ route('detail_pembelian.data', $idPembelian) }}",
					"type" : "GET"
				}
			}).on('draw.dt', function (){
				loadForm($('#diskon').val());
			});

			//Menghindari submit form saat dienter pada kode barang dan jumlah
			$('.form-produk').on('submit', function (){
				return false;
			});

			$('.form-keranjang').on('submit', function (){
				return false;
			});

			//Proses Ketika kode barang atau diskon diubah
			$('#kode').change(function(){
				addItem();
			});

			$('#diskon').change(function(){
				if ($(this).val() == "") $(this).val(0).select();
				loadForm($(this).val());
			});

			//menyimpan form transaksi saat tombol simpan di klik
			$('.simpan').click(function(){
				$('.form-pembelian').submit();
			});	
		});

		function addItem()
		{
			$.ajax({
				url : "{{ route('detail_pembelian.store') }}",
				type : "POST",
				data : $('.form-produk').serialize(),
				success : function(data){
					$('#kode').val('').focus();
					table.ajax.reload(function(){
						loadForm($('#diskon').val());
					});
				},
				error : function(){
					swal({
		            title: 'Oops...',
		            text: 'Tidak dapat menyimpan data!',
		            type: 'error',
		            timer: '1500'
		          })
				}
			});
		}

		function selectItem(kode)
		{
			$('#kode').val(kode);
			$('.modal-produk').modal('hide');
			addItem();
		}

		function changeCount(id)
		{
			$.ajax({
				url : "detail_pembelian/"+id,
				type : "POST",
				data : $('.form-keranjang').serialize(),
				success : function(data){
					$('#kode').focus();
					table.ajax.reload(function(){
						loadForm($('#diskon').val());
					});
				},
				error : function(){
					swal({
		            title: 'Oops...',
		            text: 'Tidak dapat menyimpan data!',
		            type: 'error',
		            timer: '1500'
		          })
				}
			});
		}

		function showProduct()
		{
			$('#modal-produk').modal('show');
		}

		function deleteItem(id)
		{
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
		      url :"detail_pembelian/"+id,
		      type : "POST",
		      data : {'_method' : 'DELETE', '_token' : csrf_token},
		      success : function(data)
		      {
		        table.ajax.reload(function(){
		        	loadForm($('#diskon').val());
		        });
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

		function loadForm(diskon=0)
		{
			$('#total').val($('.total').text());
			$('#totalitem').val($('.totalitem').text());

			$.ajax({
				url : "detail_pembelian/loadform/"+diskon+"/"+$('.total').text(),
				type : "GET",
				dataType : 'JSON',
				success : function(data){
					$('#totalrp').val('Rp. '+data.totalrp);
					$('#bayarrp').val('Rp. '+data.bayarrp);
					$('#bayar').val(data.bayar);
					$('#tampil-bayar').text("Rp. "+data.bayarrp);
					$('#tampil-terbilang').text(data.terbilang);
				},
				error : function(){
					swal({
		            title: 'Oops...',
		            text: 'Tidak dapat menampilkan data!',
		            type: 'error',
		            timer: '1500'
		          })
				}
			});
		}
	</script>
@endsection