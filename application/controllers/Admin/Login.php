<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
  public function __construct() {
    parent::__construct();
		$this->check_login();
    $this->db->query("set sql_mode = ''");
  }
	
	public function check_login(){
		if($this->session->userdata('admin_id')){
			redirect('admin/dashboard');
		}
	}
	
	public function index(){
		$this->load->view('admin/log-in');
	}

	public function do_login(){
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');

		if($this->form_validation->run()==true){

			$email = $this->input->post('email');
			$password = $this->input->post('password');
          // echo "hffffffg";die;
         
			$run = $this->common_model->GetSingleData('admin',array('email'=>$email,'password'=>$password));
		 if($run){							
					$this->session->set_userdata('admin_id',$run['id']);
					$this->session->set_userdata('admin_name',$run['name']);
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Welcome '.$run['name'].'</div>');
					redirect('admin/dashboard');
                 //echo $this->session->userdata('admin_id');
			} else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Email or Password is incorrect.</div>');
				redirect('Admin/login');
			}

			
		} else {
			$this->session->set_flashdata('msgs','<div class="alert alert-danger">'.validation_errors().'</div>');
			redirect('Admin/login');
		}


	}

	
	

}
	