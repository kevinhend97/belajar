@extends('Master.master')
@section('title')Pegawai @endsection
@section('main')

<section class="content-header">
  <h1>
    Data Master
    <small>Penguna</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{Route('profile.index')}}">Data master</a></li>
    <li class="active">Penguna</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i>Tambah</a>
          <a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form method="post" id="form-pegawai">
            {{ csrf_field() }}
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th align="center"><input type="checkbox" value="1" id="select-all"></th>
                  <th align="center">No</th>
                  <th align="center">Nama Pengguna</th>
                  <th align="center">Alamat Pengguna</th>
                  <th align="center">No Telp.</th>
                  <th align="center">Jabatan</th>
                  <th align="center">E-mail</th>
                  <th align="center">Gambar</th>
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

@include('pegawai.form')


@endsection
@section('script')
<script type="text/javascript">
  var table, save_method;
  $(function(){

    table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('user.data') }}",
       "type" : "GET"
     }
   });
  });

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))

  return false;
  return true;
  }

//menampilkan form tambah
  function addForm()
  {
    save_method = "add";
    $('input[name = method]').val('POST');
    $('#modal-form').modal('show');
    $('#modal-form form')[0].reset();
    $('.modal-title').text('Tambah Pengguna');

    $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         
         $.ajax({
           url : "{{ route('profile.store') }}",
           type : "POST",
           data : $('#modal-form form').serialize(),
           dataType : 'JSON',
           success : function(data){
            if(data.msg=="error")
            {
              swal({
                title: 'Maaf ...',
                text: 'Email atau Username sudah pernah digunakan !',
                type: 'error',
                timer: '1500'
              });  
              $('#username').focus().select();
            }
            else
            {
              $('#modal-form').modal('hide');
              table.ajax.reload();
              swal({
                title: 'Success!',
                text: 'Akun Berhasil di Simpan!',
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
  }

  //menampilkan data di edit form
function editForm(id)
{
  save_method = "edit";
  $('input[name=_method]').val('PATCH');
  $('#modal-form2 form')[0].reset();
  $.ajax({
    url : "profile/"+id+"/edit",

    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#modal-form2').modal('show');
      $('.modal-title').text('Edit Pengguna');

      $('#id').val(data.id);
      $('#nama2').val(data.name).removeAttr("disabled");
      $('#alamat2').val(data.alamat).removeAttr("disabled");
      $('#username2').val(data.username).removeAttr("disabled");
      $('#email2').val(data.email).removeAttr("disabled");
      $('#notelp2').val(data.no_telp).removeAttr("disabled");
      $('#jabatan2').val(data.jabatan).removeAttr("disabled");
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



  $('#modal-form2 form').validator().on('submit', function(e){
    if(!e.isDefaultPrevented()){
       var id = $('#id').val();
       $.ajax({
         url : "profile/"+id,
         type : "POST",
         data : $('#modal-form2 form').serialize(),
         dataType : 'JSON',
         success : function(data){
           if(data.msg=="error")
            {
              swal({
                title: 'Maaf ...',
                text: 'Email atau Username sudah pernah digunakan !',
                type: 'error',
                timer: '1500'
              });  
              $('#username').focus().select();
            }
            else
            {
              $('#modal-form').modal('hide');
              table.ajax.reload();
              swal({
                title: 'Success!',
                text: 'Akun Berhasil di Simpan!',
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
}

function showDetail(id){
  $('input[name=_method]').val('PATCH');
  $('#modal-form2 form')[0].reset();
  $.ajax({
    url : "profile/"+id,

    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#modal-form2').modal('show');
      $('.modal-title').text('Lihat Pengguna');

      $('#id').val(data.id);
      $('#nama2').val(data.name).attr({disabled : "disabled"});
      $('#alamat2').val(data.alamat).attr({disabled : "disabled"});
      $('#username2').val(data.username).attr({disabled : "disabled"});
      $('#email2').val(data.email).attr({disabled : "disabled"});
      $('#notelp2').val(data.no_telp).attr({disabled : "disabled"});
      $('#jabatan2').val(data.jabatan).attr({disabled : "disabled"});
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
      url :"{{ url('profile') }}" + '/' + id,
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

//centang semua checkbox ketika dicentang dengan id #select-all
  $('#select-all').click(function(){
    $('input[type="checkbox"]').prop('checked',this.checked);
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
       url : "pegawai/hapus",
       type : "POST",
       data : $('#form-pegawai').serialize(),
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
