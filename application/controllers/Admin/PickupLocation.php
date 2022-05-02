<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class PickupLocation extends CI_Controller
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
		
		$data['pickup'] = $this->common_model->GetAllData('pickup_location','','id','desc');		

		$this->load->view('admin/pickup-list', $data);
	}

	

	public function update_location(){
		
		$this->form_validation->set_rules('location_name','Location Name', 'required|trim');
		$this->form_validation->set_rules('location_description','Location Description', 'required|trim');
		$this->form_validation->set_rules('location_address','Location Address', 'required|trim');
		$this->form_validation->set_rules('location_postcode','Location Postcode', 'required|trim');

		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$id = $this->input->post('id');
			$update['location_name'] = $this->input->post('location_name');
			$update['location_description'] = $this->input->post('location_description');
			$update['location_address'] = $this->input->post('location_address');
			$update['location_postcode'] = $this->input->post('location_postcode');
			$update['area_group_id'] = $this->input->post('area_group_id');

			$run = $this->common_model->UpdateData('pickup_location',array('id'=>$id), $update);
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Location has beed updated successfully.</div>');
				$json['status']=1;
				$json['redirect']=base_url().'admin/pickup-location-list';
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}
	public function add_loaction(){
		
		$this->form_validation->set_rules('location_name','Location Name', 'required|trim');
		$this->form_validation->set_rules('location_description','Location Description', 'required|trim');
		$this->form_validation->set_rules('location_address','Location Address', 'required|trim');
		$this->form_validation->set_rules('location_postcode','Location Postcode', 'required|trim');

		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$insert['location_name'] = $this->input->post('location_name');
			$insert['location_description'] = $this->input->post('location_description');
			$insert['location_address'] = $this->input->post('location_address');
			$insert['location_postcode'] = $this->input->post('location_postcode');
			$insert['area_group_id'] = $this->input->post('area_group_id');
			$run = $this->common_model->InsertData('pickup_location', $insert);
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Location has beed added successfully.</div>');
				$json['status']=1;
				$json['redirect']=base_url().'admin/pickup-location-list';
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function delete_location(){
		
		
			$id = $this->input->post('id');
			
			$run = $this->common_model->DeleteData('pickup_location',array('id'=>$id));
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Location has beed deleted successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		echo json_encode($json);
	}
		
}

