<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

  public function __construct() {
    parent::__construct();

		header("Access-Control-Allow-Origin:*");
		header('Content-type:application/json');
		$this->db->query("set sql_mode = ''");
		$this->load->model('Common_model','common');
		//https://www.bluediamondresearch.com/WEB01/veamelnew/api/
	}


	public function index() {
		 $output['status'] = 0;
		 $output['message'] = 'Its working';
		echo json_encode($output);			
	}
	
	private function response($data){
		echo json_encode($data);
		exit();
	}
	
	private function CustomerProfile($id=null){

		$user = $this->common_model->GetSingleData('users',array('id'=>$id));
		$output = false;
		if($user) {

			$output['id'] = $user['id'];
			// $output['user_type'] = $user['user_type'];
			$output['name'] = $user['name'];
			$output['email'] = $user['email'];
			$output['phone'] = $user['phone'];
			$output['lat'] = $user['lat'];
			$output['lng'] = $user['lng'];
			$output['address'] = $user['address'];
		 		
		}

		return $output;

	}
	
	public function login() {
		//https://webwiders.in/WEB01/QuickCash/Api/login
		$this->form_validation->set_rules('email','Email','required|trim');
		$this->form_validation->set_rules('password','password','required|trim');
		// $this->form_validation->set_rules('user_type','user_type','required|trim');
		if($this->form_validation->run()== FALSE) {

			$output['status'] = 0;
			$output['message']='Check parameter.';     

		} else {

			$email=$this->input->post('email');
			$password=$this->input->post('password');
		
			$userData=array(
				'email'=>$email,
				'password'=>$password
			);

			$result_id=$this->common->GetColumnName('users',$userData,array('id'));
			if(!empty($result_id)){
				$user_id = $result_id['id'];
				$user_profile=$this->CustomerProfile($user_id);
		
				$output['data'] = $user_profile;
		
				$output['status'] = 1;
				$output['message']='Success.';
				
			}else{
				$output['status'] = 0;
				$output['message']='Invalid login details.';   
			}


		}

		echo json_encode($output);

	}
	
	public function signup(){

		//https://webwiders.in/WEB01/QuickCash/Api/Signup
		
		// $this->form_validation->set_rules('user_type','user_type','trim|required');
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('email','email','trim|required');
		$this->form_validation->set_rules('password','password','trim|required');

		if($this->form_validation->run()){

			$this->form_validation->set_rules('email','Email','trim|required|is_unique[users.email]');
			if($this->form_validation->run()==false){
				$output['status'] = 0;
				$output['message'] = 'This email is already exist!';
			} else {
		
			
				// $insert['user_type'] = $this->input->post('user_type');
				$insert['name'] = $this->input->post('name');
				$insert['email'] = $this->input->post('email');
				$insert['password'] = $this->input->post('password');

				$insert['created_at'] = date('Y-m-d H:i:s');
				$insert['updated_at'] = date('Y-m-d H:i:s');
			
				$run = $this->common->InsertData('users',$insert);						

				$output['data'] = $this->CustomerProfile($run);
				$output['status'] = 1;
				$output['message']="Congratulations your account has been created successfully.";

					

			}

		}  else {

			$output['status'] = 0;
			$output['message'] = "Check parameter!";

		}

		echo json_encode($output);

	}
	public function check_email(){
		//https://www.bluediamondresearch.com/WEB01/bayarea/Api/CreatePaymentIntent
		$this->form_validation->set_rules('email','email','trim|required|valid_email');
		
		if($this->form_validation->run()){
			
			$email = $this->input->post('email');
			
			$data = $this->common_model->GetColumnName('users', array('email'=>$email));
			
			
			if($data){
				$output['status'] = 1;
				$output['message'] = 'Available';
				$output['data'] = $this->CustomerProfile($data['id']);
			} else {
				$output['status'] = 2;
				$output['message'] = 'New User';
			}
			
			
		} else {
			$output['status'] = 0;
			$output['message'] = 'Check parameter.';
		}
		echo json_encode($output);
	}

	public function CreatePaymentIntent(){
		//https://www.bluediamondresearch.com/WEB01/bayarea/Api/CreatePaymentIntent
		$this->form_validation->set_rules('email','email','trim|required');
		$this->form_validation->set_rules('amount','amount','trim|required');
		if($this->form_validation->run()){
			
			$setting = $this->common_model->GetSingleData('settings', array('id'=>1));
			
			$email = $this->input->post('email');
			$amount = $this->input->post('amount')*1;
			require_once('application/libraries/stripe-php-7.49.0/init.php');
			
			$secret_key = $setting['stripe_sk'];
			
			$statement_descriptor = 'Order Checkout';
			
			\Stripe\Stripe::setApiKey($secret_key);
			try {
				$customer = \Stripe\Customer::create(['email' => $email]);
				$paymentIntent = \Stripe\PaymentIntent::create([
					'amount' => $amount*100,
					'currency' => 'USD',
					'customer' => $customer->id,
					'description' => $statement_descriptor,
					'setup_future_usage' => 'off_session',
					'payment_method_types'=>['card'],
					'payment_method_options' => [
						"card" => [
							"request_three_d_secure" => "any"
						]
					 ]
				]);
				$output = array(
						'status' => 1, 
						'customerID' => $customer->id,
						'clientSecret' => $paymentIntent->client_secret
					);
			} catch (Error $e) {
				$output = array(
					'status' => 0, 
					'message' => $e->getMessage()
				);
			}
		} else {
			$output['status'] = 0;
			$output['message'] = 'Check parameter.';
		}
		echo json_encode($output);
	}

	public function setting()
	{
		$data = $this->common_model->GetSingleData('settings', array('id'=>1));
		if($data)
		{
			$output['status'] = 1;
			$output['data'] = $data;
		}
		else{
			$output['status'] = 0;
			$output['message'] = 'No data found';
		}
		echo json_encode($output);
	}

	public function get_pickup_address()
	{
		$data = $this->common_model->GetAllData('pickup_address');
		if($data) 
		{
			$output['status'] = 1;
			$output['data'] = $data;
		}
		else{
			$output['status'] = 0;
			$output['message'] = 'No data found';
		}
		echo json_encode($output);
	}

	public function preferences()
	{
		$where = "available=1";
		if (isset($_REQUEST['cat_id']) && !empty($_REQUEST['cat_id'])) {
				$where .= ' and category_id='.$_REQUEST['cat_id'].'';
		}
		$data = $this->common_model->GetAllData('preference', $where);
		if($data)
		{ 
			$list = [];
			foreach($data as $v)
			{
				$datas = $v;
				array_push($list, $datas);
			}
			$output['status'] = 1;
			$output['message'] = "List";
			$output['data'] = $list;
		} else {
			$output['status'] = 0;
			$output['message'] = "No Data Found";
		}
		echo json_encode($output);
	}


	public function getPreferenceById()
	{
		 if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
		 		$id = $_REQUEST['id'];

		 		$run = $this->common_model->GetSingleData('preference', array('id'=>$id));
		 		if ($run) {
		 			 $output['status'] = 1;
					 $output['message'] = 'Success';
					 $output['data']= $run;
		 		} else {
		 			 $output['status'] = 0;
					 $output['message'] = 'No record found';
		 		}
		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';
			$output['data']= array();
		}

		return $this->response($output);
	}
	
	public function contactForSameDay(){
		
	 

		//https://webwiders.in/WEB01/QuickCash/Api/Signup
		
		// $this->form_validation->set_rules('user_type','user_type','trim|required');
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('email','email','trim|required');
		$this->form_validation->set_rules('phone','phone','trim|required');
		$this->form_validation->set_rules('delivery_address','Delivery Address','trim|required');

		if($this->form_validation->run()){
			
			$insert['name'] = $this->input->post('name');
			$insert['email'] = $this->input->post('email');
			$insert['phone'] = $this->input->post('phone');
			$insert['delivery_address'] = $this->input->post('delivery_address');
			
			$insert['created_at'] = date('Y-m-d H:i:s');
			$insert['updated_at'] = date('Y-m-d H:i:s');

			$run = $this->common->InsertData('contact_for_sameday',$insert);						
			
			$output['status'] = 1;
			$output['message']="You request has been sent successfully. We will contact you soon.";
			


		}  else {

			$output['status'] = 0;

			$output['message'] = "Check parameter!";

		}

		echo json_encode($output);

	}

	public function contactUs(){

		//https://webwiders.in/WEB01/QuickCash/Api/Signup
		
		// $this->form_validation->set_rules('user_type','user_type','trim|required');
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('email','email','trim|required');
		$this->form_validation->set_rules('phone','phone','trim|required');
		$this->form_validation->set_rules('subject','subject','trim|required');
		$this->form_validation->set_rules('message','message','trim|required');

		if($this->form_validation->run()){
			
			$insert['name'] = $this->input->post('name');
			$insert['email'] = $this->input->post('email');
			$insert['phone'] = $this->input->post('phone');
			$insert['subject'] = $this->input->post('subject');
			$insert['message'] = $this->input->post('message');
			
			$insert['created_at'] = date('Y-m-d H:i:s');
			$insert['updated_at'] = date('Y-m-d H:i:s');

			$run = $this->common->InsertData('contact_request',$insert);						


			/*$subject="Account created successfully!!";
			$body = '<p>Hello '.$insert['full_name'].'</p>';
			$body .= '<p>Your account has been created successfully.</p>'; 
			$body .= '<p>Kindly verify your accout</p>'; 
			$body .= '<p>OTP is : '.$insert['otp'].'</p>'; 
			$send = $this->common_model->SendMail($insert['email'],$subject,$body); 

			$output['data'] = $this->CustomerProfile($run);*/
			
			$output['status'] = 1;
			$output['message']="You request has been sent successfully. We will contact us soon.";
			


		}  else {

			$output['status'] = 0;

			$output['message'] = "Check parameter!";

		}

		echo json_encode($output);

	}
	
	public function getCategory(){
		$data = $this->common_model->GetAllData('category');
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	public function getAreaServed(){
		$data = $this->common_model->GetAllData('area_served');
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	public function getAreaServedById(){
		
		if(!isset($_REQUEST['area_group']) || empty($_REQUEST['area_group'])){
			$output['status'] = 0;
			$output['message'] = 'Check parameter';
			return $this->response($output);
		}
		
		
		$data = $this->common_model->GetDataById('area_served',$_REQUEST['area_group']);
		$data['location_background_image'] = site_url().$data['location_background_image'];
		
		$images = $this->common_model->GetColumnName('meal_images',array('meal_id'=>$data['id']),array('*',"CONCAT('".site_url()."',image) as image"),true);
			
		$data['images'] = $images;
			
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	
	
	public function getHomePageContent(){
		
		$homePage = $this->common_model->GetDataById('home_content',1);
		$homePage['background_image'] = site_url().$homePage['background_image'];
		
		$data['homePage'] = $homePage;
		
		
		$whyOrder = $this->common_model->GetDataById('why_order_content',1);
		$whyOrder['image'] = site_url().$whyOrder['image'];
		
		$data['whyOrder'] = $whyOrder;
		$data['foodDelivered'] = 0;
		$data['experience'] = 0;
		$data['satisfied'] = 0;
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	
	public function getFooterContent(){
		
		$contact = $this->common_model->GetDataById('contact_details',1);
		
		$data['contact'] = $contact;
		$data['footerDesc'] = 'Curabitur posuere felis in massa pulvinar, nec mollis nibh eleifend. Maecenas turpis mi. Vivamus pulvinar lobortis vehicula pellentesque.';
		
		
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	
	public function getAboutPageContent(){
		
		$content = $this->common_model->GetDataById('inner_content',1);
	
		$data = $content['about'];
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	
	public function getPrivacyPageContent(){
		
		$content = $this->common_model->GetDataById('inner_content',1);
	
		$data = $content['privacy'];
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	public function getTermsPageContent(){
		
		$content = $this->common_model->GetDataById('inner_content',1);
	
		$data = $content['terms'];
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	
	
	public function getMealType(){
		$data = $this->common_model->GetAllData('meal_type');
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	public function getMeals(){
		//
		$where = "is_enabled = 1";
		
		if(isset($_REQUEST['category']) && $_REQUEST['category'] != 0){
			$where .= " and category = ".$_REQUEST['category'];
		}
		
		if(isset($_REQUEST['meal_type']) && $_REQUEST['meal_type'] != 0){
			$where .= " and meal_type = ".$_REQUEST['meal_type'];
		}
		
		if(isset($_REQUEST['area_group']) && $_REQUEST['area_group'] != 0){
			$where .= " and area_group = ".$_REQUEST['area_group'];
		}
		
		$page = 1;
		
		if(isset($_REQUEST['page']) && $_REQUEST['page'] > 0){
			$page = $_REQUEST['page'];
		}
		
		$limit = 10;
		
		$offset = ($page-1)*$limit;
		
		$count = $this->common_model->GetColumnName('meals',$where,array('count(id) as total'));
		
		$total = $count['total'];
		
		
		$data = $this->common_model->GetAllData('meals',$where,'id','desc',$limit,$offset,array('id'));
		
		
		$list = [];
		
		foreach($data as $key => $value){
			$list[$key] = $this->MealData($value['id']);
			$list[$key]['short_description'] = strip_tags(substr($list[$key]['short_description'], 0, 20).'...');
		}
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['total'] = $total;
		$output['data'] = $list;
		return $this->response($output);
		
	}

	public function getMealsDataForCart()
	{
		//
		 if(isset($_REQUEST['meal_ids']) && !empty($_REQUEST['meal_ids'])) {

		 	$id_parts = explode(',', $_REQUEST['meal_ids']);

		 	$result = array();
		 	foreach ($id_parts as $key => $value) {

		 		 $result[$key] = $this->MealData($value);
		 		 $result[$key]['all_preferences'] = $this->common_model->GetAllData('preference', array('category_id'=>$result[$key]['category']['id']));
		 	}
			$output['status'] = 1;
			$output['message'] = 'Success';
			$output['data']= $result;
			 
		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';
			$output['data']= array();
		}

		return $this->response($output);
	}
	public function getMealById(){
		
		if(!isset($_REQUEST['meal_id']) || empty($_REQUEST['meal_id'])){
			$output['status'] = 0;
			$output['message'] = 'Check parameter';
			return $this->response($output);
		}
		
		$meal_id =  $_REQUEST['meal_id'];
		
		$where = "id = $meal_id";
		
		
		$data = $this->MealData($meal_id);;
		
		
		
		$output['status'] = 1;;
		$output['message'] = 'Success';;
		$output['data'] = $data;
		return $this->response($output);
		
	}
	
	private function MealData($id){
		$meal = $this->common_model->GetDataById('meals',$id);
		
		if($meal){
			
			if (!empty($meal['disabled_dates'])) {

				$parts= explode(',', $meal['disabled_dates']);
				$newDates = '';
				foreach ($parts as $key => $value) {
					 $newDates .= date('m-d-Y', strtotime($value)).',';
				}
				$meal['disabled_dates'] = rtrim($newDates,',');
			} else {
				$meal['disabled_dates'] = '';				
			}

			$meal['category'] = $this->common_model->GetDataById('category',$meal['category']);
			$meal['meal_type'] = $this->common_model->GetDataById('meal_type',$meal['meal_type']);
			$meal['area_group'] = $this->common_model->GetDataById('area_served',$meal['area_group']);
			
			$images = $this->common_model->GetColumnName('meal_images',array('meal_id'=>$id),array('*',"CONCAT('".site_url()."',image) as image"),true);
			
			$meal['images'] = $images;
			$meal['rating'] = 0;
			$meal['reviews'] = 0;
			
			
			
		}
		return $meal;
	}
	
	/*

	public function ClearNotification(){

		//https://webwiders.in/WEB01/QuickCash/Api/ClearNotification?user_id=5

		if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
		
			$user_id = $_REQUEST['user_id'];		
			$this->common_model->DeleteData('notification',array('user_id'=>$user_id));		
			$output['status'] = 1;
			$output['message'] = 'Success!';		
		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';

		}

		echo json_encode($output);

	}

	public function ClearSingleNotification(){

		//https://webwiders.in/WEB01/QuickCash/Api/ClearSingleNotification?id=1

		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
		
			$id = $_REQUEST['id'];		
			$this->common_model->DeleteData('notification',array('id'=>$id));		
			$output['status'] = 1;
			$output['message'] = 'Success!';		
		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';

		}

		echo json_encode($output);

	}

	public function MarkAsReadNotification(){

		//https://webwiders.in/WEB01/QuickCash/Api/MarkAsReadNotification?user_id=5		

		if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){

			$user_id = $_REQUEST['user_id'];			
			$where['user_id'] = $user_id;
			$where = "user_id = $user_id";

			if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
				$where .= " and id in (".$_REQUEST['id'].")";
			}

			$this->common_model->UpdateData('notification',$where,array('is_read'=>1));
			$output['status'] = 1;
			$output['message'] = 'Success!';

		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';

		}

		echo json_encode($output);

	}

	public function GetNotification(){

		//https://webwiders.in/WEB01/QuickCash/Api/GetNotification?user_id=5		
		if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){

			$user_id = $_REQUEST['user_id'];
			$notification = $this->common_model->GetDataByOrderLimit('notification',array('user_id'=>$user_id),'id','desc',0,100);
			$unread = $this->common_model->GetColumnName('notification',array('user_id'=>$user_id,'is_read'=>0),array('count(id) as total'));

			$result = array();

			if(!empty($notification)){
						
				foreach($notification as $key => $value){

					$result[$key] = $value;
					$result[$key]['other'] = unserialize($value['other']);
					$result[$key]['create_date'] = time_ago($value['create_date']);
				
					$profile = site_url().'upload/no.png';

					$title = 'Team '.Project;

					if($value['behalf_of']){

						$user = $this->common_model->GetColumnName('users',array('id'=>$value['behalf_of']),array('full_name','image'));
						
						if($user){
							$title = $user['full_name'];
							if($user['image']){
								$profile = site_url().'upload/users/'.$user['image'];
							}
						}				
					}
					
					$result[$key]['profile'] = $profile;
					$result[$key]['title'] = $title;

				}				

				$output['unread'] = ($unread) ? $unread['total'] : 0;
				$output['data'] = $result;
				$output['status'] = 1;
				$output['message'] = 'Success!';

			} else {

				$output['data'] = $result;
				$output['status'] = 0;
				$output['message'] = 'We did not find any records.';
			}

		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';

		}

		echo json_encode($output);

	}
	
	public function GetUnreadNotification() {

		//https://webwiders.in/WEB01/QuickCash/Api/GetUnreadNotification?user_id=5				

		if(empty($_REQUEST['user_id'])) {
			$output['status'] = "0";
			$output['message'] = "Please check parameter";

		} else  {

			$user_id=$_REQUEST['user_id'];					

			$unreadNoti = $this->common_model->GetColumnName('notification',array('user_id'=>$user_id,'is_read'=>0),array('count(id) as total'));

			$unreadNoti = ($unreadNoti) ? $unreadNoti['total'] : 0;
			$output['unreadNotification'] =$unreadNoti;
			$output['status'] =1;

		}

			echo json_encode($output);

	}
		
	

	public function EditProfile() {
		//https://webwiders.in/WEB01/QuickCash/Api/EditProfile
		$this->form_validation->set_rules('user_id','user_id','trim|required');

		if($this->form_validation->run()){

				//$check = true;
				$user_id = $this->input->post('user_id');

		
				if (isset($_REQUEST['full_name'])) {
					$full_name = $this->input->post('full_name');
					$updata['full_name'] = $full_name;
				}
			
				if (isset($_REQUEST['city'])) {
					$city = $this->input->post('city');
					$updata['city'] = $city;
				}
				
				if (isset($_REQUEST['gender'])) {
					$gender = $this->input->post('gender');
					$updata['gender'] = $gender;
				}
			
				if (isset($_REQUEST['lat'])) {
					$lat = $this->input->post('lat');
					$updata['lat'] = $lat;
				}
				
				if (isset($_REQUEST['lng'])) {
					$lng = $this->input->post('lng');
					$updata['lng'] = $lng;
				}
				
				if (isset($_REQUEST['about'])) {
					$about = $this->input->post('about');
					$updata['about'] = $about;
				}
				
				if (isset($_REQUEST['profession'])) {
					$profession = $this->input->post('profession');
					$updata['profession'] = $profession;
				}

				if (isset($_REQUEST['address'])) {
					$address = $this->input->post('address');
					$updata['address'] = $address;
				}

				if (isset($_REQUEST['country'])) {
					$country = $this->input->post('country');
					$updata['country'] = $country;
				}
				
				if (isset($_REQUEST['state'])) {
					$state = $this->input->post('state');
					$updata['state'] = $state;
				}

				if (isset($_REQUEST['skills'])) {
					$skills = $this->input->post('skills');
					$updata['skills'] = $skills;
				}

				if (isset($_REQUEST['dob'])) {
					$dob = $this->input->post('dob');
					$updata['dob'] = $dob;
				}		

				if(isset($_FILES['image']['name'])) {

					$config['upload_path']="upload/users/";
					$config['allowed_types'] = '*';
					$config['encrypt_name']=true;
					$this->load->library("upload",$config);
					if ($this->upload->do_upload('image')) {
						$u_profile=$this->upload->data("file_name");
						$updata['image'] = $u_profile;
					} 
        }
				
        $updata['updated_at'] = date('Y-m-d H:i:s');
				$run = $this->common->UpdateData('users',array('id'=>$user_id),$updata);

				//echo $this->db->last_query();

				if($run){
					$output['data'] = $this->CustomerProfile($user_id);

					$output['status'] = 1;
					$output['message']="Your profile has been updated successfully.";

				}

			} else {

			$output['status'] = 0;
			$output['message'] = "Check parameter!";

		}

		echo json_encode($output);

	} 

	


  public function ChangePassword(){

		//https://webwiders.in/WEB01/QuickCash/Api/ChangePassword

		$this->form_validation->set_rules('current_password','current password','trim|required');
		$this->form_validation->set_rules('password','New password','trim|required');
		$this->form_validation->set_rules('user_id','id','trim|required');

		
		if($this->form_validation->run()){

			$id = $this->input->post('user_id');
			$cpassword=  $this->input->post('current_password');
			$npassword=  $this->input->post('password');

			$user = $this->common_model->GetColumnName('users',array('id'=>$id),array('password'));

			if($user){

				if($user['password']==$cpassword){
					$insert['password']=$npassword;
					$run = $this->common_model->UpdateData('users',array('id'=>$id),$insert);
					if($run){
						$output['status'] = 1;
						$output['message'] = 'Your password has been updated successfully.';

					} else {
						$output['status'] = 0;
						$output['message'] = 'We did not find any changes.';
					}

				} else {
					$output['status'] = 0;
					$output['message'] = 'Your existing password is incorrect.';

				}	
			} else {
				$output['status'] = 0;
				$output['message'] = 'We did not find any records.';

			}

				

 		} else {
 			$output['status'] = 0;
 			$output['message'] = 'Check parameter.';

		}

		echo json_encode($output);

	}

	public function GetCountryByIP(){ 

		//https://www.webwiders.in/WEB01/Sports-card/api/GetCountryByIP
		$ip_detals=false;
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$json = file_get_contents("https://ipinfo.io/".$ip_address); 
		echo $json;
	}

	public function UpdateDeviceId(){

		//https://webwiders.in/WEB01/QuickCash/Api/UpdateDeviceId

		
		$this->form_validation->set_rules('user_id','id','trim|required');		
		$this->form_validation->set_rules('device_id','device_id','trim|required');		

		if($this->form_validation->run()){
			$id = $this->input->post('user_id');
			$insert['device_id'] = $this->input->post('device_id');
			$insert['updated_at'] = date('Y-m-d H:i:s');		

			$run = $this->common_model->UpdateData('users',array('id'=>$id),$insert);
			if($run){
				$output['status'] = 1;
				$output['message'] = 'Success!';

			} else {
				$output['status'] = 0;
				$output['message'] = "Something went wrong, try again later!";
			}

 		} else {

			$output['status'] = 0;
			$output['message'] = 'Check parameter.';

		}

		echo json_encode($output);

	}

	public function GetUserProfile($user_id=""){

		//https://webwiders.in/WEB01/QuickCash/Api/GetUserProfile?user_id=
		// $row = $query->first_row()
 	 	if(!empty($user_id)) {
			$user_profile=$this->CustomerProfile($user_id);
			if(!empty($user_profile)){
			
				$output['data'] = $user_profile;
	
				$output['status'] = 1;
				$output['message'] = "User profile get successfully";
			}else{
				$output['status'] = 0;
				$output['message'] = "User not available";
			}
			
		} else {
 	 		$output['status'] = 0;
			$output['message'] = "Check parameters";
 	 	}
 	 	echo json_encode($output);
	}

	public function Inverval($user_id= "") {
		//https://webwiders.in/WEB01/QuickCash/Api/Inverval?user_id=3
		 if (!empty($user_id)) {
		 	 	// $user_id = $_REQUEST['user_id'];
		 	 	$data = $this->common_model->GetColumnName('users', array('id'=>$user_id), array('is_verified','is_block'));
		 	 	if ($data) {
		 	 	
		 	
					//$unreadNoti = $this->common_model->GetColumnName('notification',array('user_id'=>$user_id,'is_read'=>0),array('count(id) as total'));

					//$chat = $this->common_model->GetColumnName('chat',"receiver='$user_id' and is_read=0 and (select count(bookings.id) from bookings where bookings.id = chat.booking_id limit 1) > 0",array('count(id) as total'));


					//$unreadNoti = ($unreadNoti) ? $unreadNoti['total'] : 0;
						
					//$output['unreadNotification'] =$unreadNoti;
					//$output['unread_message'] = ($chat) ? $chat['total'] : 0;					 
		 	 		 $output['data'] = $data;
		 	 		 $output['status'] = 1;
					 $output['message'] = "Success";
		 	 	} else {
		 	 		$output['status'] = 0;
					$output['message'] = "Something went wrong";
		 	 	}
		 } else {
	 	 		$output['status'] = 0;
				$output['message'] = "Check parameters";
 	 	}
 	 	echo json_encode($output);
	}


	public function ForgetPassword(){

		//https://webwiders.in/WEB01/QuickCash/Api/ForgetPassword

		$this->form_validation->set_rules('email','email','required');	
		if($this->form_validation->run()){
			$email = $this->input->post('email');
		    $run = $this->common_model->GetColumnName('users',array('email' =>$email),array('password','email','full_name','id'));
			if($run){			

				$email = $run['email'];
				$name = $run['full_name'];
				$id = $run['id'];
				$subject = "Forget password";
				$html = '<p>Hello, '.$name.'</p>';

				$html .= '<p>This is an automated message . If you did not recently initiate the Forgot Password process, please disregard this email.</p>';

				$html .= '<p>You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p>';

				$html .= '<p>Password: <b>'.$run['password'].'</b></p>';
				$this->common_model->SendMail($run['email'],$subject,$html);
				$return = $this->CustomerProfile($id);

				
				//$output['data'] = $return;
				$output['status'] = 1;
				$output['message'] = 'Password sent to your email address.';

			} else {

				$output['status'] = 0;
				$output['message'] = 'Email address that you have entered is not registered with us.';

			}

 		} else {

			$output['status'] = 0;

			$output['message'] = 'Check parameter.';

		}
		echo json_encode($output);

	}


	private function CustomerProfile($id=null){

		$user = $this->common_model->GetSingleData('users',array('id'=>$id));
		$output = false;
		if($user) {

			$output['id'] = $user['id'];
			// $output['user_type'] = $user['user_type'];
			$output['full_name'] = $user['full_name'];
			$output['email'] = $user['email'];
			$output['phone'] = $user['phone'];
			$output['phone_with_code'] = $user['phone_with_code'];
			$output['is_verified'] = $user['is_verified'];
			$output['free_plan'] = $user['free_plan'];
			$output['profession'] = $user['profession'];
			$output['gender'] = $user['gender'];
			$output['lat'] = $user['lat'];
			$output['lng'] = $user['lng'];
			$output['dob'] = $user['dob'];
			$output['about'] = $user['about'];
			$output['city'] = $user['city'];
			$output['state'] = $user['state'];
			$output['country'] = $user['country'];
			$output['address'] = $user['address'];
			$output['is_block'] = $user['is_block'];
			$output['avg_rate_as_client'] = 0;
			$output['avg_rate_as_worker'] = 0;
			$getAvgRateClient = $this->common_model->GetColumnName('bookings', array('user_id'=>$id, 'status'=>3, 'client_rating !='=>0), array('SUM(client_rating) as avg_rate', 'COUNT(id) as total_data'));
			if ($getAvgRateClient && $getAvgRateClient['total_data'] > 0) {
				$output['avg_rate_as_client'] = $getAvgRateClient['avg_rate']/$getAvgRateClient['total_data'];	 
			}  		

			$getAvgRateWorker = $this->common_model->GetColumnName('bookings', array('worker_id'=>$id, 'status'=> 3, 'worker_rating !='=>0), array('SUM(worker_rating) as avg_rate', 'COUNT(id) as total_data'));
			if ($getAvgRateWorker && $getAvgRateWorker['total_data'] > 0) {
				$output['avg_rate_as_worker'] = $getAvgRateWorker['avg_rate']/$getAvgRateWorker['total_data'];	 
			} 

			$output['wallet_amount'] = $user['wallet_amount'];
			$skills  = array();
			$sub_skills  = array();

			if($user['skills']){

				$skills =$this->common_model->GetColumnName('category' , "id in (".$user['skills'].")",array('*',"CONCAT('" .site_url() ."',icon) AS icon"),true);


			}

			$output['skills'] = $skills;

			if($user['sub_skills']){

				$sub_skills =$this->common_model->GetColumnName('category' , "id in (".$user['sub_skills'].")",array('*',"CONCAT('" .site_url() ."',icon) AS icon"),true);


			}

			$output['sub_skills'] = $sub_skills;
						

			if($user['image']){
				$output['image'] = site_url().'upload/users/'.$user['image'];
			} else {
				$output['image'] = site_url().'upload/users/demo_image.jpg';
			}
			
			$today = date('Y-m-d');
			
			$user_plan = $this->common_model->GetSingleData('user_plan',"user_id = $id",'id','desc');
			//$user_plan = $this->common_model->GetSingleData('user_plan',"user_id = $id and DATE(start_date) <= DATE('".$today."') and DATE(end_date) >= DATE('".$today."')",'id','desc');
			
			$is_worker = 0;
			
			if($user_plan && $user_plan['is_bid']==1){
				$is_worker = 1;
			}

			if ($user_plan) {
				 $plan = $this->common_model->GetColumnName('plans', array('id'=>$user_plan['plan_id']), array('name'));
				 $user_plan['plan_title'] = $plan['name'];
			}
			
			$output['is_worker'] = $is_worker;
			$output['plans'] = $user_plan;
			

		}

		return $output;

	}


	private function CustomerShortProfile($id=null){

		$user = $this->common_model->GetSingleData('users',array('id'=>$id));
		$output = false;
		if($user) {

			$output['id'] = $user['id'];
			// $output['user_type'] = $user['user_type'];
			$output['full_name'] = $user['full_name'];
			$output['email'] = $user['email'];
			$output['phone'] = $user['phone'];
			$output['phone_with_code'] = $user['phone_with_code'];									

			if($user['image']){
				$output['image'] = site_url().'upload/users/'.$user['image'];
			} else {
				$output['image'] = site_url().'upload/users/demo_image.jpg';
			}						

		}

		return $output;

	}

	public function getKey()
	{
		$output['publishable_key'] = stripe_key;	
		$output['secret_key'] = stripe_secret;
		// $output['PayPal_CLIENT_ID'] = PayPal_CLIENT_ID;
		// $output['PayPal_SECRET'] = PayPal_SECRET;
		// $output['PayPal_ENV'] = PayPal_ENV;
		// $output['currency'] = currency;
		//$output['service_tax'] = $this->service_tax;
		//$output['promotion_cost_per_day'] = $this->promotion_cost_per_day;
		$output['status'] = 1;
		$output['message'] = 'Success!'; 
		echo json_encode($output);
	}
	
	*/

	
}
?>