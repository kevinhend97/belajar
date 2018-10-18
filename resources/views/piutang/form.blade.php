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
						<label for="nama" class="col-md-3 control-label">No. Nota</label>
						<div class="col-md-6">
							<input id="noNota" type="text" autofocus="autofocus" placeholder="Nomor Nota" readonly="readonly" class="form-control" maxlength="100" required="required">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Kode Pelanggan</label>
						<div class="col-md-6">
							<input id="kodepel" type="text" name="kodepel" autofocus="autofocus" placeholder="Kode Pelanggan" class="form-control" maxlength="100" required="required" readonly="readonly">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Total Pembayaran</label>
						<div class="col-md-6">
							<input id="totpem" type="text" name="totpem" autofocus="autofocus" placeholder="Total Pembayaran" class="form-control" maxlength="100" required="required" readonly="readonly">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Piutang</label>
						<div class="col-md-6">
							<input id="piutang" type="text" autofocus="autofocus" placeholder="Piutang Pelanggan" class="form-control" maxlength="100" required="required" readonly="readonly">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Bayar</label>
						<div class="col-md-6">
							<input id="piutang" type="text" autofocus="autofocus" placeholder="Bayar" name="bayar" class="form-control" maxlength="100" required="required">
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