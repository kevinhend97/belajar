<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" data-toggle="validator" method="post">
				{{csrf_field()}} {{ method_field('POST') }}

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times;</span></button>
					<h3 class="modal-title"></h3>
				</div>

				<div class="modal-body">
					<input type="hidden" id="id"  name="id">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Kategori</label>
						<div class="col-md-6">
							<select id="kategori" class="form-control" name="kategori" required>
        						<option value=""> -- Pilih Kategori -- </option>
        						@foreach($kategori as $list)
        						<option value="{{ $list->id_kategori }}">{{ $list->nama_kategori }}</option>
        						@endforeach
      						</select>
      						<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group" id="kota_input">
    					<label for="nama" class="col-md-3 control-label">Nama Produk</label>
    					<div class="col-md-6">
      						<input id="nama_produk" type="text" name="nama_produk" autofocus="autofocus" placeholder="Nama Produk" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
    					</div>
  					</div>

  					<div class="form-group" id="kota_input">
    					<label for="nama" class="col-md-3 control-label">Merk</label>
    					<div class="col-md-6">
      						<input id="merk" type="text" name="merk" autofocus="autofocus" placeholder="Merk" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
    					</div>
  					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floopy-o"></i>Simpan</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>Batal</button>
				</div>
			</form>
		</div>
		
	</div>
	
</div>