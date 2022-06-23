<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User extends CI_Controller
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

	public function user_list(){
		
		$data['user_list'] = $this->common_model->GetAllData('users','','id','desc');

		$this->load->view('admin/user-list', $data);
	}

	 public function block_unblock()
    {
        //echo "hello";
            
            $id = $this->input->post('id');
            $status =  $update['status'] = $this->input->post('status');  

            if($status == 1)
            {
                $status = 'Active';
            }else{
                   $status = 'Block';
            }       
            
            $run = $this->common_model->UpdateData('users',array('id'=>$id), $update);

            if($run)
            {  
                   
				$this->session->set_flashdata('msgs','<div class="alert alert-success">User has been '.$status.' successfully.</div>');
             
                $output['message']='Users has been '.$status.' successfully' ;
                $output['status']= 1 ;                               

            }
            else 
            {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ;  
            
            }
         
         echo json_encode($output);
      
    }
    public function address_view($id){
		
		$data['address_list'] = $this->common_model->GetAllData('user_address','','id','desc');

		$this->load->view('admin/user-address-list', $data);
	}

	public function update_address(){
		$this->form_validation->set_rules('delivery_title','Title', 'required|trim');
		$this->form_validation->set_rules('delivery_name','Delivery Person Name', 'required|trim');
		$this->form_validation->set_rules('delivery_email','Delivery Person Email', 'required|trim');
		$this->form_validation->set_rules('delivery_phone','Delivery Person Phone', 'required|trim');
		$this->form_validation->set_rules('delivery_add','Delivery Address', 'required|trim');
		
		$this->form_validation->set_rules('delivery_remark','Remark', 'required|trim');
		
		


		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$id = $this->input->post('id');
			$update['delivery_address'] = $this->input->post('delivery_add');
			$update['delivery_email'] = $this->input->post('delivery_email');
			$update['delivery_phone'] = $this->input->post('delivery_phone');
			$update['delivery_remark'] = $this->input->post('delivery_remark');
			$update['delivery_name'] = $this->input->post('delivery_name');
			$update['delivery_title'] = $this->input->post('delivery_title');
			$run = $this->common_model->UpdateData('user_address',array('id'=>$id), $update);
			if($run)
			{	
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Users Address has beed updated successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function delete_address(){
		
		
			$id = $this->input->post('id');
			
			$run = $this->common_model->DeleteData('user_address',array('id'=>$id));
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Users Address has beed deleted successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		echo json_encode($json);
	}

	/*public function add_category(){
		
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
	}*/
		
}

