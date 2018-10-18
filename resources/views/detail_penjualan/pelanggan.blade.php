<div class="modal" id="modal-member" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
     
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
            <h3 class="modal-title">Cari Pelanggam</h3>
         </div>
            
         <div class="modal-body">
            <table class="table table-striped tabel-produk">
               <thead>
                  <tr>
                     <th>Kode Pelanggan</th>
                     <th>Nama Pelanggan</th>
                     <th>Alamat</th>
                     <th>Telpon</th>
                     <th>Pilihan</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($pelanggan as $data)
                  <tr>
                     <th>{{ $data->kode_pelanggan }}</th>
                     <th>{{ $data->nama }}</th>
                     <th>{{ $data->alamat }}</th>
                     <th>{{ $data->telp }}</th>
                     <th><a onclick="selectMember({{ $data->kode_pelanggan }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></th>
                   </tr>
                  @endforeach
               </tbody>
            </table>
         </div>  
      </div>
   </div>
</div>
