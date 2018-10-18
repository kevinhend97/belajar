@extends('Master.master')
@section('title')Daftar Barang @endsection
@section('main')

<section class="content-header">
  <h1>
    Barang
    <small>Daftar Barang</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{Route('barang.index')}}">Barang</a></li>
    <li class="active">Daftar Barang</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        @if(Auth::user()->jabatan == "Pemilik")
        <div class="box-header">
          <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i>Tambah</a>
          <a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
          <a href="{{url('barang/view_laporan')}}" class="btn btn-warning"><i class="fa  fa-print"></i>Download</a>
        </div>
        <!-- /.box-header -->
        @endif
        <div class="box-body">
          <form method="post" id="form-barang">
            {{ csrf_field() }}
            <table class="table table-hover table-responsive">
              <thead>
                <tr>
                   @if(Auth::user()->jabatan == "Pemilik")
                  <th align="center"><input type="checkbox" value="1" id="select-all"></th>
                  @endif
                  <th align="center">No</th>
                  <th align="center">Kode Barang</th>
                  <th align="center">Nama Barang</th>
                  <th align="center">Kategori</th>
                  <th align="center">Merk</th>
                  <th align="center">Jumlah</th>
                  <th align="center">Satuan</th>
                  <th align="center">Harga Beli</th>
                  <th align="center">Harga Jual</th>
                  @if(Auth::user()->jabatan == "Pemilik")
                  <th align="center">Pilihan</th>
                  @endif
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

@include('barang.form')
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
    "serverside"  : true,
    "ajax" : {
      "url" : "{{ route('barang.data') }}",
      "type" : "GET"
    },
    'columnDefs' : [{
      'targets' : 0,
      'searchable' :false,
      'orderable' : false
    }],
    'order' : [1, 'asc']
  });

  $('#modal-form form').validator().on('submit', function(e){
    if(!e.isDefaultPrevented()){
      var id = $('#id').val();
      if(save_method == "add") url = "{{ route('barang.store') }}";
      else url = "barang/"+id;

      $.ajax({
        url : url,
        type : "POST",
        data : $('#modal-form form').serialize(),
        dataType : 'JSON',
        success : function(data){
          if (data.msg=="error") {
             swal({
              title: 'Nama Barang Sudah Terdaftar...',
              text: 'Periksa kembali Nama Barang !',
              type: 'error',
              timer: '1500'
            })
            $('#nama_barang').focus().select();
          }else{
            $('#modal-form').modal('hide');
            table.ajax.reload();
            swal({
              title: 'Berhasil!',
              text: 'Data Berhasil di Buat!',
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
   urlcari = "barang/no"
   $('input[name=_method]').val('POST');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : urlcari,
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Tambah data Barang');
       $('#kode_barang').val(data);
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

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "barang/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Ubah data Barang');

       $('#id').val(data.id_barang);
       $('#kode_barang').val(data.kode_barang);
       $('#nama_barang').val(data.nama_barang);
       $('#merk').val(data.merk);
       $('#kategori').val(data.id_kategori);
       $('#batas1').val(data.wajib_beli);
       $('#batas2').val(data.batas_habis);
       $('#qty').val(data.qty);
       $('#satuan').val(data.id_satuan);
       $('#hargaBeli').val(data.harga_beli);
       $('#hargaJual').val(data.harga_jual);
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
      url :"{{ url('barang') }}" + '/' + id,
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
       url : "barang/hapus",
       type : "POST",
       data : $('#form-barang').serialize(),
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
