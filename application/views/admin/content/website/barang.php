<!-- ================================================== VIEW ================================================== -->
<style>
    .dataTables_filter input[type="search"],.dataTables_filter{
   display: none !important;
}
    </style>

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
                        <h5 class="panel-title">View
                            <?php echo $breadcrumb; ?> Data
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
                            <div class="navigation-btn">
                                <form action="" method="post" id="form">
    <div class="row margin-bottom">

        <!-- Supplier -->
        <div class="col-md-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control">
                <option value="">All Suppliers</option>

                <?php
                $suppliers = $this->db->query("SELECT * FROM supplier ORDER BY nama_supplier ASC")->result();

                foreach($suppliers as $sup){
                ?>
                <option value="<?php echo $sup->id_supplier;?>"
                    <?php echo (@$supplier_id == $sup->id_supplier) ? 'selected' : ''; ?>>
                    <?php echo $sup->nama_supplier;?>
                </option>
                <?php } ?>
            </select>
        </div>

        <!-- Product Name -->
        <div class="col-md-3">
            <label>Product Name</label>
            <input type="text"
                   name="product_name"
                   class="form-control"
                   value="<?php echo @$product_name;?>"
                   placeholder="Enter Product Name">
        </div>

        <!-- Brand -->
        <div class="col-md-3">
            <label>Brand</label>
            <input type="text"
                   name="brand"
                   class="form-control"
                   value="<?php echo @$brand;?>"
                   placeholder="Enter Brand">
        </div>

        <!-- Buttons -->
        <div class="col-md-3">
            <label>&nbsp;</label><br>

            <button type="submit"
                    name="search"
                    class="btn btn-success">
                <i class="fa fa-search"></i> Search
            </button>

            <a href="<?php echo site_url('website/products');?>"
               class="btn btn-primary">
                <i class="fa fa-refresh"></i> Reset
            </a>
        </div>

    </div>
</form>
                            </div>
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <th width=80>#</th>
                                        <th width=140>Supplier Name</th>
                                        <th width=140>Product Name</th>
                                        <th width=120>Brand</th>
                                        <th width=80 class="text-center">Stock</th>
                                        <th width=270>Date</th>
                            <?php if ($admin->admin_level_kode == 1) { ?>
                                        <th class="text-center">Action</th>
                            <?php } ?>
                                    </thead>
                                    <tbody>
<?php
$i = $page + 1;

$products = $this->ADM->grid_all_barang(
    '*, (COALESCE((SELECT SUM(quantity) FROM purchase_details WHERE product_id = master_barang.id_barang),0) - COALESCE((SELECT SUM(quantity) FROM purchase_details WHERE product_id = master_barang.id_barang),0)) as qty',
    'nama_barang',
    'ASC',
    $batas,
    $page,
    '',
    ''
);

$found = false;

foreach($products as $row){

    // Supplier Filter
    if(!empty($supplier_id) && $row->supplier_id != $supplier_id){
        continue;
    }

    // Product Name Filter
    if(!empty($product_name)){
        if(stripos($row->nama_barang, $product_name) === false){
            continue;
        }
    }

    // Brand Filter
    if(!empty($brand)){
        if(stripos($row->merek, $brand) === false){
            continue;
        }
    }

    $found = true;

    $sql_supplier = $this->db->query(
        "SELECT * FROM supplier WHERE id_supplier='".$row->supplier_id."'"
    );
    $supplier = $sql_supplier->row();
?>
<tr>
    <td><?php echo $i; ?></td>

    <td>
        <?php echo !empty($supplier) ? $supplier->nama_supplier : ''; ?>
    </td>

    <td>
        <?php echo $row->nama_barang; ?>
    </td>

    <td>
        <?php echo $row->merek; ?>
    </td>

    <td class="text-center" style="color:red !important">
        <?php echo $row->stock; ?>
    </td>

    <td>
        <b>Created:</b>
        <?php echo dateIndo($row->barang_created); ?>
        <br>

        <b>Last modified:</b>
        <?php echo dateIndo($row->barang_updated); ?>
    </td>

    <?php if ($admin->admin_level_kode == 1) { ?>
    <td class="text-center action">
        <a class="btn-update"
           href="<?php echo site_url();?>website/products/edit/<?php echo $row->id_barang;?>">
            <i class="icon wb-pencil"></i>
        </a>

        <a class="text-danger"
           href="javascript:;"
           data-id="<?php echo $row->id_barang;?>"
           data-toggle="modal"
           data-target="#modal-konfirmasi"
           title="<?php echo $row->nama_barang;?>">
            <i class="icon wb-trash"></i>
        </a>
    </td>
    <?php } ?>
</tr>
<?php
    $i++;
}

if(!$found){
?>
<tr style="border:none;">
    <td></td>
    <td></td>
    <td style="color:red;">No data found!</td>
    <td></td>
    <td></td>
    <td></td>
    <?php if ($admin->admin_level_kode == 1) { ?>
    <td></td>
    <?php } ?>
</tr>
<?php
}
?>
</tbody>
                                </table>
                            </div>
                            <div class="wrapper">
                                <div class="paging">
                                    <div id='pagination'>
                                        <div class='pagination-right'>
                                            <ul class="pagination">
                                                <?php if ($jml_halaman > 1) { echo pages($halaman, $jml_halaman, 'website/products/view', $id=""); }?>
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
    <a href="<?php echo site_url();?>website/products/tambah">
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
                <a href="javascript:;" class="btn btn-danger" id="hapus-barang">Yes</a>
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
                        <form action="<?php echo site_url();?>website/products/tambah" method="post" id="exampleStandardForm" autocomplete="off">

                         <div class="form-group form-material">
                                <label class="control-label" for="inputText">Select Supplier </label>
                                <select name="supplier_id" class="form-control" required>
                        <option value="">Choose Supplier</option>

                        <?php
                        $suppliers = $this->db->query("SELECT * FROM supplier ORDER BY nama_supplier ASC")->result();

                        foreach($suppliers as $sup){
                        ?>
                        <option value="<?php echo $sup->id_supplier; ?>"> <?php echo $sup->nama_supplier; ?>

                        </option>
                        <?php } ?>

                    </select>
                            </div>
                        <div class="form-group form-material">
                                <label class="control-label" for="inputText">Product Image</label>
                                <input type="file" class="form-control btn-sm input-sm" size="100" name="image" id="image">
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Name</label>
                                <input type="text" class="form-control input-sm" id="nama_barang" name="nama_barang" placeholder="Item name" required/>
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Brand</label>
                                <input type="text" class="form-control input-sm" id="merek" name="merek" placeholder="Brand" required/>
                            </div>
                            <div class='button center'>
                                <input class="btn btn-success btn-sm" type="submit" name="simpan" value="Add Data" id="validateButton2">
                                <input class="btn btn-danger btn-sm" type="reset" name="batal" value="Cancel" onclick="location.href='<?php echo site_url(); ?>website/products'"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="<?php echo site_url();?>website/products">
		<button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
			<i class="icon wb-eye" aria-hidden="true"></i>
		</button>
	</a>
</div>
<!-- ================================================== END TAMBAH ================================================== -->

<!-- ================================================== EDIT ================================================== -->
<?php } elseif ($action == 'edit') { ?>
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
                        <h5 class="panel-title">Edit <?php echo $breadcrumb; ?></h5>
                    </div>
                    <div class="panel-body container-fluid">
                        <form action="<?php echo site_url();?>website/products/edit/<?php echo $id_barang;?>" method="post" id="exampleStandardForm" autocomplete="off">
                            <input type="hidden" name="id_barang" value="<?php echo $id_barang;?>" />

                             <div class="form-group form-material">
                                <label class="control-label" for="inputText">Select Supplier </label>
                                <select name="supplier_id" class="form-control" required>
                        <option value="">Choose Supplier</option>

                        <?php
                        $suppliers = $this->db->query("SELECT * FROM supplier ORDER BY nama_supplier ASC")->result();

                        foreach($suppliers as $sup){
                        ?>
                        <option value="<?php echo $sup->id_supplier; ?>" <?php if($sup_id==$sup->id_supplier){?> selected <?php }?>> <?php echo $sup->nama_supplier; ?>

                        </option>
                        <?php } ?>

                    </select>
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Item name</label>
                                <input type="text" value="<?php echo $nama_barang; ?>" class="form-control input-sm" id="nama_barang" name="nama_barang" placeholder="Item name"
                                    required/>
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Brand</label>
                                <input type="text" value="<?php echo $merek; ?>" class="form-control input-sm" id="merek" name="merek"
                                    placeholder="Brand" required/>
                            </div>
                            <div class='button center'>
                                <input class="btn btn-success btn-sm" type="submit" name="simpan" value="Update Data" id="validateButton2">
                                <input class="btn btn-danger btn-sm" type="reset" name="batal" value="Cancel" onclick="location.href='<?php echo site_url(); ?>website/products'"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="<?php echo site_url();?>website/products">
		<button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
			<i class="icon wb-eye" aria-hidden="true"></i>
		</button>
	</a>
</div>
<!-- ================================================== END EDIT ================================================== -->
<?php } ?>