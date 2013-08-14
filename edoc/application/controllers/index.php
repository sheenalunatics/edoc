<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user/user_model','',TRUE);
		$this->load->model('report/report_model');
	}
	public function index()
	{	
		$this->form_validation->set_rules('User_name', 'User_name', 'trim|required');
		$this->form_validation->set_rules('User_pass', 'User_pass', 'trim|required|callback_check_database');
		$this->form_validation->set_error_delimiters('<em>','</em>');

		// has the form been submitted and with valid form info (not empty values)
		if($this->input->post('login'))
		{			
			if($this->form_validation->run()==FALSE)
			{
				$this->load->view('signin');			
			}
			else{
				$this->report_userlogin();
				redirect('home');
			}
		}
		
		$this->load->view('signin');
	}

	function check_database($user_pass)
	 {			
		   //Field validation succeeded.  Validate against database
		   $user_name = $this->input->post('User_name');
		
		   //query the database
		   $result = $this->user_model->login($user_name, $user_pass);

		   if($result)
		   {
			 $sess_array = array();
			 foreach($result as $row)
			 {
			   $sess_array = array(
				 'user_id' => $row->user_id,
				 'user_name' => $row->user_name,
				 'user_pass' => $row->user_pass,
				 'user_fname' => $row->user_fname,
				 'user_lname' => $row->user_lname,
				 'user_position' => $row->user_position,
				 'user_division' => $row->division_id
			   );
			   $this->session->set_userdata('logged_in', $sess_array);
			 }
			 return TRUE;
		   }
		   else
		   {
			 $this->form_validation->set_message('check_database', iconv('TIS-620','UTF-8','Username or PasswordäÁè¶Ù¡µéÍ§'));
			 return false;
		   }


	 }

	 function report_userlogin(){
		if($this->session->userdata('logged_in'))
		{
			$arr['doc_log'] = date('Y-m-d h:i:s');
			$arr['report_act'] = 'login';			
			if($arr['report_act'] == 'login'){
				$arr['report_detail'] = 'User Login to System';
			}else if($arr['report_act'] == 'logout'){
				$arr['report_detail'] = 'User Logout from System';
			}else{
				$arr['report_detail'] = '';
			}
			$session_data = $this->session->userdata('logged_in');
			$arr['user_id'] = $session_data['user_id'];	
			$arr['division_id'] = $session_data['user_division'];
		 }

		$this->report_model->report_insert($arr);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */