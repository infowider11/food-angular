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
		
		$today = date('Y-m-d');		

		$this->load->view('admin/dashboard', $data);
	}
		
}

?>