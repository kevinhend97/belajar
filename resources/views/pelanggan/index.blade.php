@extends('Master.master')
@section('title')Pelanggan @endsection
@section('main')

<section class="content-header">
  <h1>
    Data Master
    <small>Lihat Pelanggan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{Route('supplier.index')}}">Data master</a></li>
    <li class="active">Lihat Pelanggan</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i>Tambah</a>
          <a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
          <a href="{{url('pelanggan/view_laporan')}}" class="btn btn-warning"><i class="fa  fa-print"></i>Download</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form method="post" id="form-pelanggan">
            {{ csrf_field() }}
            <table class="table table-bordered table-responsive table-hover">
              <thead>
                <tr>
                  <th><input type="checkbox" value="1" id="select-all"></th>
                  <th>No</th>
                  <th>Kode Pelanggan</th>
                  <th>Nama Pelanggan</th>
                  <th>No Telp.</th>
                  <th>Alamat Pelanggan</th>
                  <th>Kota</th>
                  <th>Provinsi</th>
                  <th>Pilihan</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@include('pelanggan.form')
@endsection
@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
  table = $('.table').DataTable({
    'autoWidth'   : true,
    'ordering'    : true,
    'info'        : true,
    "processing" : true,
    "ajax" : {
      "url" : "{{ route('pelanggan.data') }}",
      "type" : "GET"
    }
  });
  $('#modal-form form').validator().on('submit', function(e){
    if(!e.isDefaultPrevented()){
      var id = $('#id').val();
      if(save_method == "add") url = "{{ route('pelanggan.store') }}";
      else url = "pelanggan/"+id;

      $.ajax({
        url : url,
        type : "POST",
        data : $('#modal-form form').serialize(),
        success : function(data){
          $('#modal-form').modal('hide');
          table.ajax.reload();
          swal({
            title: 'Berhasil!',
            text: 'Data Berhasil di Buat!',
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
});

function addForm(){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form form')[0].reset();   
   $('#id').removeAttr("disabled");
   $('#nama').removeAttr("disabled");
   $('#alamat').removeAttr("disabled");
   $('#noTelp').removeAttr("disabled");
   $('#provinsi').removeAttr("disabled");
   $('#kota').removeAttr("disabled");
   $('#tombol').removeAttr("hidden");         
   $.ajax({
    url : "pelanggan/no",
    type : "GET",
    dataType : "JSON",
     success : function(data){
      $('#modal-form').modal('show');
      $('.modal-title').text('Tambah Pelanggan');
      $('#kode').val(data);
     },
   });
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "pelanggan/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Pelanggan');

       $('#id').val(data.id_pelanggan).removeAttr("disabled");
       $('#kode').val(data.kode_pelanggan).removeAttr("disabled");
       $('#nama').val(data.nama).removeAttr("disabled");
       $('#alamat').val(data.alamat).removeAttr("disabled");
       $('#noTelp').val(data.telp).removeAttr("disabled");
       $('#provinsi').val(data.provinsi_id).removeAttr("disabled");
       $('#kota').val(data.kota_id).removeAttr("disabled");
       $('#tombol').removeAttr("hidden");
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

function showDetail(id){
  $('input[name=_method]').val('PATCH');
  $('#modal-form form')[0].reset();
  $.ajax({
    url : "pelanggan/"+id,

    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#modal-form').modal('show');
      $('.modal-title').text('Lihat Pelanggan');

      $('#id').val(data.id_pelanggan).attr({disabled : "disabled"});
       $('#kode').val(data.kode_pelanggan).attr({disabled : "disabled"});
       $('#nama').val(data.nama).attr({disabled : "disabled"});
       $('#alamat').val(data.alamat).attr({disabled : "disabled"});
       $('#noTelp').val(data.telp).attr({disabled : "disabled"});
       $('#provinsi').val(data.provinsi_id).attr({disabled : "disabled"});
       $('#kota').val(data.kota_id).attr({disabled : "disabled"});
      $('#tombol').attr({hidden : "hidden"});

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


 //centang semua checkbox ketika dicentang dengan id #select-all
  $('#select-all').click(function(){
    $('input[type="checkbox"]').prop('checked',this.checked);
  });

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
      url :"{{ url('pelanggan') }}" + '/' + id,
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

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))

  return false;
  return true;
}

//fungsi pada bagian kota saat memilih provinsi
$('#provinsi').on('change', function(){
  var provinsi_id = $(this).val();

  if(provinsi_id){
    $.ajax({
      url : 'pelanggan/get-kota-list/'+provinsi_id,
      type : "GET",
      dataType : "json",
      success : function (data){
        $('#kota').empty();
        $.each(data, function(key, value){
          $('#kota').append('<option value="'+key+'">'+value+'</option>');
        });
      }
    });
  }
  else
  {
    $('#kota').empty();
  }
});

function deleteAll(){
  if($('input:checked').length < 1){
    swal({
            title: 'Oops...',
            text: 'Pilih data yang akan dihapus!',
            type: 'error',
            timer: '1500'
          })
  }else if(swal({
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
       url : "pelanggan/hapus",
       type : "POST",
       data : $('#form-pelanggan').serialize(),
       success : function(data){
         table.ajax.reload();
         swal({
            title: 'Berhasil!',
            text: 'Data Berhasil di Hapus!',
            type: 'success',
            timer: '1500'
          })
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
  )
  );
}
</script>
@endsection
