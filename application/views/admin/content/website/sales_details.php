<!-- ================================================== VIEW ================================================== -->

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
						<div class="row">
						<div class=" col-md-6" style="padding: 13px 29px 3px;">
							<b>Invoice : <?php echo $sales->invoice_no;?></b>
							
						</div>

						
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
								
								<div class="table-responsive1">

            <table id="myTable" class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th class="text-center">#</th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">GST %</th>
                        <th class="text-center">GST Amount</th>
                        <th class="text-center">Total</th>

                    </tr>
					

                </thead>

                <tbody>

                    <?php
                    $i = 1;

                    $subTotal = 0;
                    $gstTotal = 0;

                    foreach($sales_details as $row){
$this->db->select('*');
  $this->db->from('master_barang');
 $this->db->where('id_barang', $row->product_id);
$pro = $this->db->get()->row();
                        $subTotal += $row->total_amount;
                        $gstTotal += $row->gst_amount;
                    ?>

                    <tr>

                        <td class="text-center">
                            <?php echo $i++; ?>
                        </td>

                        <td>
                            <?php echo $pro->nama_barang; ?>
                        </td>

                        <td class="text-center">
                            <?php echo number_format($row->rate,2); ?>
                        </td>

                        <td class="text-center">
                            <?php echo number_format($row->price,2); ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row->quantity; ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row->gst; ?>%
                        </td>

                        <td class="text-center">
                            <?php echo number_format($row->gst_amount,2); ?>
                        </td>

                        <td class="text-center">
                            <?php echo number_format($row->total_amount,2); ?>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>
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
									<!--<div class="text-center"><marquee><b><?php echo $inwords;?></b></marquee></div>
									<div class="text-right" style="padding-right: 25px;">
										<b>Total : <?php echo number_format($subTotal,2);?></b>
										<br>
										
									</div>-->
									
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
							<?php }?>
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
					<a href="javascript:;" class="btn btn-danger" id="hapus-masuk">Yes</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ========== End Modal Konfirmasi ========== -->
	<!-- ================================================== END VIEW ================================================== -->
	
	<!-- ================================================== TAMBAH ================================================== -->
	


	<script>

	function gstCalculate(){

		let rate     = parseFloat($('#rate').val()) || 0;
		let price    = parseFloat($('#price').val()) || 0;
		let quantity = parseFloat($('#jumlah').val()) || 0;

		if(rate <= 0 || price <= 0){
			return;
		}

		// GST %
		let gstPercent = ((price - rate) / rate) * 100;

		// GST Amount per product
		let gstAmountPerProduct = price - rate;

		// Total GST Amount
		let totalGstAmount = gstAmountPerProduct * quantity;

		// Total Amount
		let totalAmount = price * quantity;

		// Set GST dropdown/input value
		$('#gst').val(gstPercent.toFixed(2));

		// Set GST Amount
		$('#gst_amount').val(totalGstAmount.toFixed(2));

		// Set Final Total
		$('#total_amount').val(totalAmount.toFixed(2));

	}











	

</script>