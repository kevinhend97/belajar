@extends('Master.master')
@section('title')Supplier @endsection
@section('main')

<section class="content-header">
  <h1>
    Data Master
    <small>Lihat Supplier</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{Route('supplier.index')}}">Data master</a></li>
    <li class="active">Lihat Supplier</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i>Tambah</a>
          <a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
          <a href="{{url('supplier/view_laporan')}}" class="btn btn-warning"><i class="fa  fa-print"></i>Download</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form method="post" id="form-supplier">
            {{ csrf_field() }}
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th align="center"><input type="checkbox" value="1" id="select-all"></th>
                  <th align="center">No</th>
                  <th align="center">Nama Supplier</th>
                  <th align="center">No Telp.</th>
                  <th align="center">Alamat Kantor</th>
                  <th align="center">Provinsi</th>
                  <th align="center">Kota</th>
                  <th align="center">Pilihan</th>
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

@include('supplier.form')
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
      "url" : "{{ route('supplier.data') }}",
      "type" : "GET"
    }
  });
  $('#modal-form form').validator().on('submit', function(e){
    if(!e.isDefaultPrevented()){
      var id = $('#id').val();
      if(save_method == "add") url = "{{ route('supplier.store') }}";
      else url = "supplier/"+id;

      $.ajax({
        url : url,
        type : "POST",
        data : $('#modal-form form').serialize(),
        dataType : 'JSON',
        success : function(data){
          if(data.msg=="error")
            {
              swal({
                title: 'Maaf ...',
                text: 'Nama Perusahaan sudah pernah Terdaftar !',
                type: 'error',
                timer: '1500'
              });  
              $('#nama').focus().select();
            }
            else
            {
              $('#modal-form').modal('hide');
              table.ajax.reload();
              swal({
                title: 'Success!',
                text: 'Data Berhasil di Simpan!',
                type: 'success',
                timer: '1500'
              })
            }
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
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();
   $('.modal-title').text('Tambah Supplier');


    $('#id').removeAttr("disabled");
    $('#nama').removeAttr("disabled");
    $('#alamat').removeAttr("disabled");
    $('#noTelp').removeAttr("disabled");
    $('#provinsi').removeAttr("disabled");
    $('#kota').removeAttr("disabled");
    $('#tombol').removeAttr("hidden");
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "supplier/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Supplier');

       $('#id').val(data.id_supplier).removeAttr("disabled");
       $('#nama').val(data.nama).removeAttr("disabled");
       $('#alamat').val(data.alamat_kantor).removeAttr("disabled");
       $('#noTelp').val(data.no_telp).removeAttr("disabled");
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
      url :"{{ url('supplier') }}" + '/' + id,
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
      url : 'supplier/get-kota-list/'+provinsi_id,
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

function showDetail(id){
  $('input[name=_method]').val('PATCH');
  $('#modal-form form')[0].reset();
  $.ajax({
    url : "supplier/"+id,

    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#modal-form').modal('show');
      $('.modal-title').text('Lihat Supplier');

      $('#id').val(data.id_supplier).attr({disabled : "disabled"});
       $('#nama').val(data.nama).attr({disabled : "disabled"});
       $('#alamat').val(data.alamat_kantor).attr({disabled : "disabled"});
       $('#noTelp').val(data.no_telp).attr({disabled : "disabled"});
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
       url : "supplier/hapus",
       type : "POST",
       data : $('#form-supplier').serialize(),
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
