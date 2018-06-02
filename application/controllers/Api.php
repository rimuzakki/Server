<?php
/**
* Webservice untuk data produk
* Webservice untuk melayani data produk
*/ 
require_once APPPATH . 'libraries/REST_Controller.php' ;
use Restserver\Libraries\REST_Controller;

class API extends REST_Controller {
	function __construct($config = 'rest') {
		parent ::__construct($config);
	}
	function produks_get() {
		$id = $this->get('id');
		if ($id) {
			$produk = $this->db->get_where('produk', array('id_produk'=>$id))->result();
		}else {
			$produk = $this->db->get('produk')->result();
		}
	 // generate response
	 if($produk){
		$this->response($produk,200);
				}else{
			$this->response(array('status'=>'not found'), 404);
		}
	}

	function produks_post() {
		$params = array(
			'nama' => $this->post('nama'),
			'deskripsi' => $this->post('deskripsi'),
			'kategori' => $this->post('kategori'),
			'harga' => $this->post('harga'));
		 $process = $this->db->insert('produk', $params);
		 if($process){
			// 201 artinya Succesful creation of a resource.
			$this->response(array('status'=>'succes'),201);
		 }else{
			// 502 artinya Backend service failure (data store failure).
			return $this->response(array('status'=>'fail'), 502);
		}
		
	}


	function produks_put() {
		$params = array(
				'nama'=> $this->put('nama'),
				'deskripsi'=> $this->put('deskripsi'),
				'kategori'=> $this->put('kategori'),
				'harga' => $this->put('harga'));
		$this->db->where('id_produk', $this->put('id'));
		$execute = $this->db->update('produk', $params);
		if($execute){
			$this->response(array('status'=>'succes'),201);
		}else{
			return $this->response(array('status'=>'fail'), 502);	
		}	
	}
	

	function produks_delete() {
		$this->db->where('id_produk', $this->delete('id'));
		$execute =$this->db->delete('produk');
		if($execute){
			$this->response(array('status'=>'succes'),201);
		}else{
			return $this->response(array('status'=>'fail'),502);
		}	
	}
}

