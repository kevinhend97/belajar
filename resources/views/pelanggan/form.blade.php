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
						<label for="nama" class="col-md-3 control-label">Kode Pelanggan</label>
						<div class="col-md-6">
							<input id="kode" type="text" name="kode" autofocus="autofocus" placeholder="Kode Pelanggan" readonly="readonly" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Nama</label>
						<div class="col-md-6">
							<input id="nama" type="text" name="nama" autofocus="autofocus" placeholder="Nama" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Alamat</label>
						<div class="col-md-6">
							<textarea placeholder="Alamat" id="alamat" name="alamat" class="form-control" required="required" style="resize: none;" rows="3"></textarea>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">No. Telp</label>
						<div class="col-md-6">
							<input id="noTelp" type="text" name="noTelp" autofocus="autofocus" placeholder="No. Telp" class="form-control"  minlength="10"  required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Provinsi</label>
						<div class="col-md-6">
							<select id="provinsi" type="text" class="form-control" name="provinsi" required>
        						<option value=""> -- Pilih Provinsi -- </option>
        						@foreach($provinsi as $list)
        						<option value="{{ $list->id }}">{{ $list->nama_provinsi }}</option>
        						@endforeach
      						</select>
      						<span class="help-block with-errors"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Kota</label>
						<div class="col-md-6">
							<select id="kota" type="text" class="form-control" name="kota" required>
        						<option value=""> -- Pilih Kota -- </option>
      						</select>
      						<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>

				<div class="modal-footer" id="tombol">
					<button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floopy-o"></i>Simpan</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
				</div>
			</form>
		</div>
	</div>	
</div>