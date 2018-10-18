@extends('Master.master')
@section('title')Kota @endsection  
@section('main')

<section class="content-header">
  <h1>
    Data Master
    <small>Tabel Kota</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('home')}}">Data Master</a></li>
    <li class="active">Kota</li>
  </ol>
</section>

<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
              <a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form method="post" id="form-kota">
              {{ csrf_field() }}
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th align="center"><input type="checkbox" value="1" id="select-all"></th>
                    <th align="center">No</th>
                    <th align="center">Nama Provinsi</th>
                    <th align="center">Nama Kota</th>
                    <th align="center">Aksi</th>
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

@include('kota.form')
</section>

@include('provinsi.formProvinsi')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
  //menampilkan data
  table = $('.table').DataTable({
    "processing" : true,
    "serverside" : true,
    "ajax" : {
      "url" : "{{route('kota.data')}}",
      "type" : "GET"
    },
    'columnDefs' : [{
      'targets' : 0,
      'searchable' : false,
      'orderable' :false
    }],
    'order' : [1, 'asc']
  });

  //centang semua checkbox ketika dicentang dengan id #select-all
  $('#select-all').click(function(){
    $('input[type="checkbox"]').prop('checked',this.checked);
  });

  //menyimpan data dari form tambah/edit
  $('#modal-form form').validator().on('submit', function(e){
    if(!e.isDefaultPrevented()){
      var id = $('#id').val();
      if(save_method == "add") url = "{{ route('kota.store') }}";
      else url = "kota/"+id;
         
      $.ajax({
        url : url,
        type : "POST",
        data : $('#modal-form form').serialize(),
        dataType: 'JSON',
        success : function(data){
          if(data.msg == "error"){
            swal({
            title: 'Gagal!',
            text: 'Nama Kota sudah Ada!',
            type: 'error',
            timer: '1500'
          })
            $('#nama_kota').focus().select();
          }else{
            $('#modal-form').modal('hide');
            table.ajax.reload();
            swal({
            title: 'Berhasil!',
            text: 'Data Berhasil di Tambahkan!',
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
  $('input[name = method]').val('POST');
  $('#modal-form').modal('show');
  $('#modal-form form')[0].reset();
  $('.modal-title').text('Tambah Kota');
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "kota/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Kota');
       
       $('#id').val(data.id_kota);
       $('#nama_kota').val(data.nama_kota);
       $('#provinsi').val(data.provinsi_id);
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
      url :"{{ url('kota') }}" + '/' + id,
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
       url : "kota/hapus",
       type : "POST",
       data : $('#form-kota').serialize(),
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
