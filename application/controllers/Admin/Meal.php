<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Meal extends CI_Controller
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
		
		$data['meal'] = $this->common_model->GetAllData('meal_type','','id','desc');

		$this->load->view('admin/meal-type-list', $data);
	}

	

	public function update_meal_type(){
		
		$this->form_validation->set_rules('title','Meal type', 'required|trim');


		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$id = $this->input->post('id');
			$update['title'] = $this->input->post('title');
			$run = $this->common_model->UpdateData('meal_type',array('id'=>$id), $update);
			if($run)
			{	
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Meal type has beed updated successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function delete_meal_type(){
		
		
			$id = $this->input->post('id');
			
			$run = $this->common_model->DeleteData('meal_type',array('id'=>$id));
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Meal type has beed deleted successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		echo json_encode($json);
	}

	public function meal_list()
	{
		$data['meals'] = $this->common_model->GetAllData('meals','','id','desc');

		$this->load->view('admin/meals-list', $data);
	}

	public function add_meals()
	{
		$this->load->view('admin/add-meal');
	}
		
	public function addMeal(){
		
		$this->form_validation->set_rules('name','Name', 'required|trim');
		$this->form_validation->set_rules('heading','Heading', 'required|trim');
		$this->form_validation->set_rules('price','Price', 'required|trim|numeric');
		$this->form_validation->set_rules('category','Category', 'required|trim');
		$this->form_validation->set_rules('meal_type','Meal type', 'required|trim');
		$this->form_validation->set_rules('area_group','Area Group', 'required|trim');
		$this->form_validation->set_rules('short_description','Short Description ', 'required|trim');
		$this->form_validation->set_rules('maximum_order_per_day','Maximum Orders Per day ', 'required|trim');
		$this->form_validation->set_rules('detail_description','Detail Description', 'required|trim');

		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$insert['name'] = $this->input->post('name');
			$insert['heading'] = $this->input->post('heading');
			$insert['price'] = $this->input->post('price');
			$insert['category'] = $this->input->post('category');
			$insert['meal_type'] = $this->input->post('meal_type');
			$insert['area_group'] = $this->input->post('area_group');
			$insert['short_description'] = $this->input->post('short_description');
			$insert['detail_description'] = $this->input->post('detail_description');
			$insert['maximum_order_per_day'] = $this->input->post('maximum_order_per_day');
			$insert['disabled_days'] = implode(',',$this->input->post('disabled_days'));
			if(isset($_REQUEST['is_enabled']))
			{
				$insert['is_enabled'] = $this->input->post('is_enabled');
			}
			else{
				$insert['is_enabled'] = 0;
			}
			if(isset($_REQUEST['is_taking']))
			{
				$insert['is_taking'] = $this->input->post('is_taking');
			}
			else{
				$insert['is_taking'] = 0;
			}
			if(isset($_REQUEST['disabled_dates']))
			{
				$insert['disabled_dates'] = $this->input->post('disabled_dates');
			}

			$run = $this->common_model->InsertData('meals', $insert);
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
                        		$imgarray=array('meal_id' =>$run, 'image'=>$fileName );
                       			 $run2=$this->common_model->InsertData('meal_images',$imgarray);
                       		}
                       		else
                       		{
                      
                      
                       		}
                      
                    	}
                	}    
              	}
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Meal has beed added successfully.</div>');
				$json['status']=1;
				$json['redirect']=base_url().'admin/meal-list';
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}	

	public function updateMeal(){
		
		$this->form_validation->set_rules('name','Name', 'required|trim');
		$this->form_validation->set_rules('heading','Heading', 'required|trim');
		$this->form_validation->set_rules('price','Price', 'required|trim|numeric');
		$this->form_validation->set_rules('category','Category', 'required|trim');
		$this->form_validation->set_rules('meal_type','Meal type', 'required|trim');
		$this->form_validation->set_rules('area_group','Area Group', 'required|trim');
		$this->form_validation->set_rules('short_description','Short Description ', 'required|trim');
		$this->form_validation->set_rules('maximum_order_per_day','Maximum Orders Per day ', 'required|trim');
		$this->form_validation->set_rules('detail_description','Detail Description', 'required|trim');

		if($this->form_validation->run()==false)
		{
			$json['status'] = 0;
			$json['message'] = $this->form_validation->error_array();
		} else {
			$id= $this->input->post('id');
			$insert['name'] = $this->input->post('name');
			$insert['heading'] = $this->input->post('heading');
			$insert['price'] = $this->input->post('price');
			$insert['category'] = $this->input->post('category');
			$insert['meal_type'] = $this->input->post('meal_type');
			$insert['area_group'] = $this->input->post('area_group');
			$insert['short_description'] = $this->input->post('short_description');
			$insert['detail_description'] = $this->input->post('detail_description');
			$insert['disabled_days'] = implode(',',$this->input->post('disabled_days'));
			$insert['maximum_order_per_day'] = $this->input->post('maximum_order_per_day');
			if(isset($_REQUEST['is_enabled']))
			{
				$insert['is_enabled'] = $this->input->post('is_enabled');
			}
			else{
				$insert['is_enabled'] = 0;
			}
			if(isset($_REQUEST['is_taking']))
			{
				$insert['is_taking'] = $this->input->post('is_taking');
			}
			else{
				$insert['is_taking'] = 0;
			}
			if(isset($_REQUEST['disabled_dates']))
			{
				$insert['disabled_dates'] = $this->input->post('disabled_dates');
			}

			$run = $this->common_model->UpdateData('meals',array('id'=>$id), $insert);
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
                        		$imgarray=array('meal_id' =>$id, 'image'=>$fileName );
                       			 $run2=$this->common_model->InsertData('meal_images',$imgarray);
                       		}
                       		else
                       		{
                      
                      
                       		}
                      
                    	}
                	}    
              	}
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Meal has beed added successfully.</div>');
				$json['status']=1;
				$json['redirect']=base_url().'admin/meal-list';
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		}
		echo json_encode($json);
	}

	public function delete_meal(){
		
		
			$id = $this->input->post('id');
			
			$run = $this->common_model->DeleteData('meals',array('id'=>$id));
			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Meal has beed deleted successfully.</div>');
				$json['status']=1;
			}  else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

		echo json_encode($json);
	}

	public function edit_meal($id)
	{
		$data['mealData'] = $this->common_model->GetSingleData('meals', array('id'=>$id));
		$this->load->view('admin/edit-meal', $data);
	}
	public function deleteImg($id) {        
        
        $run = $this->common_model->DeleteData('meal_images', array('id'=> $id));
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

