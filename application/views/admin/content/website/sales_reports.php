<!-- ================================================== VIEW ================================================== -->
<style>
	.dataTables_filter{
		display:none !important;
}
</style>
	
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
						

						
                       </div>
										
						<div class="panel-body container-fluid table-detail">
							<div class="table-full table-view">

							<div class="card mb-3">
    <div class="card-body">

        <form method="get">

            <div class="row" style="margin-left: 9px!important;">

                <!-- From Date -->
                <div class="col-md-2">
                    <label><b>From Date</b></label>
                    <input type="date" name="from_date" class="form-control"
                        value="<?php echo $this->input->get('from_date'); ?>">
                </div>

                <!-- To Date -->
                <div class="col-md-2">
                    <label><b>To Date</b></label>
                    <input type="date" name="to_date" class="form-control"
                        value="<?php echo $this->input->get('to_date'); ?>">
                </div>

                <!-- Supplier -->
                <div class="col-md-3">
                    <label><b>Supplier</b></label>

                    <select name="supplier_id" class="form-control">
                        <option value="">All Supplier</option>

                        <?php
                        $customers = $this->db->query("SELECT * FROM customer ORDER BY nama_customer ASC")->result();

                        foreach($customers as $cust){
                        ?>
                        <option value="<?php echo $cust->id_customer; ?>"
                            <?php if($this->input->get('customer_id_id') == $cust->id_customer){ echo 'selected'; } ?>>

                            <?php echo $cust->nama_customer; ?>

                        </option>
                        <?php } ?>

                    </select>
                </div>

                <!-- Product -->
                <div class="col-md-2">
                    <label><b>Payment Mode</b></label>

    <select name="payment_method" class="form-control">

        <option value="">Select</option>

        <option value="Cash"
            <?php if($this->input->get('payment_method')=='cash'){ echo 'selected'; } ?>>
            Cash
        </option>

        <option value="Online"
            <?php if($this->input->get('payment_method')=='online'){ echo 'selected'; } ?>>
            Online
        </option>

        
        

    </select>
                </div>

                <!-- Button -->
                <div class="col-md-3">
                    <label>&nbsp;</label>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            Filter
                        </button>

                        <a href="<?php echo current_url(); ?>" class="btn btn-danger">
                            Reset
                        </a>

						<button type="button" onclick="exportTableToExcel('dataTable', 'Sales_Report')" 
class="btn btn-success">
     Excel
</button>


                    </div>
                </div>

            </div>

        </form>

    </div>
</div>





<br>

<div class="table-responsive">

<table id="myTable1" class="table table-bordered table-striped">

    <thead>

        <tr>
            <th>#</th>
            <th>Invoice Number</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Payment Mode</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

    </thead>

    <tbody>

        <?php
        $i=1;
$netAmount=0;
        foreach($result as $row){
            $netAmount+=$row->total_amount;
        ?>

        <tr>

            <td><?php echo $i; ?></td>

            <td><?php echo $row->invoice_no; ?></td>

            <td><?php echo $row->nama_customer; ?></td>

            <td><?php echo number_format($row->total_amount,2); ?></td>

            <td><?php echo $row->payment_method; ?></td>

            <td>
                <?php echo date('d-m-Y h:i A',strtotime($row->created_at)); ?>
            </td>

            <td style="width:16%;">

                <a href="<?php echo base_url('website/sales_details/'.$row->id); ?>">
                    <button class="btn btn-primary btn-sm">
                        Products
                    </button>
                </a>

                <a href="<?php echo base_url('website/sales_invoice/'.$row->id); ?>" target="_blank">
                    <button class="btn btn-success btn-sm">
                        Invoice
                    </button>
                </a>

            </td>

        </tr>

        <?php $i++; } ?>
        <tr>
            <td colspan="3" class="text-right"><b>Total Amount :</b></td>
            <td colspan="4"  class="text-left"><b><?php echo number_format($netAmount,2);?>/-</b>&nbsp;&nbsp;
               <b>(In Words: <?php echo numberToWords($netAmount); ?>)</b>
        </td>
            
</tr>

    </tbody>

</table>



<div id="PrintDiv">

<table id="dataTable" class="table table-bordered table-striped" style="visibility: hidden; position: absolute;">

    <thead>

        <tr>
            <th>#</th>
            <th>Invoice Number</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Payment Mode</th>
            <th>Date</th>
            
        </tr>

    </thead>

    <tbody>

        <?php
        $i=1;
$netAmount=0;
        foreach($result as $row){
            $netAmount+=$row->total_amount;
        ?>

        <tr>

            <td><?php echo $i; ?></td>

            <td><?php echo $row->invoice_no; ?></td>

           <td><?php echo $row->nama_customer; ?></td>

            <td><?php echo number_format($row->total_amount,2); ?></td>

            <td><?php echo $row->payment_method; ?></td>

            <td>
                <?php echo date('d-m-Y h:i A',strtotime($row->created_at)); ?>
            </td>

            

        </tr>

        <?php $i++; } ?>
        <tr>
            <td colspan="3" class="text-right"><b>Total Amount :</b></td>
            <td colspan="3"  class="text-left"><b><?php echo number_format($netAmount,2);?>/-</b>&nbsp;&nbsp;
               <b>(In Words: <?php echo numberToWords($netAmount); ?>)</b>
        </td>
            
</tr>

    </tbody>

</table>
</div>

</div>

								
								<!--<div class="wrapper">
									<div class="paging">
										<div id='pagination'>
											<div class='pagination-right'>
												<ul class="pagination">
													<?php if ($jml_halaman > 1) { echo pages($halaman, $jml_halaman, 'website/masuk/view', $id=""); }?>
												</ul>
											</div>
										</div>
									</div>
									<div class="text-center"><marquee><b><?php echo $inwords;?></b></marquee></div>
									<div class="text-right" style="padding-right: 25px;">
										<b>Total : <?php echo number_format($subTotal,2);?></b>
										<br>
										
									</div>
									
								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
                           
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

function exportTableToExcel(tableID, filename = '') {

    let table = document.getElementById(tableID);

    if (!table) {
        alert('Table not found');
        return;
    }

    // Clone original table
    let cloneTable = table.cloneNode(true);

    // Table style
    let cells = cloneTable.querySelectorAll('th, td');

    cells.forEach(function(cell) {

        cell.style.border = '1px solid black';
        cell.style.padding = '6px';
        cell.style.fontSize = '14px';

    });

    cloneTable.style.borderCollapse = 'collapse';
    cloneTable.style.width = '100%';

    // Logo path
    //let logo = 'http://localhost/disaa/assets/1345436be74a8e5f1acf29a01a9d760a.jpeg';

    // HTML
    let html = `
    <html xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:x="urn:schemas-microsoft-com:office:excel"
          xmlns="http://www.w3.org/TR/REC-html40">

    <head>

        <meta charset="UTF-8">

        <style>

            body{
                font-family:Arial;
                padding:20px;
            }

            table{
                border-collapse:collapse;
            }

            th{
                background:#f2f2f2;
                font-weight:bold;
                text-align:center;
            }

            td{
                text-align:left;
            }

            .company-name{
                font-size:28px;
                font-weight:bold;
                margin:0;
            }

            .report-title{
                font-size:16px;
                margin-top:5px;
            }

        </style>

    </head>

    <body>

        <!-- Header -->
        <table width="100%" border="0">

            <tr>

               
                <!-- Center Heading -->
                <td colspan="6" valign="middle" style="border:none;text-align:center;">

                    <div class="company-name">
                        DISAA - Sales Report
                    </div>

                    

                </td>

               

            </tr>

        </table>

        <br><br>

        <!-- Export Table -->
        ${cloneTable.outerHTML}

    </body>

    </html>
    `;

    // Create file
    let blob = new Blob(
        ['\ufeff' + html],
        {
            type: 'application/vnd.ms-excel'
        }
    );

    let url = URL.createObjectURL(blob);

    let a = document.createElement('a');

    a.href = url;

    a.download = filename ? filename + '.xls' : 'report.xls';

    document.body.appendChild(a);

    a.click();

    document.body.removeChild(a);

    URL.revokeObjectURL(url);
}

</script>