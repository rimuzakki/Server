<?php
/**
* Webservice untuk data customer
* Webservice untuk melayani data customer
*/ 
require_once APPPATH . 'libraries/REST_Controller.php' ;
use Restserver\Libraries\REST_Controller;

class API extends REST_Controller {
	function __construct($config = 'rest') {
		parent ::__construct($config);
	}
	function customers_get() {
		$id = $this->get('id');
		if ($id) {
			$customer = $this->db->get_where('customer',
				array('customerID'=>$id))-result();
		}else {
			$customer = $this->db->get('customer')->result();
		}
	 // generate response
	 if($customer){
		$this->response($customer,200);
				}else{
			$this->response(array('status'=>'not found'), 404);
		}
	}

	function customers_post() {
		$params = array(
			'customerName' => $this->post('name'),
			'customerPhone' => $this->post('phone'),
			'customerCity' => $this->post('city'));
		 $process = $this->db->insert('customer', $params);
		 if($process){
			// 2-1 artinya Succesful creation of a resource.
			$this->response(array('status'=>'succes'),201);
		 }else{
			// 502 artinya Backend service failure (data store failure).
			return $this->response(array('status'=>'fail'), 502);
		}
		
	}

	function customers_put() {
		$params = array(
				'customerName'=> $this->put('name'),
				'customerPhone'=> $this->put('phone'),
				'customerCity'=> $this->put('city'));
		$this->db->where('customerID', $this->put('id'));
		$execute = $this->db->update('customer', $params);
		if($execute){
			$this->response(array('status'=>'succes'),201);
		}else{
			return $this0>response(array('status'=>'fail'), 502);	
		}	
	}
	

	function customers_delete() {
		$this->db->where('customerID', $this->delete('id'));
		$execute =$this->db->delete('customer');
		if($execute){
			$this->response(array('status'=>'succes'),201);
		}else{
			return $this->response(array('status'=>'fail'),502);
		}	
	}
}

