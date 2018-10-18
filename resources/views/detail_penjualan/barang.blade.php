<div class="modal" id="modal-produk" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
	  
	   <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
	      <h3 class="modal-title">Cari Produk</h3>
	   </div>
				
		<div class="modal-body">
			<table class="table table-striped tabel-produk">
				<thead>
				   <tr>
				      <th>Kode Barang</th>
				      <th>Nama Barang</th>
				      <th>Harga Jual</th>
				      <th>Pilihan</th>
				   </tr>
				</thead>
				<tbody>
					@foreach($barang as $data)
					<tr>
				      <th>{{ $data->kode_barang }}</th>
				      <th>{{ $data->nama_barang }}</th>
				      <th>Rp. {{ format_uang($data->harga_jual) }}</th>
				      <th><a onclick="selectItem({{ $data->id_barang }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></th>
				    </tr>
					@endforeach
				</tbody>
			</table>
		</div>
         </div>
    </div>
</div>
