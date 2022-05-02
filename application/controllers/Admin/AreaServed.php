<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class AreaServed extends CI_Controller
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
		
		$data['area'] = $this->common_model->GetAllData('area_served','','id','desc');

		$this->load->view('admin/area-list', $data);
	}

	public function edit($id){
		
		$data['single_data'] = $this->common_model->GetSingleData('area_served',array('id'=>$id));		

		$this->load->view('admin/area-edit', $data);
	}

	public function add(){		

		$this->load->view('admin/area-add');
	}

	public function add_area(){
		
		$this->form_validation->set_rules('area_name','Area Name', 'required|trim');
		$this->form_validation->set_rules('area_post_code','Area Zipcode', 'required|trim');
		$this->form_validation->set_rules('area_group','Area Group', 'required|trim');
		$this->form_validation->set_rules('location_heading','Banner Heading', 'required|trim');
		$this->form_validation->set_rules('location_description','Banner Description', 'required|trim');

		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$insert['area_name'] = $this->input->post('area_name');
			$insert['area_post_code'] = $this->input->post('area_post_code');
			$insert['area_group'] = $this->input->post('area_group');
			$insert['location_heading'] = $this->input->post('location_heading');
			$insert['location_description'] = $this->input->post('location_description');
			$insert['has_pickup'] = $this->input->post('has_pickup');
			$insert['has_home_delivery'] = $this->input->post('has_home_delivery');
			if(!empty($_FILES['banner']['name'])) {
				$newName = $_FILES['banner']['name'];
				$ext =$newName;
		        	$fileName = 'assets/admin/image/'.rand().time().'.'.$ext;
		        	 move_uploaded_file($_FILES['banner']['tmp_name'], $fileName);
		        $insert['location_background_image']=$fileName ;
	        }

			$run = $this->common_model->InsertData('area_served', $insert);
			if($run)
			{
				if(!empty($_FILES['image']['name']))
              	{
                	$count = count($_FILES['image']['name']);
                	for($i=0;$i<$count;$i++)
                	{
                    	if(!empty($_FILES['image']['name'][$i]))
                    	{
                      		$newName = explode('.',$_FILES['image']['name'][$i]);
                      		$ext =end($newName);
                      		$fileName = 'assets/admin/image' . rand() . time() . '.' . $ext;
                       		if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $fileName)){
                        		$imgarray=array('area_group_id' =>$run, 'image'=>$fileName );
                       			 $run2=$this->common_model->InsertData('location_image',$imgarray);
                       		}
                       		else
                       		{
                      
                      
                       		}
                      
                    	}
                	}    
              	}
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Area has beed added successfully.</div>');
				$json['status']=1;
				$json['redirect']= base_url().'admin/area-served-list';
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function update_area(){
		
		$this->form_validation->set_rules('area_name','Area Name', 'required|trim');
		$this->form_validation->set_rules('area_post_code','Area Postcode', 'required|trim');
		$this->form_validation->set_rules('area_group','Area Group', 'required|trim');
		$this->form_validation->set_rules('location_heading','Banner Heading', 'required|trim');
		$this->form_validation->set_rules('location_description','Banner Description', 'required|trim');


		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$id = $this->input->post('id');
			$img_id = $this->input->post('image_id');
			$update['area_name'] = $this->input->post('area_name');
			$update['area_post_code'] = $this->input->post('area_post_code');
			$update['area_group'] = $this->input->post('area_group');
			$update['location_heading'] = $this->input->post('location_heading');
			$update['location_description'] = $this->input->post('location_description');
			$update['has_pickup'] = $this->input->post('has_pickup');
			$update['has_home_delivery'] = $this->input->post('has_home_delivery');
			if(!empty($_FILES['banner']['name'])) {
				$newName = $_FILES['banner']['name'];
				$ext =$newName;
		        	$fileName = 'assets/admin/image/'.rand().time().'.'.$ext;
		        	 move_uploaded_file($_FILES['banner']['tmp_name'], $fileName);
		        $update['location_background_image']=$fileName ;
	        }

			$run = $this->common_model->UpdateData('area_served',array('id'=>$id), $update);
			if($run)
			{	
				if(!empty($_FILES['image']['name']))
              	{
                	$count = count($_FILES['image']['name']);
                	for($i=0;$i<$count;$i++)
                	{
                    	if(!empty($_FILES['image']['name'][$i]))
                    	{
                      		$newName = explode('.',$_FILES['image']['name'][$i]);
                      		$ext =end($newName);
                      		$fileName = 'assets/admin/image' . rand() . time() . '.' . $ext;
                       		if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $fileName)){
                        		$imgarray=array('area_group_id' =>$id, 'image'=>$fileName );
                       			 $run2=$this->common_model->InsertData('location_image', $imgarray);
                       		}
                       		else
                       		{
                      
                      
                       		}
                      
                    	}
                	}    
              	}
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Area has beed updated successfully.</div>');
				$json['status']=1;
				$json['redirect']= base_url().'admin/area-served-list';
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function delete_area(){
		
		
			$id = $this->input->post('id');
			
			$run = $this->common_model->DeleteData('area_served',array('id'=>$id));
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Area has beed deleted successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		echo json_encode($json);
	}

	public function deleteImg($id) {        
        
        $run = $this->common_model->DeleteData('location_image', array('id'=> $id));
        if ($run) {
            $json['message'] = 'Success! Image has been Deleted successfully';
            $json['status'] = 1;
        } else {
            $json['message'] = 'Error! Something went wrong';
            $json['status'] = 0;
        }
        echo json_encode($json);
    }
		
}

