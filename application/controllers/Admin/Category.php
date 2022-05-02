<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Category extends CI_Controller
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

	public function category_list(){
		
		$data['category'] = $this->common_model->GetAllData('category','','id','desc');

		$this->load->view('admin/category-list', $data);
	}

	public function add_category(){
		
		$this->form_validation->set_rules('title','Category Name', 'required|trim');

		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$insert['title'] = $this->input->post('title');

			$run = $this->common_model->InsertData('category', $insert);
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Category has beed added successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function update_category(){
		
		$this->form_validation->set_rules('title','Category Name', 'required|trim');


		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$id = $this->input->post('id');
			$update['title'] = $this->input->post('title');
			$run = $this->common_model->UpdateData('category',array('id'=>$id), $update);
			if($run)
			{	
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Category has beed updated successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function delete_category(){
		
		
			$id = $this->input->post('id');
			
			$run = $this->common_model->DeleteData('category',array('id'=>$id));
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Category has beed deleted successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		echo json_encode($json);
	}
		
}

