<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxController extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_admin', 'ADM', TRUE);
		$this->load->model('M_config', 'CONF', TRUE);
	}
	
	public function getSupplierByProduct() {
		$product_id = $this->input->post('product_id');

	$this->db->select('supplier.id_supplier, supplier.nama_supplier');
	$this->db->from('transaksi_barang');

	// Join supplier table
	$this->db->join(
		'supplier',
		'supplier.id_supplier = transaksi_barang.id_supplier',
		'left'
	);

	// Filter by product
	$this->db->where('transaksi_barang.id_barang', $product_id);

	// Remove duplicate suppliers
	$this->db->group_by('transaksi_barang.id_supplier');

	$query  = $this->db->get();
	$result = $query->result();

		echo json_encode($result);
	}


   public function getPriceBySuppierProduct() {
	  $product_id=$this->input->post('product_id');
	  $supplier_id=$this->input->post('supplier_id');

	  $this->db->select('*');
	  $this->db->from('transaksi_barang');
	  $this->db->where('id_barang',$product_id);
	   $this->db->where('id_supplier',$supplier_id);
	   $query  = $this->db->get();
	   $result = $query->row();
	   echo json_encode($result);

   }


public function checkStock(){

    $product_id = $this->input->post('product_id');

    $this->db->select('stock,nama_barang');
    $this->db->from('master_barang');
    $this->db->where('id_barang', $product_id);

    $product = $this->db->get()->row();

    echo json_encode([
		'product' => $product->nama_barang,
        'stock' => $product->stock
    ]);
}


public function get_supplier_products()
{
    $supplier_id = $this->input->post('supplier_id');

    $products = $this->db
        ->select('*')
        ->from('master_barang')
         ->where('supplier_id',$supplier_id)
        ->get()
        ->result();

    $html = '<option value="">Select Product</option>';

    foreach($products as $row)
    {
        $html .= '<option value="'.$row->id_barang.'">'.$row->nama_barang.'</option>';
    }

    echo $html;
}

	 
}