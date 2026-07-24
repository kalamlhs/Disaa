<!DOCTYPE html>
<html>
<head>
    <title>Sales Invoice</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>templates/backend/assets/css/bootstrap/bootstrap.css">
	

	<!-- Style CSS -->
	

    <style>

        body{
            background:#f4f6f9;
            font-family:Arial, sans-serif;
        }

        .invoice-box{
            background:#fff;
            padding:40px;
            margin:30px auto;
            border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,0.1);
        }

        .invoice-title{
            font-size:32px;
            font-weight:bold;
            color:#007bff;
        }

        .company-details{
            line-height:28px;
        }

        .table thead th{
            background:#007bff;
            color:#fff;
            text-align:center;
        }

        .table td{
            vertical-align:middle;
        }

        .total-table th{
            width:200px;
            background:#f8f9fa;
        }

        .signature{
            margin-top:80px;
        }

        @media print{

            body{
                background:#fff;
            }

            .invoice-box{
                box-shadow:none;
                margin:0;
                width:100%;
            }

        }

    </style>
</head>

<body>
<?php 
$this->db->select('*');
  $this->db->from('customer');
 $this->db->where('id_customer', $invoice->customer_id);
$customer = $this->db->get()->row();
?>
<div class="container">

    <div class="invoice-box">

        <!-- Header -->
        <div class="row mb-5">

            <div class="col-md-6">

                <div class="invoice-title">
                    INVOICE
                </div>

                <div class="company-details mt-3">

                    <strong>DISAA</strong><br>

                    Dhanbad, Jharkhand<br>

                    Phone : +91 9876543210<br>

                    Email : info@gmail.com

                </div>

            </div>

            <div class="col-md-6 text-right">

                <h5>
                    Invoice No :
                    <strong>
                        <?php echo $invoice->invoice_no; ?>
                    </strong>
                </h5>

                <h5>
                    Date :
                    <strong>
                        <?php echo date('d-m-Y',strtotime($invoice->created_at)); ?>
                    </strong>
                </h5>

            </div>

        </div>

        <!-- Supplier -->
        <div class="row mb-4">

            <div class="col-md-6">

                <h5 class="mb-3 invoice-title">
                    Customer Details
                </h5>

                <strong>
                    <?php echo $customer->nama_customer; ?>
                </strong><br>

                <?php echo $customer->alamat_customer; ?><br>

                Phone :
                <?php echo $customer->notelp_customer; ?>

            </div>

        </div>

        <!-- Product Table -->
        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Product</th>
                        <th>Rate</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>GST %</th>
                        <th>GST Amount</th>
                        <th>Total</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $i = 1;

                    $subTotal = 0;
                    $gstTotal = 0;

                    foreach($purchase_details as $row){
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

                        <td class="text-right">
                            <?php echo number_format($row->rate,2); ?>
                        </td>

                        <td class="text-right">
                            <?php echo number_format($row->price,2); ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row->quantity; ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row->gst; ?>%
                        </td>

                        <td class="text-right">
                            <?php echo number_format($row->gst_amount,2); ?>
                        </td>

                        <td class="text-right">
                            <?php echo number_format($row->total_amount,2); ?>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

        <!-- Totals -->
        <div class="row">

            <div class="col-md-6">

                <h5>
                    Payment Method
                </h5>

                <?php echo $invoice->payment_method;?>

            </div>

            <div class="col-md-6">

                <table class="table table-bordered total-table">

                    <tr>

                        <th>Sub Total</th>

                        <td class="text-right">
                            <?php echo number_format($subTotal,2); ?>
                        </td>

                    </tr>

                    <tr>

                        <th>Total GST</th>

                        <td class="text-right">
                            <?php echo number_format($gstTotal,2); ?>
                        </td>

                    </tr>

                    <tr>

                        <th>Grand Total</th>

                        <td class="text-right">
                            <strong>
                                <?php echo number_format($subTotal,2); ?>
                            </strong>
                        </td>

                    </tr>

                </table>

            </div>

        </div>
<div class="col-md-12 text-right">

               <b> In Words : <?php echo $inwords;?></b>

            </div>
       

        <!-- Signature -->
        <div class="row signature">

            <div class="col-md-6 text-left">

                Customer Signature

            </div>

            <div class="col-md-6 text-right">

                Authorized Signature

            </div>

        </div>

    </div>

</div>

</body>
</html>