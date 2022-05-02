<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/*
*/
/*
*/
error_reporting(0);
class Profile extends CI_Controller
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
 	
 	public function edit(){

 		// print_r($_POST); exit;

		$this->form_validation->set_rules('name','Name','required');
 		$this->form_validation->set_rules('email','Email','required|valid_email');

 		if($this->form_validation->run()==true){

			$update['name'] = $this->input->post('name');
			$update['email'] = $this->input->post('email');

			$admin_id = $this->session->userdata('admin_id');


			$run = $this->common_model->UpdateData('admin',array('id' =>$admin_id), $update);
			//echo $this->db->last_query(); die;
			if($run){

				$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Your profile has been update successfully.</div>');
				$json['status']=1;
			} else {
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
				$json['status']=0;
			}

			
		} else {
			$json['message'] = $this->form_validation->error_array();
			$json['status']=0;
		}

		echo json_encode($json);

 	}
 	public function change_password(){
 		$admin_id = $this->session->userdata('admin_id');
		$admindata= $this->common_model->GetSingleData('admin',array('id'=>$admin_id));

 		$this->form_validation->set_rules('password','Current password','trim|required');
 		$this->form_validation->set_rules('npassword','New password','trim|required|min_length[6]');
 		$this->form_validation->set_rules('cpassword','Confirm password','trim|required|matches[npassword]');

 		if($this->form_validation->run()==true){

			$admin_pass = $this->input->post('password');
			$New_Password = $this->input->post('npassword');

 			if($admindata['password'] == $admin_pass){

 				$run = $this->common_model->UpdateData('admin',array('id' =>$admin_id), array('password' =>$New_Password));

 				if($run){
 					// $json['message']='<div class="alert alert-success">Success! Your password has been updated .</div>';
					$this->session->set_flashdata('msgs','<div class="alert alert-success">Success! Your password has been updated successfully.</div>');
					$json['status']=1;

				}else {
					$json['message']='<div class="alert alert-danger">Error! Something went wrong.</div>';
					$json['status']=0;
				}
 			}
 			else{
 				$json['messages']='<div class="alert alert-danger">Current password does not match.</div>';
				$json['status']=0;
 			}
 		}
 		else{
 			$json['message']=$this->form_validation->error_array();
			$json['status']=0;
 		}

 		echo json_encode($json);
 	}
 	public function index(){
 		$admin_id = $this->session->userdata('admin_id');
 		$data['data'] = $this->common_model->GetSingleData('admin', array('id'=>$admin_id));
		$this->load->view('admin/profile', $data);
	} 





   	public function logout(){
		session_destroy();
		$this->session->set_flashdata('msgs','<div class="alert alert-success">You logout successfully.</div>');
		redirect('admin');

	}


	public function viewUser($id='')
	{
             $data['user'] = $this->common_model->GetSingleData('users', array('id'=>$id));

		 $this->load->view('admin/view-user', $data);
		
	}





	public function country()
	{
		 $data['data'] = $this->common_model->GetAllData('country',array('status'=>1),'status','desc');
		 $this->load->view('admin/country-list', $data);
		 // echo "<pre>"; print_r($data['data']); exit();
		 
	}
	public function country_social_link()
	{
		 $data['data'] = $this->common_model->GetAllData('country',array('status'=>1),'status','desc');
		 $this->load->view('admin/country-social-list', $data);
	}


	public function changeStatus(){
		//print_r($_REQUEST); die;
		$id = $this->input->post('id');
		$update['status'] =$status = $this->input->post('status');
		
        $run = $this->common_model->UpdateData('country', array('id'=>$id),$update);
        //echo $this->db->last_query(); die;
        if($run)
        {
        	if($status==1)
        	{
               $active = "active";
        	}
        	else
        	{
               $active = "blocked";
        	}
			$this->session->set_flashdata('msgs','<div class="alert alert-success">Country has been '.$active.' successfully.</div>');	
			$json['status']=1;
		} else
		{
		    // $this->session->set_flashdata('msgs','<div class="alert alert-danger">Something is Worng.</div>');
		    $json['status']=0;
		    $json['message']='<div class="alert alert-danger">Something went worng.</div>';
		}

		//redirect('admin/user-list');
		echo json_encode($json);

	}
	public function EditCountry()
	{
		//echo "hello edit country";
		 $id = $this->uri->segment(4);
		 $this->form_validation->set_rules('facebook','facebook','trim|required');
		 $this->form_validation->set_rules('twitter','Twitter','trim|required');
		 $this->form_validation->set_rules('instagram','Instagram','trim|required');
		 $this->form_validation->set_rules('youtube','Youtube','trim|required');  
		 
		

		 if($this->form_validation->run()==true){				

		 	    $insert['facebook'] = $this->input->post('facebook');
				$insert['twitter'] = $this->input->post('twitter');
				$insert['instagram'] = $this->input->post('instagram');
				$insert['youtube'] = $this->input->post('youtube');

             $result = $this->common_model->GetSingleData('country_social_link', array('country_id'=>$id));
			if($result)
			{

				$run =  $this->common_model->UpdateData('country_social_link', array('country_id'=>$id),$insert);
			}
			else
			{

				$insert['country_id'] = $id;
				$run = $this->common_model->InsertData('country_social_link',$insert);

			}

			if($run)
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-success">Country Social Link has been Updated successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something went
				 wrong.</div>');
			}
 		}
 		else{
 			
 			$this->session->set_flashdata('msgs','<div class="alert alert-danger">'.validation_errors().'</div>');
 		}
			redirect('admin/social-country-list');
		

	}
	
	public function DeleteCountry()
	{
		$id = $this->uri->segment(4);
		$update['status'] = 0;
		$run = $this->common_model->UpdateData('country', array('id'=>$id), $update);
		if ($run) {
			$this->session->set_flashdata('msgs','<div class="alert alert-success">Country has been deleted successfully.</div>');
		} else {
			$this->session->set_flashdata('msgs','<div class="alert alert-danger">Something went
				 wrong.</div>');
		}

		redirect('admin/country-list');
	}

	public function AddCountry()
	{
 		$this->form_validation->set_rules('country_id','country ','trim|required');
 		$this->form_validation->set_rules('currency_code','Currency code ','trim|required');
 		$this->form_validation->set_rules('currency_sign','Currency sign ','trim|required');
		if($this->form_validation->run()==true){

		$country_id = $this->input->post('country_id');
		$currency_code = $this->input->post('currency_code');
		$currency_sign = $this->input->post('currency_sign');

		$run = $this->common_model->UpdateData('country', array('id'=>$country_id), array('status'=>1, 'currency_code'=>$currency_code, 'currency_sign'=>$currency_sign));

			if($run){

// echo $this->db->last_query(); exit();

			$this->session->set_flashdata('msgs','<div class="alert alert-success">Country has been updated successfully.</div>');
			$json['status']=1;

			} else {
			 $json['message']='<div class="alert alert-danger">Something went wrong.</div>';
			 $json['status']=0;
			}

		} else {
 			$json['message']='<div class="alert alert-danger">'.validation_errors().'</div>';
			$json['status']=0;
 		}

 		echo json_encode($json);
	}

	public function contact()
	{
	 	$data['data'] = $this->common_model->GetAllData('contactus','','id','desc');
	 	$this->load->view('admin/contact-us', $data);
	}


	public function DeleteContact()
	{
		$id = $this->uri->segment(4);
		$run = $this->common_model->DeleteData('contactus',array('id'=>$id));

		if ($run) {
		 $this->session->set_flashdata('msgs','<div class="alert alert-success">Contact has been deleted successfully.</div>');
		} else {
		 $this->session->set_flashdata('msgs','<div class="alert alert-danger">Something went wrong.</div>');	
		}
		redirect('admin/contact-us');
	}


	public function postJobList()
	{
		 
		// $this->db->select('*');
		// $this->db->from('employees');
		// $this->db->where('status','Active');
		// $this->db->group_by('name');
		// $this->db->get();

		// $this->db->select('*');
		// $this->db->from('post_job');
		// $this->db->where('post_job_image.post_job_id = post_job.id');
		// $data = $this->db->group_by('d.nom_dept')->get()->result();

// 		$this->db->select('post_job.id as pid, user_id, job_type, title, description, min_budget, max_budget, payment_method, post_job.created_at as post_job_date,  post_job_image.id as pimgId, image, post_job_id');
// $this->db->from('post_job');
// $this->db->join('post_job_image', 'post_job_image.post_job_id = post_job.id', 'left');
// $this->db->group_by('post_job_id');
// $query  = $this->db->get();
// $result = $query->result();
// echo "<pre>";
// print_r($result);





		// echo "<pre>"; print_r($data);

// exit;

		 $data['data'] = $this->common_model->GetAllData('post_job','','id','desc');
		 $this->load->view('admin/job-list', $data);
		 // echo "<pre>"; print_r($data['data']); exit();
		 
	}

}


 ?>