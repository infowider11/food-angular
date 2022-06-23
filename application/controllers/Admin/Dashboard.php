<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Dashboard extends CI_Controller
{
	
	public function __construct() {
		parent::__construct();
		$this->check_login();
		
	}

	public function check_login(){
		if(!$this->session->userdata('admin_id')){
			redirect('admin');
		}
	}			

	public function index(){
		
		$data['users'] = $this->common_model->GetAllData('users','','id','desc');		
		$data['total_order'] = $this->common_model->GetAllData('orders','','id','desc');		
		$data['complete_order'] = $this->common_model->GetAllData('orders',array('status'=>1),'id','desc');		
		$data['pending_order'] = $this->common_model->GetAllData('orders',array('status'=>0),'id','desc');
		$data['pickup_location'] = $this->common_model->GetAllData('pickup_location','','id','desc');
		$where = 'status = 1';
		$data["complete_order_revenue"] = $this->common_model->GetColumnName('orders',$where,array('SUM(grand_total) as total_price')); 
	    $where = 'status = 0';
		$data["pending_order_revenue"] = $this->common_model->GetColumnName('orders',$where,array('SUM(grand_total) as total_price')); 

		$data["total_order_revenue"] = $this->common_model->GetColumnName('orders','',array('SUM(grand_total) as total_price')); 

		$this->load->view('admin/dashboard', $data);
	}
		
}

?>