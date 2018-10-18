@extends('Master.master')
@section('title')Transaksi Penjualan @endsection
@section('main')

<section class="content-header">
  <h1>
    Transaksi
    <small>Penjualan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
    <li class="active">Transaksi Penjualan</li>
  </ol>
</section>
<section class="content">
	<div class="row">
	  <div class="col-xs-12">
	    <div class="box">
	   
	    	<div class="box-body">

				<form class="form form-horizontal form-produk" method="post">
					{{ csrf_field() }}  
	  				<input type="hidden" name="idpenjualan" id="idPenjualan" value="{{ $idpenjualan }}">
	  				<div class="form-group">
	      				<label for="kode" class="col-md-2 control-label">Kode Produk</label>
	      				<div class="col-md-5">
	        				<div class="input-group">
	          					<input id="kode" type="text" class="form-control" name="kode" autofocus required>
	          					<span class="input-group-btn">
	            					<button onclick="showProduct()" type="button" class="btn btn-info">...</button>
	          					</span>
	        				</div>
	      				</div>
	  				</div>
				</form>
				<form class="form-keranjang">
					{{ csrf_field() }} {{ method_field('PATCH') }}
					<table class="table table-striped tabel-penjualan">
						<thead>
	   						<tr>
						      <th width="30">No</th>
						      <th>Kode Barang</th>
						      <th>Nama Barang</th>
						      <th align="right">Harga</th>
						      <th>Jumlah</th>
						      <th align="right">Sub Total</th>
						      <th width="100">Aksi</th>
						   	</tr>
						</thead>
						<tbody></tbody>
					</table>
				</form>

	  			<div class="col-md-8">
	     			<div id="tampil-bayar" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 120px"></div>
	     				<div id="tampil-terbilang" style="background: #3c8dbc; color: #fff; font-size: 25px; padding: 10px"></div>
	  					</div>
	  					<div class="col-md-4">
	    					<form class="form form-horizontal form-penjualan" method="post" action="transaksi/simpan">
	      						{{ csrf_field() }}
						      <input type="hidden" name="idpenjualan" value="{{ $idpenjualan }}">
						      <input type="hidden" name="total" id="total">
						      <input type="hidden" name="totalitem" id="totalitem">
						      <input type="hidden" name="bayar" id="bayar">

	      						<div class="form-group">
	        						<label for="Status" class="col-md-4 control-label">Status</label>
	        						<div class="col-md-8">
	          							<select required="required" name="status" id="status" class="form-control">
	          								<option>--- Status ---</option>
	          								<option value="Lunas">Lunas</option>
	          								<option value="Kredit">Kredit</option>
	          							</select>
	        						</div>
	      						</div>

	      						<div class="form-group">
	        						<label for="totalrp" class="col-md-4 control-label">Total</label>
	        						<div class="col-md-8">
	          							<input type="text" class="form-control" id="totalrp" readonly>
	        						</div>
	      						</div>

	      						<div class="form-group">
	        						<label for="member" class="col-md-4 control-label">Kode Pelanggan</label>
	        						<div class="col-md-8">
	          							
	            							<select required="required" name="member" class="form-control select2" style="width: 100%;">
	  											<option value="{{ $unknown->kode_pelanggan }}">{{ $unknown->nama }}</option>
	            								@foreach($pelanggan as $data)
	            									<option value="{{ $data->kode_pelanggan }}">{{ $data->kode_pelanggan }} - {{ $data->nama }}</option>
	            								@endforeach
							                </select>	
	        						</div>
	      						</div>

							    <div class="form-group">
							      <label for="diskon" class="col-md-4 control-label">Diskon</label>
							      <div class="col-md-8">
							        <input type="number" class="form-control" name="diskon" id="diskon" value="0">
							      </div>
							    </div>

							    <div class="form-group">
							      <label for="bayarrp" class="col-md-4 control-label">Bayar</label>
							      <div class="col-md-8">
							        <input type="text" class="form-control" id="bayarrp" readonly>
							      </div>
							    </div>

							    <div class="form-group">
							      <label for="diterima" class="col-md-4 control-label">Diterima</label>
							      <div class="col-md-8">
							        <input type="number" class="form-control" value="0" name="diterima" id="diterima">
							      </div>
							    </div>

							    <div class="form-group">
							      <label for="kembali" class="col-md-4 control-label">Kembali</label>
							      <div class="col-md-8">
							        <input type="text" name="kembali" class="form-control" id="kembali" value="0" readonly>
							      </div>
							    </div>

							    <div class="form-group">
							      <label for="kembali" class="col-md-4 control-label">Tgl. Pembelian</label>
							      <div class="col-md-8">
							        <div class="input-group">
							        	<div class="input-group-addon">
							        		<i class="fa fa-calendar"></i>
							        	</div>
							        	<input type="text" value="{{ $tgl }}" class="form-control" disabled="disabled">
							        </div>
							      </div>
							    </div>

							    <div class="form-group">
							      <label for="kembali" class="col-md-4 control-label">Tgl. Jatuh Tempo</label>
							      <div class="col-md-8">
							      	<div class="input-group date">
                  					<div class="input-group-addon">
                    					<i class="fa fa-calendar"></i>
                  					</div>
                  						<input type="date" disabled="disabled" min="{{ $tgl }}" class="form-control pull-right" id="tanggal" name="tanggal">
					              	</div>
					                <!-- /.input group -->  
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
	@include('detail_penjualan.barang')
	@include('detail_penjualan.pelanggan')
</section>
@endsection
@section('script')
<script type="text/javascript">
var table;
$(function(){
	var tanggal = new Date($.now());
	$('#tanggal').val(tanggal);
	//Initialize Select2 Elements
    $('.select2').select2()
    //Date picker
    // $('#datepicker').datepicker({
    //   autoclose: true
    // })
  $('.tabel-produk').DataTable();

  table = $('.tabel-penjualan').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('transaksi.data', $idpenjualan) }}",
       "type" : "GET"
     }
  }).on('draw.dt', function(){
    loadForm($('#diskon').val());
  });

  

   $('.form-produk').on('submit', function(){
      return false;
   });

   $('body').addClass('sidebar-collapse');

   $('#kode').change(function(){
      addItem();
   });

   $('.form-keranjang').submit(function(){
     return false;
   });

   $('#member').change(function(){
      selectMember($(this).val());
   });

   $('#diterima').change(function(){
      if($(this).val() == "") $(this).val(0).select();
      loadForm($('#diskon').val(), $(this).val());
   }).focus(function(){
      $(this).select();
   });

   $('#status').change(function(){
   		if($(this).val() == "Kredit")
   		{
   			$('#tanggal').removeAttr("disabled").attr({required : "required"});
   		}
   		else
   		{
   			$('#tanggal').attr({disabled : "disabled"});	
   		}
   });

   $('.simpan').click(function(){
      $('.form-penjualan').submit();
   });

   $('#diskon').change(function(){
	if ($(this).val() == "") $(this).val(0).select();
	loadForm($(this).val());
	});

});

function addItem(){
  $.ajax({
    url : "{{ route('transaksi.store') }}",
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

function showProduct(){
  $('#modal-produk').modal('show');
}

function showMember(){
  $('#modal-member').modal('show');
}

function selectItem(kode){
  $('#kode').val(kode);
  $('#modal-produk').modal('hide');
  addItem();
}

function changeCount(id){
     $.ajax({
        url : "transaksi/"+id,
        type : "POST",
        data : $('.form-keranjang').serialize(),
        dataType : 'JSON',
        success : function(data){
        	if (data.msg == "error") {
        		swal({
                title: 'Maaf Stok Tersebut tidak Tersedia',
                text: 'Silahkan Cek stok Barang atau Lakukan Pembelian lagi !',
                type: 'error',
                timer: '1500'
              });
        		$('#jml').val('1');
        		$('#jml').focus().select();
        	}
        	else{
        		$('#kode').focus();
	          table.ajax.reload(function(){
	            loadForm($('#diskon').val());
	          });		
        	}
                       
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

function selectMember(kode){
  $('#modal-member').modal('hide');
  $('#member').val(kode);
}

function deleteItem(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "transaksi/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload(function(){
            loadForm($('#diskon').val());
          }); 
       },
       error : function(){
         swal({
		        title: 'Oops...',
		       	text: 'Tidak dapat menghapus data!',
		       	type: 'error',
		       	timer: '1500'
		    })
       }
     });
   }
}

function loadForm(diskon=0, diterima=0){
  $('#total').val($('.total').text());
  $('#totalitem').val($('.totalitem').text());

  $.ajax({
       url : "transaksi/loadform/"+diskon+"/"+$('#total').val()+"/"+diterima,
       type : "GET",
       dataType : 'JSON',
       success : function(data){
         $('#totalrp').val("Rp. "+data.totalrp);
         $('#bayarrp').val("Rp. "+data.bayarrp);
         $('#bayar').val(data.bayar);
         $('#tampil-bayar').html("<small>Bayar:</small> Rp. "+data.bayarrp);
         $('#tampil-terbilang').text(data.terbilang);
        
         $('#kembali').val("Rp. "+data.kembalirp);
         if($('#diterima').val() != 0){
            $('#tampil-bayar').html("<small>Kembali:</small> Rp. "+data.kembalirp);
            $('#tampil-terbilang').text(data.kembaliterbilang);
         }
       },
       error : function(){
         swal({
		        title: 'Oops...',
		       	text: 'Tidak dapat menghapus data!',
		       	type: 'error',
		       	timer: '1500'
		    })
       }
  });
}

//membuat alert penghapusan saat keluar halaman
$(window).unload(function(){
	var idPenjualan = $('#idPenjualan').val();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Yakin keluar dari halaman ini ?',
    text: "Jika 'iya' terimaksih Telah Menggunakan :) ",
    type: 'warning',
    showCancelButton: true,
    cancelButtonColor: '#d33',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Keluar dari Halaman ini !'
  }).then((result) => {
    if (result.value) {
      $.ajax({
      url :"penjualan" + '/' + idPenjualan,
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
});
</script>

@endsection
