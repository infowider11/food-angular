<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Auth extends CI_Controller
{
	
	public function __construct() {
		parent::__construct();
		//$this->check_login();
		$language = $this->session->userdata('language');

		if ($language && $language == 'arabic') {
		 $this->lang->load('arabic_lang', 'arabic');	
		 $lang = "arb";
		} else {
		 $this->lang->load('english_lang', 'english');
		 $lang = "eng";
		} 
		
	}

	public function check_login(){
		if(!$this->session->userdata('user_id')){
			redirect('dashboard');
		}
	}			

	public function email_verification(){
		$user_id = $this->session->userdata('user_id');
		$data['user'] = $this->common_model->GetSingleData('users', array('id'=>$user_id));
		$this->load->view('site/email-verification',$data);
	}
	


	public function do_login()
	{
		$this->form_validation->set_rules('email','email','trim|required', array('required' => $this->lang->line('email_require')));
		$this->form_validation->set_rules('password','password','trim|required', array('required' => $this->lang->line('password_require')));

		if($this->form_validation->run()){
			//print_r($_REQUEST);
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$country_id = $this->input->post('country_id');
			$run = $this->common_model->GetSingleData('users', array('email'=>$email, 'password'=>$password));
			if ($run) {
				date_default_timezone_set($this->input->post('time_zone'));
				$insert['last_login_time'] = date('Y-m-d H:i:s');
				$insert['time_zone'] = $this->input->post('time_zone');
				$this->common_model->UpdateData('users', array('id'=>$run['id']) ,$insert);
			}

			if ($run && $run['country'] != $country_id) {

				$output['status'] = 0;
				$output['message'] = '<div class="alert alert-danger">'.$this->lang->line('country_wrong').'</div>';

			} else if ($run && $run['status'] == 1 && $run['email_verified'] == 1 && $run['country'] == $country_id) {

			    $this->session->set_userdata('user_id',$run['id']);
				 $output['status'] = 1;
				 $this->session->set_flashdata('msgs','<div class="alert alert-success">'.$this->lang->line('welcome').' : '.$run['name'].'</div>');	
			} else if ($run && $run['status'] == 0) {
				 $output['status'] = 0;
				 $output['message'] = '<div class="alert alert-danger">'.$this->lang->line('account_blocked').'</div>';
			} else if ($run && $run['status'] == 1 && $run['email_verified'] == 0) {
				 $output['status'] = 2;
			     $this->session->set_userdata('user_id',$run['id']);				
				 //redirect('');
			} else {
				$output['status'] = 0;
				$output['message'] = '<div class="alert alert-danger">'.$this->lang->line('user_invalid').'</div>';	
			}
		 }//end if form validation
		else {
			$output['status'] = 0;
			$output['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}//end else form validation
		echo json_encode($output);
	}
	

	public function action_email_verify()
	{
		    $id = $this->uri->segment(2);
		    $token = $this->uri->segment(3);

		    $run1 = $this->common_model->GetSingleData('users', array('id'=>$id));
		    

		    $run = $this->common_model->GetSingleData('users', array('id'=>$id,'token'=>$token));
		    if ($run1 && empty($run1['token'])) {
		    	//$this->session->set_userdata('user_id',$id);
		    	$this->session->set_flashdata('msgs','<div class="alert alert-danger">Your link has been expired.</div>');
					redirect('login');				
		    } else if ($run && $run['email_verified'] == 0) {
		    	 $update['email_verified'] = 1;
		    	 $update['token'] = '';
		    	 $run2 = $this->common_model->UpdateData('users', array('id'=>$id), $update);
		    	 //$this->session->set_userdata('user_id',$id);
		    	 $this->session->set_flashdata('msgs','<div class="alert alert-success">Your account has been verified successfully</div>');
		    	 if(!$this->session->userdata('user_id')){
					redirect('login');
				} else if ($this->session->userdata('user_id')) {
			    	redirect('profile');
 				}
		    	 //redirect('login');
		    } else {
		    	$this->session->set_flashdata('msgs','<div class="alert alert-danger">Your account does not exist. Kindly signup.</div>');
		    	redirect('signup');
		    }
	}


	public function VerifyOtp() {
			$this->form_validation->set_rules('otp','otp','required|trim', array('required' => $this->lang->line('otp_required')));
			if($this->form_validation->run()){
			$otp = $this->input->post('otp');
			$user_id =$this->session->userdata('user_id');
			$run = $this->common_model->GetSingleData('users', array('id'=>$user_id, 'token'=>$otp));
			//echo $this->db->last_query(); die;
					if ($run) {
						 $update['email_verified'] = 1;
				    	 $update['token'] = '';
				    	 $run2 = $this->common_model->UpdateData('users', array('id'=>$user_id), $update);
						 $this->session->set_userdata('user_id',$run['id']);				    	 
						 $this->session->set_flashdata('msgs','<div class="alert alert-success">'.$this->lang->line('account_verified').'</div>');
						 redirect('profile');
					} else {
						$this->session->set_flashdata('msgs','<div class="alert alert-danger">'.$this->lang->line('otp_invalid').'</div>');
						 redirect('email-verification');
					}

			} else { 
				$this->session->set_flashdata('msgs','<div class="alert alert-danger">'.validation_errors().'</div>');
			}
			redirect('email-verification');
			 
		}

	
}

?>