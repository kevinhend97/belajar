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
						<label for="nama" class="col-md-3 control-label">Nama</label>
						<div class="col-md-6">
							<input id="nama" type="text" name="name" autofocus="autofocus" placeholder="Ex. Kevin" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Username</label>
						<div class="col-md-6">
							<input id="username" type="text" name="username" autofocus="autofocus" placeholder="Ex. admin" class="form-control" maxlength="100" required="required">
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
						<label for="nama" class="col-md-3 control-label">E-mail</label>
						<div class="col-md-6">
							<input id="email" type="text" name="email" autofocus="autofocus" placeholder="Ex. example@example.com" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">No. Telp</label>
						<div class="col-md-6">
							<input id="notelp" type="text" name="no_telp" autofocus="autofocus" placeholder="Ex. 123456789012" class="form-control" minlength="12" maxlength="12" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Jabatan</label>
						<div class="col-md-6">
							<select id="jabatan" name="jabatan" class="form-control">
								<option>--- Pilih ---</option>
								<option value="Karyawan">Karyawan</option>
								<option value="Kasir">Kasir</option>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group" id="pass">
						<label for="nama" class="col-md-3 control-label">Password</label>
						<div class="col-md-6">
							<input id="password" type="password" name="password" autofocus="autofocus" placeholder="Ex. password" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group" id="confirm">
						<label for="nama" class="col-md-3 control-label">Konfirmasi Password</label>
						<div class="col-md-6">
							<input id="password" type="password" name="confirmed" autofocus="autofocus" placeholder="Ex. password" class="form-control" maxlength="100" required="required">
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

<div class="modal" id="modal-form2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
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
						<label for="nama" class="col-md-3 control-label">Nama</label>
						<div class="col-md-6">
							<input id="nama2" type="text" name="name" autofocus="autofocus" placeholder="Ex. Kevin" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Username</label>
						<div class="col-md-6">
							<input id="username2" type="text" name="username" autofocus="autofocus" placeholder="Ex. admin" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Alamat</label>
						<div class="col-md-6">
							<textarea placeholder="Alamat" id="alamat2" name="alamat" class="form-control" required="required" style="resize: none;" rows="3"></textarea>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">E-mail</label>
						<div class="col-md-6">
							<input id="email2" type="text" name="email" autofocus="autofocus" placeholder="Ex. example@example.com" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">N0. Telp</label>
						<div class="col-md-6">
							<input id="notelp2" type="text" name="no_telp" autofocus="autofocus" placeholder="Ex. 123456789012" class="form-control" maxlength="100" required="required" onkeypress="return hanyaAngka(event)">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Jabatan</label>
						<div class="col-md-6">
							<select id="jabatan2" name="jabatan" class="form-control">
								<option>--- Pilih ---</option>
								<option value="Pemilik">Pemilik</option>
								<option value="Karyawan">Karyawan</option>
								<option value="Kasir">Kasir</option>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>

				<div id="tombol" class="modal-footer">
					<button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floopy-o"></i>Simpan</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
				</div>
			</form>
		</div>

	</div>

</div>
