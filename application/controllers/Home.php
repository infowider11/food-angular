<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
  public function __construct() {
    parent::__construct();
		//$this->check_login();
		header("Access-Control-Allow-Origin:*");
    $this->db->query("set sql_mode = ''");
  

  }
	
	public function check_login(){
		if($this->session->userdata('user_id')){
			$user_id =$this->session->userdata('user_id');
			$user_data = $this->common_model->GetSingleData('users', array('id'=>$user_id));
			if ($user_data['email_verified']==0) {			 
				redirect('email-verification');
				die;
			}
		}
	}
	
	public function index(){
		// $data['category'] = $this->common_model->GetAllData('category', array('status'=>1, 'category_id'=>0), 'serial', 'asc');
		// $current_date = date("Y-m-d");
		// $where = "is_featured=1 and status=1 and is_deleted=0 and DATE(featured_end_date) > DATE('".$current_date."')";
		// $data['featured'] = $this->common_model->GetAllData('ads_posts', $where, 'id','desc', 10);
		// $data['recent_ads'] = $this->common_model->GetAllData('ads_posts', array('status'=>1, 'is_deleted'=>0), 'id','desc', 4);
		// $data['popular_ads'] = $this->common_model->GetAllData('ads_posts', array('status'=>1, 'is_deleted'=>0, 'is_popular'=>1), 'id','desc', 4);
		// $data['hot_ads'] = $this->common_model->GetAllData('ads_posts', array('status'=>1, 'is_deleted'=>0, 'is_hot'=>1), 'id','desc', 4);
		// $data['tranding_ads'] = $this->common_model->GetAllData('ads_posts', array('status'=>1, 'is_deleted'=>0, 'is_tranding'=>1), 'id','desc', 4);

		//echo $this->db->last_query(); die;
		//$this->load->view('site/sign-up');
	}

	public function categories()
	{
		$data['category'] = $this->common_model->GetAllData('category', array('status'=>1, 'category_id'=>0), 'serial', 'asc');
		$data['getCategory'] = false;
		$current_date = date("Y-m-d");
		$where = "status=1 and is_deleted=0 and DATE(end_date) > DATE('".$current_date."')";
		if (isset($_REQUEST['category']) && !empty($_REQUEST['category'])) {
			 $where .= " and category_id=".$_REQUEST['category']." ";
		} 

		if (isset($_REQUEST['sub_category']) && !empty($_REQUEST['sub_category'])) {
			 $where .= " and sub_category_id=".$_REQUEST['sub_category']." ";
			 $data['getCategory'] = $this->common_model->GetSingleData('category', array('id'=>$_REQUEST['sub_category']));
		}

		if (isset($_REQUEST['country']) && !empty($_REQUEST['country'])) {
			 $where .= " and country_id=".$_REQUEST['country']." ";
		}

		if (isset($_REQUEST['new']) && !empty($_REQUEST['new']) && isset($_REQUEST['used']) && !empty($_REQUEST['used'])) {
			 $where .= " and (itemCon=".$_REQUEST['new']." or itemCon=".$_REQUEST['used'].")";
		} else if (isset($_REQUEST['new']) && !empty($_REQUEST['new'])) {
			 $where .= " and itemCon=".$_REQUEST['new']." ";
		} else if (isset($_REQUEST['used']) && !empty($_REQUEST['used'])) {
			 $where .= " and itemCon=".$_REQUEST['used']." ";
		}


		if (isset($_REQUEST['user_type']) && !empty($_REQUEST['user_type'])) {
			//print($_REQUEST['user_type']); die;
				$where .= "and (";
			foreach ($_REQUEST['user_type'] as $key => $value) {
				//echo $value."<br>";

							if ($key > 0) {
								 $where .= " or ";
							}

			 $where .= " ((SELECT COUNT(id) FROM users WHERE users.id=ads_posts.user_id and users.user_type=".$value.")>0)";
			}
				$where .= ")";
		}

		if (isset($_REQUEST['keywords']) && !empty($_REQUEST['keywords'])) {
			 $where .= " and ( ";
			 			$parts = explode(' ', $_REQUEST['keywords']);
			 			foreach ($parts as $key => $value) {
			 				 if ($key > 0) {
									$where .= " or ";
			 				 	}
			 				$where .= " title like '%".$value."%' or description like '%".$value."%' or brand like '%".$value."%' or model like '%".$value."%' ";
			 			}
			 $where .= " )";
		}

		$data['ads_data'] = $this->common_model->GetAllData('ads_posts', $where,'id','desc');
		 //echo $this->db->last_query();
		$this->load->view('site/categories', $data);		
	}

	
	public function pricing()
	{
		$where = "status=1";

		if ($this->session->userdata('countryId')) {
		$countryId = $this->session->userdata('countryId');
			 $where .= " and country_id=".$countryId."";
		} else {
			 $where .= " and country_id=63";			
		}
		$data['data'] = $this->common_model->GetAllData('plans', $where,'id','desc');
		$this->load->view('site/pricing', $data);		
	}

	public function login()
	{
		$this->load->view('site/login');		
	}

	public function register()
	{
		$countryId = $this->session->userdata('countryId');
		$data['country'] = $this->common_model->GetSingleData('country', array('id'=>$countryId));
		$this->load->view('site/register', $data);		
	}


	public function aboutus()
	{
		$data['content1'] = $this->common_model->GetSingleData('about_content', array('id'=>1));
		$data['content2'] = $this->common_model->GetSingleData('about_content', array('id'=>2));
		$data['content3'] = $this->common_model->GetSingleData('about_content', array('id'=>3));
		$data['content4'] = $this->common_model->GetSingleData('about_content', array('id'=>4));

		$data['team'] = $this->common_model->GetAllData('team', '','id','asc');
		$data['testimonial'] = $this->common_model->GetAllData('testti_moniyal', '','id','asc');

		$this->load->view('site/aboutus', $data);		
	}

	public function contactus()
	{
		$data['contact'] = $this->common_model->GetSingleData('footer', array('id'=>1));
		$this->load->view('site/contactus', $data);		
	}


	public function faq()
	{
		$data['data'] = $this->common_model->GetAllData('faq','','id','desc');
		$this->load->view('site/faq', $data);		
	}

	public function forgot()
	{
		 $this->load->view('site/forgot-password.php');
	}


	public function sign_up()
	{
		 $this->form_validation->set_rules('name','name','trim|required',array('required' => $this->lang->line('name_require')));
		 $this->form_validation->set_rules('email','email ','trim|required|is_unique[users.email]',array('required' => $this->lang->line('email_require'), 'is_unique' => $this->lang->line('email_unique')));
		 //$this->form_validation->set_rules('country','country ','trim|required', array('required' => $this->lang->line('country_require')));
		 $this->form_validation->set_rules('phone','phone ','trim|required|is_unique[users.phone]',array('required' => $this->lang->line('phone_require'), 'is_unique' => $this->lang->line('phone_unique')));
		 $this->form_validation->set_rules('password','password ','trim|required',array('required' => $this->lang->line('password_require')));
		 $this->form_validation->set_rules('cpassword','confirm password ','trim|required|matches[password]',array('required' => $this->lang->line('confirm_require'), 'matches'=>$this->lang->line('match_confirm')));
		 $this->form_validation->set_rules('user_type','user type ','trim|required', array('required' => $this->lang->line('user_type_require')));

		if($this->form_validation->run()){

				$insert['name'] = $this->input->post('name');
				$insert['email'] = $this->input->post('email');
				$insert['country'] = $this->session->userdata('countryId'); //$this->input->post('country');
				$insert['phone'] = $this->input->post('phone');
				$insert['password'] = $this->input->post('password');
				$insert['user_type'] = $this->input->post('user_type');
				$insert['email_verified'] = 0;
				$insert['status'] = 1;
				$insert['token'] = $this->generateRandomString();
				$country = $this->common_model->GetSingleData('country', array('id'=>$insert['country']));
				$insert['phone_with_code'] = $country['phonecode'].$insert['phone'];
				//$FreePosts = $this->common_model->GetSingleData('admin', array('id'=>1));
				//$insert['no_of_posts'] = $FreePosts['post_qty'];
				//$insert['remain_posts'] = $FreePosts['post_qty'];
				$insert['referal_code'] = $this->generateRandomReferal_code();

				$insert['created_at'] = date('Y-m-d H:i:s');

				$run = $this->common_model->InsertData('users', $insert);
					if ($run) {
						$this->session->set_userdata('user_id',$run);
						

						/*$link = '<p><a href="'.base_url().'email-verify/'.$run.'/'.$insert['token'].'" >'.base_url().'email-verify/'.$run.'/'.$insert['token'].'</a></p>';
						$to  = $insert['email'];
						$email_template = $this->common_model->GetDataById('email_template',1);

						$subject = $email_template['subject_'.$this->lang11.''];

						$email_body = $email_template['content_'.$this->lang11.''];	
						$email_body0 = str_replace("../assets/site/images/logo.png",base_url().'assets/site/images/logo.png',$email_body);		
						$email_body1 = str_replace("[USERNAME]",$insert['name'],$email_body0);
						$email_body2 = str_replace("[REGISTRATION_LINK]",$link,$email_body1);
						
	          $this->common_model->SendMailCustom($to,$subject,$email_body2); */
						$link = '<p><a href="'.base_url().'email-verify/'.$run.'/'.$insert['token'].'" >'.base_url().'email-verify/'.$run.'/'.$insert['token'].'</a></p>';
	          $email_template = $this->common_model->GetDataById('email_template',1);
	          $email_body = $email_template['content_'.$this->lang11.''];

	            $subject = $email_template['subject_'.$this->lang11.''];
	            //echo $subject; die;
	            $html = '<h1 style="font-size: 28px; font-weight: bold; color: #00a651;">'.$subject.'</h1>';
	            $email_body = str_replace("[USERNAME]",$insert['name'],$email_body);
	            $html .= str_replace("[REGISTRATION_LINK]",$link,$email_body);
							$this->common_model->SendMail($to,$subject,$html);


						$output['status'] = 1;						
						$this->session->set_flashdata('msgs','<div class="alert alert-success">'.$this->lang->line('sign_up_success').'</div>');	
						
					} else {
						$output['status'] = 1;						
						$output['message'] =  '<div class="alert alert-danger">'.$this->lang->line('something_wrong').'</div>';
					}
		 }//end if form validation
		else {
			$output['status'] = 0;
			$output['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}//end else form validation
		echo json_encode($output);
	}


	private function generateRandomString($length = 25) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $check = $this->common_model->GetSingleData('users', array('token'=>$randomString));
    		if ($check) {
    			 $this->generateRandomString();
    		} else {
    			return $randomString;
    		}
    }

    private function generateRandomReferal_code($length = 15) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $check = $this->common_model->GetSingleData('users', array('referal_code'=>$randomString));
    		if ($check) {
    			 $this->generateRandomReferal_code();
    		} else {
    			return $randomString;
    		}
    }

    
	
		public function SendPassword()
		{
			  $this->form_validation->set_rules('email','Email','trim|required|valid_email', array('required' => $this->lang->line('email_require')));

			 		if($this->form_validation->run()==true){
			 			$email = $this->input->post('email');

			 			$run = $this->common_model->GetSingleData('users', array('email'=>$email));
			 			if ($run) {

							$to  = $email;
			 				/*
						$email_template = $this->common_model->GetDataById('email_template',2);

						$email_body = $email_template['content_'.$this->lang11.''];		
						$email_body0 = str_replace("../assets/site/images/logo.png",base_url().'assets/site/images/logo.png',$email_body);		
						$email_body = str_replace("[USERNAME]",$run['name'],$email_body0);
						$email_body = str_replace("[PASSWORD]",$run['password'],$email_body);

						$subject = $email_template['subject_'.$this->lang11.''];;
						
	          $this->common_model->SendMailCustom($to,$subject,$email_body);*/
	          $email_template = $this->common_model->GetDataById('email_template',2);
	          $email_body = $email_template['content_'.$this->lang11.''];

	            $subject = $email_template['subject_'.$this->lang11.''];
	            //echo $subject; die;
	            $html = '<h1 style="font-size: 28px; font-weight: bold; color: #00a651;">'.$subject.'</h1>';
	            $email_body = str_replace("[USERNAME]",$run['name'],$email_body);
							$html .= str_replace("[PASSWORD]",$run['password'],$email_body);
							$this->common_model->SendMail($to,$subject,$html);

			 				$json['message']= '<div class="alert alert-success">'.$this->lang->line('password_send').'</div>';
							$json['status']=1;
			 			} else {
			 				$json['message']= '<div class="alert alert-danger">'.$this->lang->line('email_not_exist').'</div>';
							$json['status']=0;
			 			}
			 		} else {
			 			$json['message']= '<div class="alert alert-danger">'.validation_errors().'<div>';
						$json['status']=0;
			 		}

			 		echo json_encode($json);
		}

		public function SetLangugae()
		{
			 $lang = $this->input->post('lang');

			 if ($lang == 'english') {
			    $this->session->set_userdata('language','english');	
			    $this->session->set_userdata('languageCls','');	

			    $output['status'] = 1; 	   
			 } elseif ($lang == 'arabic') {
			    $this->session->set_userdata('language','arabic');	
			    $this->session->set_userdata('languageCls','class-arb');				    
			    $output['status'] = 1;	   			 	  
			 } else {
			    $this->session->set_userdata('language','english');
			    $this->session->set_userdata('languageCls','');	
			    $output['status'] = 1;	 	   			 		
			 }
			echo json_encode($output);


		}

		public function careers()
		{
			$data['content'] = $this->common_model->GetSingleData('career_content', array('id'=>1));
			$data['jobs'] = $this->common_model->GetAllData('career','','id','desc');
			$data['testimonial'] = $this->common_model->GetAllData('testti_moniyal', '','id','asc');			
		  $this->load->view('site/career', $data);
		}


		public function ContactUsAction()
		{
				$this->form_validation->set_rules('f_name','first name','trim|required', array('required' => $this->lang->line('f_name_require')));
				$this->form_validation->set_rules('l_name','last name','trim|required', array('required' => $this->lang->line('l_name_require')));
				$this->form_validation->set_rules('email','email','trim|required', array('required' => $this->lang->line('email_require')));
				$this->form_validation->set_rules('phone','phone','trim|required', array('required' => $this->lang->line('phone_require')));
				$this->form_validation->set_rules('comments','comments','trim|required', array('required' => $this->lang->line('comment_require')));

				if($this->form_validation->run()){
					$insert['f_name'] = $this->input->post('f_name');
					$insert['l_name'] = $this->input->post('l_name');
					$insert['email'] = $this->input->post('email');
					$insert['phone'] = $this->input->post('phone');
					$insert['comments'] = $this->input->post('comments');
					$insert['created_at'] = date('Y-m-d H:i:s');
					$run = $this->common_model->InsertData('contactus', $insert);
						if ($run) {
							$output['status'] = 1;
							$this->session->set_flashdata('msgs','<div class="alert alert-success">'.$this->lang->line('success_contact').'</div>');	
							}
							else {
						  $output['status'] = 0;
						  $output['message'] = '<div class="alert alert-danger">'.$this->lang->line('something_wrong').'</div>';	
							}

					}//end if form validation
				else {
					$output['status'] = 0;
					$output['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
				}//end else form validation
				echo json_encode($output);
					  
		}

		public function blog()
		{
			 $data['data'] = $this->common_model->GetAllData('blog', '','id','desc');
			 $this->load->view('site/blog', $data);
		}

		public function blog_detail()
		{
				$id = $this->uri->segment(2);
			 $data['data'] = $this->common_model->GetSingleData('blog', array('id'=>$id));
			 $this->load->view('site/blog-details', $data);
		}

		public function new_blog_details($id)
		{
			 $data['data'] = $this->common_model->GetSingleData('blog', array('id'=>$id));
			 $this->load->view('site/new-blog-details', $data);
		}

		

		public function SetCountry()
		{
			 $country_id = $this->input->post('id');
			 $country = $this->common_model->GetSingleData('country', array('id'=>$country_id));
			 if ($country) {
			    $this->session->set_userdata('countryId', $country['id']);	
			    $this->session->set_userdata('countryName',$country['iso3']);	
			    $output['status'] = 1; 	   
			 }  else { 
			    $output['status'] = 0;	 	   			 		
			 }
			echo json_encode($output);
		}


		public function AdsDetail($id)
		{
			 $ip_address = $_SERVER['REMOTE_ADDR'];
			 if ($this->session->userdata('user_id')) {
			    $whereView = "ads_id='".$id."' and (user_id='".$this->session->userdata('user_id')."' or ip_address='".$ip_address."')";
			 } else {
				  $whereView = "ads_id='".$id."' and ip_address='".$ip_address."' ";			 	
			 }
			 $alreadyView = $this->common_model->GetSingleData('ads_views', $whereView);
			 if ($alreadyView == false) {
			 	  $insert['user_id'] = $this->session->userdata('user_id');
			 	  $insert['ads_id'] = $id;
			 	  $insert['ip_address'] = $ip_address;
			 	  $insert['created_at'] = date('Y-m-d H:i:s');
			 	  $this->common_model->InsertData('ads_views', $insert);
			 }
			 $data['data'] = $this->common_model->GetSingleData('ads_posts', array('id'=>$id));
			 $data['ads_images'] = $this->common_model->GetAllData('ads_images', array('post_id'=>$id));
			 $data['category'] = $this->common_model->GetSingleData('category', array('id'=>$data['data']['category_id']));
			 $data['sub_category'] = $this->common_model->GetSingleData('category', array('id'=>$data['data']['sub_category_id']));
			 //$data['fields'] = $this->common_model->GetAllData('sub_category_fields', array('sub_category_id'=>$data['data']['sub_category_id']));

			 $where = "id !=".$id." "; 
			 if ($this->session->userdata('user_id')) {
			  	$where .= "and user_id != ".$this->session->userdata('user_id')." "; 
			  } 
			 $where .= " and (category_id=".$data['data']['category_id']." or sub_category_id=".$data['data']['sub_category_id'].")";
			 $data['recommended_ads'] = $this->common_model->GetAllData('ads_posts',$where, 'id','desc',5);
			 $data['views'] = $this->common_model->GetAllData('ads_views', array('ads_id'=>$id));
			 $data['rate'] = $this->common_model->GetAllData('ads_rating', array('ads_id'=>$id));
			 $data['already_rate'] = $this->common_model->GetSingleData('ads_rating', array('ads_id'=>$id, 'user_id'=>$this->session->userdata('user_id')));
			 $this->load->view('site/detail', $data);
		}

		public function ReportForm()
		{
			 $this->form_validation->set_rules('message','message','trim|required');

			 if($this->form_validation->run()){
			 			$insert['message'] = $this->input->post('message');
			 			$insert['email'] = $this->input->post('email');
			 			if($this->session->userdata('user_id')){
			 				$insert['user_id'] = $this->session->userdata('user_id');
			 				$user_data = $this->common_model->GetSingleData('users', array('id'=> $insert['user_id']));
			 				$insert['email'] = $user_data['email'];
			 			}
			 			$insert['ads_id'] = $this->input->post('ads_id');
			 			$insert['ads_owner'] = $this->input->post('ads_owner');
			 			$insert['created_at'] = date('Y-m-d H:i:s');
			 			$run = $this->common_model->InsertData('report', $insert);
			 			//$already = $this->common_model->GetSingleData
			 			if ($run) {
			 						$output['status'] = 1;
						  		$output['message'] = '<div class="alert alert-success">Thankyou!! We will back to you soon. </div>';	

			 			} else {
			    				$output['status'] = 0; 	 
						  		$output['message'] = '<div class="alert alert-danger">'.$this->lang->line('something_wrong').'</div>';	

			 			}
			 	}//end if form validation
			else {
				$output['status'] = 0;
				$output['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
			}//end else form validation
			echo json_encode($output);
		}

		public function public_pr($id)
		{
			  $data['data'] = $this->common_model->GetSingleData('users', array('id'=>$id));
			  //is_featured=1 and status=1 and is_deleted=0
			  $data['ads'] = $this->common_model->GetAllData('ads_posts', array('user_id'=>$id, 'status'=>1,'is_deleted'=>0), 'id','desc');
			  $this->load->view('site/public-profile', $data);
		}

		public function financeForm()
		{
			 $this->form_validation->set_rules('company','company','trim|required');
			 $this->form_validation->set_rules('salary','salary','trim|required');
			 $this->form_validation->set_rules('ads_id','ads_id','trim|required');		
			 $this->form_validation->set_rules('phone','phone','trim|required');		
			 $this->form_validation->set_rules('full_name','full name','trim|required');		
			 $this->form_validation->set_rules('email','email','trim|required');		

			 if($this->form_validation->run()) {
 					
 					$insert['company'] = $this->input->post('company');
 					$insert['salary'] = $this->input->post('salary');
 					$insert['full_name'] = $this->input->post('full_name');
 					$insert['user_id'] = $this->session->userdata('user_id');
 					$insert['ads_id'] = $this->input->post('ads_id');
 					$insert['email'] = $this->input->post('email');
 					$insert['created_at'] = date('Y-m-d H:i:s');
 					$insert['type'] = $this->input->post('financeType');
					$insert['phone'] = $this->input->post('phone');
					$insert['phone_2'] = $this->input->post('phone_2');
 					$already = $this->common_model->GetSingleData('get_finance', array('user_id'=>$insert['user_id'], 'ads_id'=>$insert['ads_id'], 'type'=>$insert['type']));
 					$UserData = $this->common_model->GetColumnName('users', array('id'=>$insert['user_id']), array('gender', 'dob'));
 					if ($already) {
 						$output['status'] = 0;
				    $output['message'] = '<div class="alert alert-danger">Your already requested for this.</div>'; 
 					} elseif (empty($UserData['gender']) || empty($UserData['dob'])) {
 						 $output['status'] = 0;
				    $output['message'] = '<div class="alert alert-danger">Your profile is incomplete. Kindly update your profile first</div>'; 
 					} elseif ($this->common_model->InsertData('get_finance', $insert)) {
 						$output['status'] = 1;
				    $output['message'] = 'Your requested submitted successfully. We will contact you soon.'; 

 					} else {
 							$output['status'] = 0;
				    $output['message'] = '<div class="alert alert-success">'.$this->lang->line('something_wrong').'</div>'; 
 					}

			 }//end if form validation
			else {
				$output['status'] = 0;
				$output['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
			}//end else form validation
			echo json_encode($output);
		}

		public function blog_new()
		{
			$where = "1=1";
			if (isset($_REQUEST['cat_id']) && !empty($_REQUEST['cat_id'])) {
				 $where .= " and category_id='".$_REQUEST['cat_id']."'";
			}
			$data['data'] = $this->common_model->GetAllData('blog',$where,'id','desc');
			$data['latest'] = $this->common_model->GetAllData('blog','','id','desc',1);

			$data['blog_category'] = $this->common_model->GetAllData('blog_category','','id','desc');
			 $this->load->view('site/blog-new', $data);
		}


		public function GetCountryByLatLng()
		{
			$latitude = $_REQUEST['latitude'];
			$longitude = $_REQUEST['longitude'];
			 $curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'http://api.geonames.org/countryCodeJSON?lat='.$latitude.'&lng='.$longitude.'&username=demo123',
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				));

				$response = curl_exec($curl);

				$rest = json_decode($response);
				//echo $rest->countryName;
				//print_r($rest);
				curl_close($curl);
				$country = $this->common_model->GetColumnName('country', array('nicename'=>$rest->countryName,'status'=>1));
				//print_r($country);
				if ($country && !$this->session->userdata('countryId')) {
			    $this->session->set_userdata('countryId', $country['id']);	
			    $this->session->set_userdata('countryName',$country['iso3']);
			    			    $output['status'] = 1;	
				} else if (!$this->session->userdata('countryId')) {
					$this->session->set_userdata('countryId', '63');	
			    $this->session->set_userdata('countryName','EGY');
			    $output['status'] = 1;
				} else {
			    $output['status'] = 0;					
				}
			    echo json_encode($output); 	   
		}

		public function terms_condition()
		{
			 $data['title'] = $this->lang->line('terms_and_conditions');
			 $this->load->view('site/terms-condition', $data);
		}

		public function privacy()
		{
			 $data['title'] = $this->lang->line('privacy_policy');			
			 $this->load->view('site/terms-condition', $data);
		}

}
	