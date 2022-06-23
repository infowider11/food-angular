<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

  public function __construct() {
    parent::__construct();
		$this->check_login();
		header("Access-Control-Allow-Origin:*");
    $this->db->query("set sql_mode = ''");


  }
	
	public function check_login(){
		/*if($this->session->userdata('user_id')){
			$user_id =$this->session->userdata('user_id');
			$user_data = $this->common_model->GetSingleData('users', array('id'=>$user_id));
			if ($user_data['email_verified']==0) {			 
				redirect('email-verification');
				die;
			}
		}*/
		if(!$this->session->userdata('admin_id')){
			redirect('admin');
		}
	}
	
	public function index(){

		$data['main_content'] = $this->common_model->GetAllData('home_content','','id','desc');
		$this->load->view('admin/main-content', $data);
	}

	public function edit_content()
	{
		$id=1;
		$data['mainContent'] = $this->common_model->GetSingleData('home_content',array('id'=>$id));
		$this->load->view('admin/edit-main-content', $data);
	}


	public function update_content() {

        $this->form_validation->set_rules('main_heading', 'Heading', 'required|trim');
        $this->form_validation->set_rules('main_description', 'Description', 'required|trim');

        if ($this->form_validation->run() == true) {
        	$id = 1;
            $update['main_heading'] = $this->input->post('main_heading');
            $update['main_description'] = $this->input->post('main_description');
            if(!empty($_FILES['banner']['name'])) {
				$newName = $_FILES['banner']['name'];
				$ext = $newName;
		        	$fileName = 'assets/admin/image/'.rand().time().'.'.$ext;
		        	 move_uploaded_file($_FILES['banner']['tmp_name'], $fileName);
		        $update['background_image']=$fileName ;
	        }
            
            $run = $this->common_model->UpdateData('home_content',array('id'=>$id),  $update);
            //echo $run; die;
            if ($run) {
             
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Content has been updated successfully.</div>');
                $json['status'] = 1;
                $json['redirect'] =base_url().'admin/main-page-content';
            } else {
                $json['message'] = '<div class="alert alert-danger">Error! Something went wrong.</div>';
                $json['status'] = 0;
            }
            
        } else {
            $json['message'] = $this->form_validation->error_array();
            $json['status'] = 0;
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


	public function edit_home_content()
	{
		$id=1;
		$data['homeContent'] = $this->common_model->GetSingleData('why_order_content',array('id'=>$id));
		$this->load->view('admin/home-content', $data);
	}

    public function update__home_content() {

        $this->form_validation->set_rules('title', 'Heading', 'required|trim');
        $this->form_validation->set_rules('subheading', 'Sub Heading', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if ($this->form_validation->run() == true) {
        	$id = 1;
            $update['title'] = $this->input->post('title');
            $update['subheading'] = $this->input->post('subheading');
            $update['description'] = $this->input->post('description');
            if(!empty($_FILES['banner']['name'])) {
				$newName = $_FILES['banner']['name'];
				$ext = $newName;
		        	$fileName = 'assets/admin/image/'.rand().time().'.'.$ext;
		        	 move_uploaded_file($_FILES['banner']['tmp_name'], $fileName);
		        $update['image']=$fileName ;
	        }
            
            $run = $this->common_model->UpdateData('why_order_content',array('id'=>$id),  $update);
            //echo $run; die;
            if ($run) {
             
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Content has been updated successfully.</div>');
                $json['status'] = 1;
                $json['redirect'] =base_url().'admin/home-page-content';
            } else {
                $json['message'] = '<div class="alert alert-danger">Error! Something went wrong.</div>';
                $json['status'] = 0;
            }
            
        } else {
            $json['message'] = $this->form_validation->error_array();
            $json['status'] = 0;
        }
    
        echo json_encode($json);
    }

    public function edit_inner_content()
	{
		$id=1;
		$data['innerContent'] = $this->common_model->GetSingleData('inner_content',array('id'=>$id));
		$this->load->view('admin/inner-content', $data);
	}

	public function update__inner_content()
	{
		if (isset($_REQUEST['privacy'])) {
		    $this->form_validation->set_rules('privacy', 'Privacy', 'trim|required');
		} 
		if(isset($_REQUEST['about']))
		{
			$this->form_validation->set_rules('about', 'About', 'trim|required');
		}
		if(isset($_REQUEST['terms']))
		{
			$this->form_validation->set_rules('terms', 'Terms', 'trim|required');
		}   
		    
		    if ($this->form_validation->run() == true) {
		        $insert['updated_at'] = date('Y-m-d H:i:s');
		            
		        if (isset($_REQUEST['privacy'])) {
		            $insert['privacy'] = $this->input->post('privacy');
		        }
		        if (isset($_REQUEST['about'])) {
		            $insert['about'] = $this->input->post('about');
		        }
		        if (isset($_REQUEST['terms'])) {
		            $insert['terms'] = $this->input->post('terms');
		        }

		        $run = $this->common_model->UpdateData('inner_content', array('id' => 1), $insert);
		            //echo $this->db->last_query();
		        $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! data  has been updated successfully.</div>');
		        $output['status'] = 1;
		            
		    } else {
		        $output['status'] = 0;
		        $output['message'] = $this->form_validation->error_array();
		    }
		 	
        echo json_encode($output);
	}

	public function contact_details()
	{
		$data['contact'] = $this->common_model->GetSingleData('contact_details',array('id'=>1));
		$this->load->view('admin/contact-details', $data);
	}
	public function update_contact()
	{
		$this->form_validation->set_rules('phone_1', 'Phone Number(first)', 'required|trim|numeric');
		$this->form_validation->set_rules('phone_2', 'Phone Number(second)', 'trim|numeric');
		$this->form_validation->set_rules('phone_3', 'Phone Number(third)', 'trim|alpha_numeric');
        $this->form_validation->set_rules('email_1', 'Email(first)', 'required|trim|valid_email');
        $this->form_validation->set_rules('email_2', 'Email(second)', 'trim|valid_email');
        $this->form_validation->set_rules('email_3', 'Email(third)', 'trim|valid_email');

        if ($this->form_validation->run() == true) {
            $update['phone_1'] = $this->input->post('phone_1');
            if (isset($_REQUEST['phone_2'])) {
            	$update['phone_2'] = $this->input->post('phone_2');
            }
            if (isset($_REQUEST['phone_3'])) {
            	$update['phone_3'] = $this->input->post('phone_3');
            }
            $update['email_1'] = $this->input->post('email_1');
            if (isset($_REQUEST['email_2'])) {
            	$update['email_2'] = $this->input->post('email_2');
            }
            if (isset($_REQUEST['email_3'])) {
            	$update['email_3'] = $this->input->post('email_3');
            }
            
            $run = $this->common_model->UpdateData('contact_details',array('id'=>1),  $update);
            //echo $run; die;
            if ($run) {
             
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Contact Details has been updated successfully.</div>');
                $json['status'] = 1;
            } else {
                $json['message'] = '<div class="alert alert-danger">Error! Something went wrong.</div>';
                $json['status'] = 0;
            }
            
        } else {
            $json['message'] = $this->form_validation->error_array();
            $json['status'] = 0;
        }
    
        echo json_encode($json);
	}

	public function contact_list()
	{
		$data['contact_data'] = $this->common_model->GetAllData('contact_request');
		$this->load->view('admin/contact-list', $data);
	}

	public function setting_management()
	{
		$data['setting'] = $this->common_model->GetSingleData('settings',array('id'=>1));
		$this->load->view('admin/setting-management', $data);
	}


	public function update_setting()
	{
		$this->form_validation->set_rules('transaction', 'Comission', 'required|trim');
		$this->form_validation->set_rules('tax', 'tax', 'required|trim');
		$this->form_validation->set_rules('delivery_fee', 'delivery fee', 'required|trim');

        if ($this->form_validation->run() == true) {
            $update['transaction'] = $this->input->post('transaction');
            $update['tax'] = $this->input->post('tax');
            $update['delivery_fee'] = $this->input->post('delivery_fee');
            
            $run = $this->common_model->UpdateData('settings',array('id'=>1),  $update);
            //echo $run; die;
            if ($run) {
             
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Commission has been updated successfully.</div>');
                $json['status'] = 1;
            } else {
                $json['message'] = '<div class="alert alert-danger">Error! Something went wrong.</div>';
                $json['status'] = 0;
            }
            
        } else {
            $json['message'] = $this->form_validation->error_array();
            $json['status'] = 0;
        }
    
        echo json_encode($json);
	}


	public function sameday_delivery()
	{
		$data['sameday'] = $this->common_model->GetAllData('contact_for_sameday','','id','desc');
		$this->load->view('admin/sameday-delivery', $data);
	}


}
	