<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db->query("SET sql_mode = '';");
	} 
	
  public function send_and_insert_notifi($dataArr = array()){
    
    if(!empty($dataArr)){
			
			$other = ($dataArr['other']) ? $dataArr['other'] : array();
    
      $insert['user_id'] = $dataArr['user_id'];
      $insert['message'] = $dataArr['message'];
      $insert['behalf_of'] = ($dataArr['behalf_of']) ? $dataArr['behalf_of'] : 0;
      $insert['other'] = serialize($other);
      $insert['create_date'] = date('Y-m-d H:i:s');
      $insert['update_date'] = date('Y-m-d H:i:s');
      
      if(isset($dataArr['onlyPushNot']) && $dataArr['onlyPushNot']==true) {
        $run = true;
      } else {
        $run = $this->InsertData('notification',$insert);
      }
      
      if($run){
        if(isset($dataArr['device_id']) && !empty($dataArr['device_id'])){
          $deviceToken[] = $dataArr['device_id'];
        
          $arr['title'] = $insert['message'];
          $arr['deviceToken'] = $deviceToken;
          $arr['other'] = $other;
          $this->AndroidNotification($arr);
        }
        return true;
      } else {
        return false;
      }
    }
  }
  public function AndroidNotification($data = array()){
    if(!empty($data)){
      $content = array(
        "en" => $data['title']
      );
     
      $keyvalue = "393a53ef-71d2-4e64-b715-6bd62d55334a";
      $hashes_array = array();
			
			$pushdata = $data['other'];
      
      $fields = array(
        'app_id' => $keyvalue,
        'include_player_ids' => $data['deviceToken'],
        'data' => $pushdata,
        'contents' => $content,
        'web_buttons' => $hashes_array,
        //'android_channel_id' => '64afdb66-02c1-409c-8411-858b12965761',
        //'android_sound' => 'onesignal_default_sound'
      );
      
      $fields = json_encode($fields);
      //print("\nJSON sent:\n");
      //print($fields);
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YjA4MGM3NjQtYjllNi00NzFhLTlhNjUtMGZhMTRjOWQwYjQ1'
      ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
      $response = curl_exec($ch);
      curl_close($ch);
        
      return json_decode($response);
    } else {
      return false;
    }
  }

  public function GetDataByOrderLimit($table,$where,$odf=NULL,$odc=NULL,$limit=NULL,$start=0) {
    if($where) {
      $this->db->where($where);
    }		 

    if($odf && $odc){
      $this->db->order_by($odf,$odc);
    }
       
    if($limit){
      $this->db->limit($limit, $start);
    }

    $sql=$this->db->get($table);
    
    if($sql) {
      return $sql->result_array();
    }else{
      return array();
    }
  }

  public function GetDataById($table,$value) {
    $this->db->where('id', $value);
    $obj=$this->db->get($table);
    //echo $this->db->last_query();die;
    if($obj->num_rows() > 0){
      return $obj->row_array();
    } else {
      return false;
    }
  }
  
  
  public function InsertData($table,$data) {
    $insert = $this->db->insert($table,$data);
     if($insert){
      return $this->db->insert_id();
    }else{
      return false;
    }
  }
  
	
	public function GetAllData($table,$where=null,$ob=null,$obc='DESC',$limit=null,$offset=null,$select=null){
   
		if($select) {
			$this->db->select($select);
		}else{
			$this->db->select('*');
		}
		
		$this->db->from($table);
    if($where) {
      $this->db->where($where);
    }
    if($ob) {
      $this->db->order_by($ob,$obc);
    }
    if($limit) {
      $this->db->limit($limit,$offset);
    }
    $query = $this->db->get();
		// echo   $this->db->last_query();
    if($query->num_rows() > 0) {	
      return $query->result_array();
    } else {
      return array();
    }
  }
 
  public function GetSingleData($table,$where=null,$ob=null,$obc='desc'){
    if($where) {
      $this->db->where($where);
    }
    if($ob) {
      $this->db->order_by($ob,$obc);
    }
    $query = $this->db->get($table);
    if($query->num_rows()) {	
      return $query->row_array();
    } else {
      return false;
    }
  }
  
  public function UpdateData($table, $where, $data) {

    $this->db->where($where);
    $obj=$this->db->update($table,$data);
   // echo $this->db->last_query();die;
    return ($this->db->affected_rows() > 0)?true:true;
  }
  
  public function DeleteData($table, $where) {
    $this->db->where($where);
    $obj=$this->db->delete($table);
    
		return ($this->db->affected_rows() > 0)?true:false;		
  }


  public function GetColumnName($table,$where=null,$name=null,$double=null,$order_by=null,$order_col=null,$group_by=null) {
    if($name){
      $this->db->select(implode(',',$name));
    } else {
      $this->db->select('*');
    }
    
    if($where){
      $this->db->where($where);
    }
		
		if($group_by) {
      $this->db->group_by($group_by);
    }
    
    if($order_by && $order_col){
      $this->db->order_by($order_by,$order_col);
    }
    $sql=$this->db->get($table);
    if($double){
      $data = array();
    } else {
      $data = false;
    }
    if($sql->num_rows() > 0){
      if($double){
        $data = $sql->result_array();
      } else {
        $data = $sql->row_array();
      } 
      
    }
    return $data;
  }

	
  public function SendMail($toz,$sub,$body) {

		
		$headers = "From: ".Project." <".Email."> \n";			
		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    
    $msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
            <tbody>
              <tr>
                <td align="center" valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="600" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
                    <tbody>
                      <tr>
                        <td align="center" valign="top" style="border-bottom:2px solid #66A6FF;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:#ffffff;">
                          <table border="0" cellpadding="0" cellspacing="10" width="100%">
                            <tbody>
                              <tr> 
                                <td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="'.base_url().'"><img src="'.base_url().'assets/site/images/logo.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" valign="top">
                          <table border="0" cellpadding="0" cellspacing="10" width="100%">
                            <tbody>
                              <tr>
                                <td align="left" valign="top" style="color:#444;font-size:14px">
                                  '.$body.'
                                   <p style="margin:0;padding:10px 0px">Thank you,<br>Team '.Project.'</p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" valign="top" style="background-color:#000000;color:white">
                          <table border="0" cellpadding="0" cellspacing="10" width="100%">
                            <tbody>
                              <tr>
                                <td align="left" valign="top" width="80%">
                                  <div style="margin:0;padding:0;color:#fff;font-size:13px"><a href="'.base_url().'/privacy-policy" style="color:white;text-decoration:none">© Copyright '.date('Y').' '.Project . '. All Rights Reserved.</div>
                                </td>
                                
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>';
        
    
    $run  = mail($toz,$sub,$msg,$headers);
    
    if($run) {
      return 1;
    } else {
      return 0;
    }

  }
	
  public function SendMailCustom($toz,$sub,$body) {

    //  $to =$toz;  
    //  $from ='';
    // $headers ="From: ".$admin[0]['mail_from_title']." <".$from."> \n";
    // $headers .= "MIME-Version: 1.0\n";
    // $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
    // $subject =$sub;
    
    $headers = "From: ".Project." <".Email."> \n";      
    
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    
    $run = mail($toz,$sub,$body,$headers);
    if($run) {
      return 1;
    } else {
      return 0;
    }
  }

  public function csrf_token()
  {
    $length = 25;
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $this->session->set_userdata('csrf_token',md5($randomString)); 
  }

  public function convert_number_to_words($number) {
    
    $hyphen      = ' ';
    $conjunction = ' ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
  }

  function birthDate ($number) {
    
    $hyphen      = ' ';
    $conjunction = ' ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'First',
        2                   => 'Second',
        3                   => 'Third',
        4                   => 'Fourth',
        5                   => 'Fifth',
        6                   => 'Sixth',
        7                   => 'Seventh',
        8                   => 'Eighth',
        9                   => 'Nineth',
        10                  => 'Tenth',
        11                  => 'Eleventh',
        12                  => 'Twelveth',
        13                  => 'Thirteenth',
        14                  => 'Fourteenth',
        15                  => 'Fifteenth',
        16                  => 'Sixteenth',
        17                  => 'Seventeenth',
        18                  => 'Eighteenth',
        19                  => 'Nineteenth',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'conver_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->birthDate(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->birthDate($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->birthDate($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->birthDate($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}
}
