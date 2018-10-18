@extends('Master.master')
@section('title')Piutang @endsection  
@section('main')
<section class="content-header">
  <h1>
    Data Master
    <small>Piutang</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('home')}}">Barang</a></li>
    <li class="active">Piutang</li>
  </ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="example2" class="table tabel-piutang table-hover">
                <thead>
                  <tr>
                    <th width="30">No</th>
                  	<th>Kode Transaksi</th>
          					<th>Tgl. Jatuh Tempo</th>
          					<th>Kode Pelanggan</th>
          					<th>Total Item</th>
          					<th>Total Harga</th>
          					<th>Piutang</th>
          					<th>Diterima</th>
          					<th>Kasir</th>
          					<th width="100">Pilihan</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@include('piutang.form')
@include('piutang.detail')
</section>
@stop

@section('script')
<script type="text/javascript">
	var table, save_method, table1;
  	$(function(){

    	table = $('.tabel-piutang').DataTable({
     		"processing" : true,
        "serverside" : true,
     		"ajax" : {
       		"url" : "{{ route('piutang.data') }}",
       		"type" : "GET"
    		}
   		});

   		table1 = $('.tabel-detail').DataTable({
     		"dom" : 'Brt',
     		"bSort" : false,
     		"processing" : true
    	});
  	});

function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("piutang/"+id+"/lihat");
    table1.ajax.reload();
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "piutang/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Pembayaran Piutang');
       
       $('#id').val(data.id_penjualan);
       $('#noNota').val(data.kode_penjualan);
       $('#kodepel').val(data.kode_pelanggan);
       $('#totpem').val(data.bayar);
       $('#piutang').val(data.piutang);
       
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

   $('#modal-form form').validator().on('submit', function(e){
    if(!e.isDefaultPrevented()){
       var id = $('#id').val();
       $.ajax({
         url : "piutang/"+id,
         type : "POST",
         data : $('#modal-form form').serialize(),
         success : function(data){
           $('#modal-form').modal('hide');
           table.ajax.reload();
           swal({
            title: 'Berhasil!',
            text: 'Transaksi Berhasil !',
            type: 'success',
            timer: '1500'
          })
         },
         error : function(){
           swal({
              title: 'Oops...',
              text: 'Ada yang Error!',
              type: 'error',
              timer: '1500'
            })
         }
       });
       return false;
   }
 });
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
        url :"piutang" + "/" + id,
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
@stop