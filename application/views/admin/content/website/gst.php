KALOAM

<!-- ================================================== VIEW ================================================== -->

<!-- ================================================== END VIEW ================================================== -->

<!-- ================================================== EDIT ================================================== -->

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
						<h5 class="panel-title">GST  Master</h5>
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
					<div class="panel-body container-fluid">
						<form action="<?php echo site_url();?>website/gst/edit/<?php echo $gst_id;?>" method="post" enctype="multipart/form-data"
						id="exampleStandardForm" autocomplete="off">
							<input type="hidden" name="gst_id" value="<?php echo $gst_id;?>" />
							<div class="form-group form-material">
								<label class="control-label" for="inputText">GST (%)</label>
								<input type="text" class="form-control input-sm" id="gst" name="gst" placeholder="Enter GST"
								 min="0"  max="100" step="0.01"
								value="<?php echo $gst;?>" required />
							</div>
							<div class="form-group form-material">
								<label class="control-label" for="inputText">Created </label>
								<input type="text" disabled class="form-control input-sm" id="limitstock_created" name="limitstock_created" value="<?php echo $gst_created;?>"
								/>
							</div>
							<div class="form-group form-material">
								<label class="control-label" for="inputText">Last Changed</label>
								<input type="text" disabled class="form-control input-sm" id="limitstock_updated" name="limitstock_updated" value="<?php echo $gst_updated;?>"
								/>
							</div>
							<div class='button center'>
								<input class="btn btn-success btn-sm" type="submit" name="simpan" value="Update Data" id="validateButton2">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ================================================== END EDIT ================================================== -->
