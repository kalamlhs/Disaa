<!-- ================================================== VIEW ================================================== -->


<?php if ($action == 'view' || empty($action)){ ?>
	<div class="page">
		<div class="page-title blue">
			<h3>
				<?php echo $breadcrumb; ?>
			</h3>
			<p>Information About
				<?php echo $breadcrumb; ?>
			</p>
		</div>
		<div class="page-content container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="panel rounded-0">
						<div class="panel-heading">
							<h5 class="panel-title">View Data
								<?php echo $breadcrumb; ?>
							</h5>
						</div>
						<!-- ========== Flashdata ========== -->
						<?php if ($this->session->flashdata('success') || $this->session->flashdata('warning') || $this->session->flashdata('error')) { ?>
						<?php if ($this->session->flashdata('success')) { ?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-check sign"></i>
							<?php echo $this->session->flashdata('success'); ?>
						</div>
						<?php } else if ($this->session->flashdata('warning')) { ?>
						<div class="alert alert-warning">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-check sign"></i>
							<?php echo $this->session->flashdata('warning'); ?>
						</div>
						<?php } else { ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-warning sign"></i>
							<?php echo $this->session->flashdata('error'); ?>
						</div>
						<?php } ?>
						<?php } ?>
						<!-- ========== End Flashdata ========== -->
						<div class="panel-body container-fluid table-detail">
							<div class="table-full table-view">
								
								<div class="table-responsive">
									 <table id="myTable" class="table table-bordered table-striped">
										<thead>
											<th width=80>#</th>
											<th width=200>Invoice Number</th>
											<th width=200>Customer</th>
											<th width=80>Total Amount</th>
											<th width=80>Payment Mode</th>								
											<th width=120>Date</th>
											<th width=120>Action</th>
</thead>
<tbody>
	<?php $query=$this->db->query('SELECT * FROM sales ORDER BY id DESC');
	      $result=$query->result();
		  $i=1;
		  foreach($result as $row){
			$customerSql=$this->db->query('SELECT * FROM customer WHERE id_customer="'.$row->customer_id.'"');
	      $customer=$customerSql->row();
			
			
			?>
		  <tr>
           <td> <?php echo $i;?></td>
		   <td> <?php echo $row->invoice_no;?></td>
           <td> <?php echo $customer->nama_customer;?></td>
		    <td> <?php echo number_format($row->total_amount,2);?></td>
            <td> <?php echo $row->payment_method;?></td>
			<td> <?php echo date('d-m-Y h:i A',strtotime($row->created_at));?></td>
			<td style="width:18%;"> <a href="<?php echo base_url('website/sales_details/'.$row->id);?>">
				<button class="btn btn-primary btn-sm"><i class="icon wb-eye "></i> Products</button></a>
<a href="<?php echo base_url('website/sales_invoice/'.$row->id);?>" target="_blank">
				<button class="btn btn-success btn-sm"><i class="icon wb-eye "></i> Invoice</button></a>

			</td>
            </tr>
		  <?php  $i++; } ?>
	

</tbody>
</table>
								</div>
								<div class="wrapper">
									<div class="paging">
										<div id='pagination'>
											<div class='pagination-right'>
												<ul class="pagination">
													<?php if ($jml_halaman > 1) { echo pages($halaman, $jml_halaman, 'website/keluar/view', $id=""); }?>
												</ul>
											</div>
										</div>
									</div>
									<div class="total">Total :
										<?php echo $jml_data;?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
                            <?php if ($admin->admin_level_kode == 1) { ?>
		<a href="<?php echo site_url();?>website/keluar/tambah">
			<button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
				<i class="icon wb-plus" aria-hidden="true"></i>
			</button>
		</a>
							<?php } ?>
	</div>
	<!-- ========== Modal Konfirmasi ========== -->
	<div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Confirmation</h4>
				</div>
	
				<div class="modal-body" style="background:#d9534f;color:#fff">
				Are you sure you want to delete this data?
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-danger" id="hapus-keluar">Yes</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ========== End Modal Konfirmasi ========== -->
	<!-- ================================================== END VIEW ================================================== -->
	
	<!-- ================================================== TAMBAH ================================================== -->
	<?php } elseif ($action == 'tambah') { ?>
	<div class="page">
		<div class="page-title blue">
			<h3>
				<?php echo $breadcrumb; ?>
			</h3>
			<p>Information About
				<?php echo $breadcrumb; ?>
			</p>
		</div>
		<div class="page-content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel rounded-0">
				<div class="panel-heading">
					<h5 class="panel-title">Add <?php echo $breadcrumb; ?></h5>
				</div>

				<div class="panel-body container-fluid">
					<form action="<?php echo site_url();?>website/create_sales" 
                          method="post" 
                          id="exampleStandardForm" 
                          autocomplete="off">

						  <div class="row">
                          <div class="col-md-4">
<br>
                                <div class="form-group form-material">
                                    <label class="control-label">Customer</label>

                                    <select name="customer_id" class="form-control input-sm select2">
                                        <?php foreach ($this->ADM->grid_all_customer('', 'id_customer', 'DESC', 100, '', '' , '') as $customer){ ?>
                                            <option value="<?php echo $customer->id_customer ?>">
                                                <?php echo $customer->nama_customer ?> - <?php echo $customer->notelp_customer;?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                               </div>

								 <div class="col-md-3">
									<br>

                                <div class="form-group form-material">
                                    <label class="control-label">Invoice No.</label>
									<input type="text"
                                           class="form-control input-sm"
                                           id="invoice_no"
                                           name="invoice_no"
										   value="<?php echo $invoice_no;?>"
                                           placeholder="Invoice Number"
                                           required
                                         />
                                </div>
                              </div>

							  <div class="col-md-3">
<br>
                                <div class="form-group form-material">
                                    <label class="control-label">Invoice Date.</label>
									<input type="date"
                                           class="form-control input-sm"
                                           id="invoice_date"
                                           name="invoice_date"
                                           placeholder="Invoice Date"
										   value="<?php echo date('Y-m-d');?>"
                                           required
                                         />
                                </div>
                              </div>
                        </div>

                        <div class="row">

						

						<table class="table" id="productTable">
    <tr>
        <th>Product</th>
        <th style="width:100px;">Rate</th>
        <th style="width:100px;">Price</th>
        <th style="width:110px;">Quantity</th>
        <th style="width:100px;"> GST(%)</th>
        <th style="width:100px;">GST Amount</th>
        <th style="width:120px;">Total Amount</th>
        <th>Action</th>
    </tr>

    <tr class="product-row">
        <td>
            <select name="product_id[]" class="form-control input-sm select2" style="width:100%;">
                <?php foreach ($this->ADM->grid_all_barang('', 'id_barang', 'DESC', 100, '', '' , '') as $barang){ ?>
                    <option value="<?php echo $barang->id_barang ?>">
                        <?php echo $barang->nama_barang ?>
                    </option>
                <?php } ?>
            </select>
        </td>

        <td>
            <input type="number"
                   class="form-control input-sm rate"
                   name="rate[]"
                   placeholder="Rate"
                   onkeyup="gstCalculate(this)" onchange="gstCalculate(this)" />
        </td>

        <td>
            <input type="number"
                   class="form-control input-sm price"
                   name="price[]"
                   placeholder="Price"
                   onkeyup="gstCalculate(this)"  onchange="gstCalculate(this)"/>
        </td>

        <td>
            <input type="number"
                   class="form-control input-sm jumlah"
                   name="quantity[]"
                   placeholder="Quantity"
				   value="1",
				   min="1",
                   onkeyup="gstCalculate(this)"  onchange="gstCalculate(this)"/>
        </td>

        <td>
            <input type="text"
                   class="form-control input-sm gst"
                   name="gst[]"
                   placeholder="GST(%)"
                   min="0"
                   onkeyup="gstCalculate(this)" />
        </td>

        <td>
            <input type="text"
                   class="form-control input-sm gst_amount"
                   name="gst_amount[]"
                   placeholder="GST Amount"
                   readonly />
        </td>

        <td>
            <input type="text"
                   class="form-control input-sm total_amount"
                   name="total_amount[]"
                   placeholder="Total Amount"
                   readonly />
        </td>

        <td>
            <i class="fa fa-plus addRow" style="cursor:pointer;color:green;"></i>

            <i class="fa fa-trash removeRow" style="cursor:pointer;color:red;margin-left:10px;"></i>
        </td>
    </tr>
	
</table>

	<br>
 <div class="col-md-12">
	<label style="margin-left: 69%;">Total Amouunt :<span_id="TotalAmont"><input type="text" name="grand_total" id="grand_total" readonly></span></label>
</div>

<div class="col-md-12">
	<select name="payment_method" class="form-control" style="width: 14%; margin-left: 77%;">
           <option value="cash">Cash</option>
		   <option value="online">Online</option>
</select>
	
</div>
<br>
<br><br>

                            <!-- LEFT COLUMN -->
                          

                        <div class="button center mt-3">
                            <div class="alert"></div>

                            <input class="btn btn-success btn-sm btnSave"
                                   type="submit"
                                   name="simpan"
                                   value="Add Data"
                                   id="validateButton2">

                            <input class="btn btn-danger btn-sm"
                                   type="reset"
                                   name="batal"
                                   value="Cancel"
                                   onclick="location.href='<?php echo site_url(); ?>website/masuk'" />
                        </div>

                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
		<a href="<?php echo site_url();?>website/keluar">
			<button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
				<i class="icon wb-eye" aria-hidden="true"></i>
			</button>
		</a>
	</div>
	<!-- ================================================== END TAMBAH ================================================== -->
	<?php } ?>

	
	<script>

$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Search here",
        allowClear: true,
       });
});

  $(document).on('click', '.addRow', function () {

    let row = $(this).closest('tr').clone();

    // clear all input values
    row.find('input').val('');

    // default quantity = 1
    row.find('.jumlah').val(1);

    $('#productTable').append(row);

    // reinitialize select2
    row.find('.select2')
        .removeClass('select2-hidden-accessible')
        .next('.select2-container')
        .remove();

    row.find('.select2').select2();

});


    // REMOVE ROW
    $(document).on('click', '.removeRow', function () {

    if ($('#productTable .product-row').length > 1) {

        // current row total
        let rowTotal = parseFloat(
            $(this).closest('tr').find('.total_amount').val()
        ) || 0;

        // current grand total
        let grandTotal = parseFloat($('#grand_total').val()) || 0;

        // minus value
        grandTotal = grandTotal - rowTotal;

        // update grand total
        $('#grand_total').val(grandTotal.toFixed(2));

        // remove row
        $(this).closest('tr').remove();

    } else {

        alert('At least one row required');

    }

});



function gstCalculate(element) {

    let grandTotal = 0;
    let row = $(element).closest('tr');

    let product_id = row.find('select[name="product_id[]"]').val();
    let rate       = parseFloat(row.find('.rate').val()) || 0;
    let price      = parseFloat(row.find('.price').val()) || 0;
    let quantity   = parseFloat(row.find('.jumlah').val()) || 0;

    // ================= STOCK CHECK =================
    $.ajax({
        url: "<?php echo base_url('AjaxController/checkStock'); ?>",
        type: "POST",
        data: {
            product_id: product_id
        },
        dataType: "json",
        success: function(response){

            let stock = parseFloat(response.stock) || 0;
             console.log(response);
            if(quantity > stock){
				$('.btnSave').attr('disabled', true);

                $('.alert').html('<font color="red"><b>'+response.product +' has '  + stock + ' stock available</b></font>');

                row.find('.jumlah').val(stock);

                quantity = stock;

               

            }else{
				$('.btnSave').removeAttr('disabled');
				$('.alert').html('');
			}
            
            calculateRow(row, rate, price, quantity);
			
        }
    });
}


// ================= CALCULATION FUNCTION =================
function calculateRow(row, rate, price, quantity){

    let grandTotal = 0;

    // subtotal
    let subtotal = price * quantity;

    // GST %
    let gst = 0;

    if (rate > 0 && price > 0) {
        gst = ((price - rate) / rate) * 100;
    }

    // GST Amount
    let gstAmount = subtotal - (rate * quantity);

    // Total
    let total = subtotal;

    // set values
    row.find('.gst').val(gst.toFixed(2));
    row.find('.gst_amount').val(gstAmount.toFixed(2));
    row.find('.total_amount').val(total.toFixed(2));

    $('.total_amount').each(function () {
        grandTotal += parseFloat($(this).val()) || 0;
    });

    $('#grand_total').val(grandTotal.toFixed(2));
}

	




</script>