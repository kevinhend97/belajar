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
						<label for="nama" class="col-md-3 control-label">Kode Barang</label>
						<div class="col-md-6">
							<input id="kode_barang" type="text" name="kode_barang" autofocus="autofocus" placeholder="Kode Barang" readonly="readonly" value="{{-- $kode_otomatis --}}" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Nama Barang</label>
						<div class="col-md-6">
							<input id="nama_barang" type="text" name="nama_barang" autofocus="autofocus" placeholder="Nama Barang" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Merk</label>
						<div class="col-md-6">
							<input id="merk" type="text" name="merk" autofocus="autofocus" placeholder="Merk" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Kategori</label>
						<div class="col-md-6">
							<select id="kategori" type="text" class="form-control" name="kategori" required>
        						<option value=""> -- Pilih Kategori -- </option>
        						@foreach($kategori as $list)
        						<option value="{{ $list->id_kategori }}">{{ $list->nama_kategori }}</option>
        						@endforeach
      						</select>
      						<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Batas 1</label>
						<div class="col-md-6">
							<input id="batas1" type="text" name="batas1" autofocus="autofocus" placeholder="Qty" class="form-control" maxlength="4" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Batas 2</label>
						<div class="col-md-6">
							<input id="batas2" type="text" name="batas2" autofocus="autofocus" placeholder="Qty" class="form-control" maxlength="4" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Qty</label>
						<div class="col-md-6">
							<input id="qty" type="text" name="qty" autofocus="autofocus" placeholder="Qty" class="form-control" maxlength="4" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Satuan</label>
						<div class="col-md-6">
							<select id="satuan" type="text" class="form-control" name="satuan" required>
        						<option value=""> -- Pilih Satuan -- </option>
        						@foreach($satuan as $list)
        						<option value="{{ $list->id_satuan }}">{{ $list->nama_satuan }}</option>
        						@endforeach
      						</select>
      						<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Harga Beli</label>
						<div class="col-md-6">
							<input id="hargaBeli" type="text" name="harga_beli" autofocus="autofocus" placeholder="Harga Beli" class="form-control" maxlength="10" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Harga Jual</label>
						<div class="col-md-6">
							<input id="hargaJual" type="text" name="harga_jual" autofocus="autofocus" placeholder="Harga Jual" class="form-control" maxlength="10" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floopy-o"></i>Simpan</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
				</div>
			</form>
		</div>
	</div>	
</div>