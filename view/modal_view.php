<div class="modal fade" id="barang_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Barang Sales Order</h5>
      </div>
      <div class="modal-body">
		<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">Nama Barang</label>
						<div class="col-md-10">
							<input id="namabarang_txt" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Qty</label>
						<div class="col-md-2">
							<input id="qty_txt" type="text" class="form-control" onkeypress="return isNumber(event)" autocomplete="off">
						</div>
						<div class="col-md-6">
							<input id="kodebarang_txt" type="text" class="form-control" disabled style="display:none">
							<input id="idbarang_txt" type="text" class="form-control" disabled style="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" >Harga</label>
						<div class="col-md-6">
							<input id="harga_txt" type="text" class="form-control" onkeypress="return isNumber(event)" autocomplete="off">
						</div>
					</div>
				</fieldset>
		</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_data">Save changes</button>
				<button type="button" class="btn btn-info" id="update_data">Update changes</button>
      </div>
      </div>
	</div>
  </div>
</div>
