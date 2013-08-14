<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller {
	private $sl;
	private $path;
	function __construct()
	 {
	   parent::__construct();

	   if(!$this->input->cookie('template',true)){
			$this->input->set_cookie(array('name'=>'template','value'=>'1','expire' =>'86500'));
		}

		$this->load->database();
		$this->load->model('user/user_model');
		$this->load->model('division/division_model');
		$this->load->model('folder/folder_model');
		$this->load->model('document/document_model');
		$this->load->model('report/report_model');
		$this->sl = '/';
		$this->path = realpath('/AppServ/www'.'/edoc/folder_data');		
		if(!is_dir($this->path)) //create the folder if it's not already exists
		{
		  mkdir('.'.$this->sl.'folder_data',0777,TRUE);
		} 

		//$local = 'Y';
		//if($local == 'Y'){
				//$this->sl = '/';
			    //$this->gallery_path = realpath('/AppServ/www'.'/acorn/image_data/');
		//}{
			
			//$this->sl = '\\';
			//$this->gallery_path = realpath('/home/biwigi/domains/biwigi.com/public_html'.'/demoacorn/image_data/'); 
		//}
	 }

	/* 
			required|matches[field_name]|min_length[x]|max_length[x]|exact_length[x]|alpha|alpha_numeric
			|alpha_dash|numeric|integer|is_natural|is_natural_no_zero|valid_email|valid_emails|valid_ip|valid_base64 
	*/

	public function index()
	{
		
		if($this->session->userdata('logged_in'))
		   {
			  
			 $session_data = $this->session->userdata('logged_in');
			 $data['user_name'] = $session_data['user_name'];		
			 $data['user_id'] = $session_data['user_id'];
			 $data['user_pass'] = $session_data['user_pass'];
			 $data['user_position'] = $session_data['user_position'];
			 

			$data['content_view'] = 'main/home';
			$this->load->view('index',$data);
		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function logout()
	{
	   $this->report_userlogout();
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   redirect('index', 'refresh');
	}

	function report_userlogout(){
		if($this->session->userdata('logged_in'))
		{
			$arr['doc_log'] = date('Y-m-d h:i:s');
			$arr['report_act'] = 'logout';			
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

	function runid(){
		$query = $this->document_model->document_getid();
		$num = 1;
		if(!empty($query)){
			foreach($query as $row)$num = number_format($row['doc_id'])+1;
		}
		
		return str_pad($num, 10, "0", STR_PAD_LEFT);
	}

	function suggest(){
		$ret = $this->document_model->document_docname_all();
		$str = '';
		if(!empty($ret)){
			$i = 0;
			foreach($ret as $row){
				$i = $i+1;
				if($i==1)$str = $row['doc_name'];
				else $str = $str.'|'.$row['doc_name'];
			}
		}
		return $str;
	}

	function delete_rep(){			
		if(empty($user))$user='';
		if(empty($division))$division='';
		if(empty($fromdate))$fromdate='';
		if(empty($todate))$todate='';
		
			if($this->input->post('button-submit'))
			{		
					//$fromdate = date('Y-m-d 00:00:00',strtotime("-30 day"));
					$fromdate = '';
					$todate = date('Y-m-d 23:59:59');
					if($this->input->post('from-datepicker')!=''){
						$fromdate = date('Y-m-d 00:00:00', strtotime($this->input->post('from-datepicker')));
						if($this->input->post('to-datepicker')!=''){
							$todate = date('Y-m-d 23:59:59', strtotime($this->input->post('to-datepicker')));//$this->input->post('to-datepicker');
						}
					}
					$user = $this->input->post('userid_list');
					$division = $this->input->post('divisionid_list');
					$data['query'] = $this->report_model->report_getcreate_searchx($user,$division,$fromdate,$todate);
					//$user = $this->input->post('userid_list');
					//$data['user'] = $this->input->post('userid_list');
				
			}
		
		if($this->session->userdata('logged_in'))
		{			
					$data['dvlist'] = $this->division_model->division_getlist();
					$data['userlist'] = $this->user_model->user_getlist();
					
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'report/delete_rep';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }		
	}

	function history_rep(){			
		if(empty($user))$user='';
		if(empty($division))$division='';
		if(empty($fromdate))$fromdate='';
		if(empty($todate))$todate='';
		
			if($this->input->post('button-submit'))
			{		
					//$fromdate = date('Y-m-d 00:00:00',strtotime("-30 day"));
					$fromdate = '';
					$todate = date('Y-m-d 23:59:59');
					if($this->input->post('from-datepicker')!=''){
						$fromdate = date('Y-m-d 00:00:00', strtotime($this->input->post('from-datepicker')));
						if($this->input->post('to-datepicker')!=''){
							$todate = date('Y-m-d 23:59:59', strtotime($this->input->post('to-datepicker')));//$this->input->post('to-datepicker');
						}
					}
					$user = $this->input->post('userid_list');
					$division = $this->input->post('divisionid_list');
					$data['query'] = $this->report_model->report_get_searchx($user,$division,$fromdate,$todate);
					//$user = $this->input->post('userid_list');
					//$data['user'] = $this->input->post('userid_list');
				
			}
		
		if($this->session->userdata('logged_in'))
		{			
					$data['dvlist'] = $this->division_model->division_getlist();
					$data['userlist'] = $this->user_model->user_getlist();
					
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'report/history_rep';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }		
	}

	function create_rep(){			
		if(empty($user))$user='';
		if(empty($division))$division='';
		if(empty($fromdate))$fromdate='';
		if(empty($todate))$todate='';
		
			if($this->input->post('button-submit'))
			{		
					//$fromdate = date('Y-m-d 00:00:00',strtotime("-30 day"));
					$fromdate = '';
					$todate = date('Y-m-d 23:59:59');
					if($this->input->post('from-datepicker')!=''){
						$fromdate = date('Y-m-d 00:00:00', strtotime($this->input->post('from-datepicker')));
						if($this->input->post('to-datepicker')!=''){
							$todate = date('Y-m-d 23:59:59', strtotime($this->input->post('to-datepicker')));//$this->input->post('to-datepicker');
						}
					}
					$user = $this->input->post('userid_list');
					$division = $this->input->post('divisionid_list');
					$data['query'] = $this->report_model->report_getcreate_searchx($user,$division,$fromdate,$todate);
					//$user = $this->input->post('userid_list');
					//$data['user'] = $this->input->post('userid_list');
				
			}
		
		if($this->session->userdata('logged_in'))
		{			
					$data['dvlist'] = $this->division_model->division_getlist();
					$data['userlist'] = $this->user_model->user_getlist();
					
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'report/create_rep';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }		
	}

	function edit_rep(){			
		if(empty($user))$user='';
		if(empty($division))$division='';
		if(empty($fromdate))$fromdate='';
		if(empty($todate))$todate='';
		
			if($this->input->post('button-submit'))
			{		
					//$fromdate = date('Y-m-d 00:00:00',strtotime("-30 day"));
					$fromdate = '';
					$todate = date('Y-m-d 23:59:59');
					if($this->input->post('from-datepicker')!=''){
						$fromdate = date('Y-m-d 00:00:00', strtotime($this->input->post('from-datepicker')));
						if($this->input->post('to-datepicker')!=''){
							$todate = date('Y-m-d 23:59:59', strtotime($this->input->post('to-datepicker')));//$this->input->post('to-datepicker');
						}
					}
					$user = $this->input->post('userid_list');
					$division = $this->input->post('divisionid_list');
					$data['query'] = $this->report_model->report_getedit_searchx($user,$division,$fromdate,$todate);
					//$user = $this->input->post('userid_list');
					//$data['user'] = $this->input->post('userid_list');
				
			}
		
		if($this->session->userdata('logged_in'))
		{			
					$data['dvlist'] = $this->division_model->division_getlist();
					$data['userlist'] = $this->user_model->user_getlist();
					
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'report/edit_rep';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }		
	}

	function document_search(){	
		$data['suggestions'] = $this->suggest();
		if(empty($data['key_search']))$data['key_search']='';
		$data['query'] = $this->document_model->document_search_all();
		$this->form_validation->set_rules('searchbox', 'Search Document', 'trim|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 //$this->form_validation->set_message('required');
				}else{
					$data['key_search'] = $this->input->post('searchbox');
					$data['query'] = $this->document_model->document_search($data['key_search']);
				
				}
			}
		
		if($this->session->userdata('logged_in'))
		{						
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'document/document_search';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }		
	}

	function document_search_edit(){	
		$data['suggestions'] = $this->suggest();
		if(empty($data['key_search']))$data['key_search']='';
		$data['query'] = $this->document_model->document_search_all();
		$this->form_validation->set_rules('searchbox', 'Search Document', 'trim|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 //$this->form_validation->set_message('required');
				}else{
					$data['key_search'] = $this->input->post('searchbox');
					$data['query'] = $this->document_model->document_search($data['key_search']);
				
				}
			}
		
		if($this->session->userdata('logged_in'))
		{						
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'document/document_search_edit';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }		
	}

	function document_edit($id){
			$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required|max_length[10]|xss_clean');
			$this->form_validation->set_rules('doc_detail', 'Document Detail', 'trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{		
				    $this->form_validation->set_message('required');
				}
				else
				{				
					$data['doc_id'] = $this->input->post('hddoc_id');
					//$data['doc_name'] = $this->input->post('doc_name');
					$data['doc_type'] = $this->input->post('doc_type');
					$data['doc_detail'] = $this->input->post('doc_detail');
					$data['division_id'] = $this->input->post('division_id');
					$data['folder_id'] = $this->input->post('hdfolder_id');
					//$data['doc_path'] = $this->input->post('doc_path');
					//$query = $this->folder_model->folder_info($data['folder_id']);
					//	foreach($query as $row){
					//		$folder_oldname = $row['folder_name'];					
					//	}
					$data['create_document'] = $this->input->post('create_document');
					$data['timestamp'] = date('Y-m-d h:i:s');
					$data['action'] = 'edit';
				   //query the database
					$result = $this->document_model->document_info_update($data['doc_id'],$data);
					if($result)
				    {			
						$this->report($data);
						$this->session->set_flashdata('message', '<font color="green">'.iconv('TIS-620','UTF-8','บันทึกข้อมูลเรียบร้อยแล้ว').'</font>');
					   redirect('home/document_search_edit');
				    }
					else{
						 $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','ไม่สามารถแก้ไขข้อมูลได้').'</font>');
						 redirect('home/document_search_edit');
					}
					
				} 
			}
			
			if($this->session->userdata('logged_in'))
			{				
				$data['dvlist'] = $this->division_model->division_getall();
				$data['fldlist'] = $this->folder_model->folder_getdistall();
				$data['query'] = $this->document_model->document_info($id);
				$session_data = $this->session->userdata('logged_in');
				$data['user_fname'] = $session_data['user_fname'];
				$data['user_lname'] = $session_data['user_lname'];
				$data['user_id'] = $session_data['user_id'];
				$data['user_name'] = $session_data['user_name'];	
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];
				$data['content_view'] = 'document/document_edit';
				$this->load->view('index',$data);
			 }
		   else
		   {
			 //If no session, redirect to login page
			 redirect('index', 'refresh');
		   }
	}

function document_search_delete(){	
		$data['suggestions'] = $this->suggest();
		//echo $data['suggestions'];
		 if(empty($data['key_search']))$data['key_search']='';
		 $data['query'] = $this->document_model->document_search_all();
		$this->form_validation->set_rules('searchbox', 'Search Document', 'trim|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 //$this->form_validation->set_message('required');
					
				}else{
					$data['key_search'] = $this->input->post('searchbox');
					$data['query'] = $this->document_model->document_search($data['key_search']);
				}
				
			}

		if($this->session->userdata('logged_in'))
		{	
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'document/document_search_delete';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }
		
	}
	
	function file_delete($id,$filepath){
		 $result = $this->document_model->document_info_del($id);
		 if($result)
		 {			 
			 unlink($filepath);
		    redirect('home/document_search_delete/');
		 }
    }

	function document_delete($id){
		if($this->session->userdata('logged_in'))
		   {
				$query = $this->document_model->document_info($id);
				foreach($query as $row){
					$data['doc_id'] = $row['doc_id'];
					$data['doc_name'] = $row['doc_name'];
					$data['doc_type'] = $row['doc_type'];
					$data['doc_detail'] = $row['doc_detail'];
					$data['division_id'] = $row['division_id'];
					$data['folder_id'] = $row['folder_id'];	
					$data['doc_path'] = $row['doc_path'];	
				}
				$data['action'] = 'delete';
				$data['timestamp'] = date('Y-m-d h:i:s');				
				$session_data = $this->session->userdata('logged_in');
				$data['create_document'] = $session_data['user_fname'].' '.$session_data['user_lname'];
				$this->file_delete($data['doc_id'],$data['doc_path']);
				$this->report($data);
		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function file_upload($data)
    {
		$query = $this->folder_model->folder_info($data['folder_id']);
		$foldername = 'temp';
		foreach($query as $row){
			$foldername = $row['folder_name'];
		}
    
        $c_upload['upload_path']    =   './folder_data/'.iconv('UTF-8','TIS-620',$foldername);
        $c_upload['allowed_types']  = 'txt|doc|docx|pdf|xls|xlsx|ppt|pptx';
        $c_upload['max_size']       = '10240';
		$c_upload['max_width']      = '2400';
		$c_upload['max_height']     = '1600';
		$c_upload['file_name']	= iconv('UTF-8','TIS-620',$data['doc_name']);

        $this->load->library('upload', $c_upload);
        
        if ($this->upload->do_upload()) { 
             $f = $this->upload->data();
			 $data['doc_path'] = iconv('UTF-8','TIS-620',$f['full_path']);
			 $result = $this->document_model->document_info_insert($data);
			 return true;

        } else {
			$c_upload['error'] = $this->upload->display_errors();
            return $c_upload['error'];
        }
    }

	function document_add(){			
			$this->form_validation->set_rules('doc_id', 'Document ID', 'trim|required|max_length[10]|xss_clean|callback_docid_check');
			$this->form_validation->set_rules('doc_name', 'Document Name', 'trim|required|max_length[30]|xss_clean');
			$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required|max_length[10]|xss_clean');
			$this->form_validation->set_rules('doc_detail', 'Document Detail', 'trim|required|max_length[50]|xss_clean');
			
			$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 $this->form_validation->set_message('required');
				}
				else
				{
					$data['create_document'] = $this->input->post('create_document');
					$data['doc_id'] = $this->input->post('doc_id');
					$data['doc_name'] = $this->input->post('doc_name');
					$data['doc_type'] = $this->input->post('doc_type');
					$data['doc_detail'] = $this->input->post('doc_detail');
					$data['division_id'] = $this->input->post('division_id');
					$data['folder_id'] = $this->input->post('folder_id');
					$data['timestamp'] = date('Y-m-d h:i:s');
					$data['action'] = 'add';
				   //query the database
					  		$err = false;
							$err = $this->file_upload($data);
							if($err==true){	
									$this->report($data);
									$this->session->set_flashdata('message', '<font color="green">'.iconv('TIS-620','UTF-8','บันทึกข้อมูลเรียบร้อยแล้ว').'</font>');
									redirect('home/document_search_edit');
							}else{								
								$this->session->set_flashdata('message', '<font color="red">'.$err.iconv('TIS-620','UTF-8','ไม่สามารถบันทึกข้อมูลได้').'</font>');
								redirect('home/document_search_edit');
							}	
				} 
			}
			
		if($this->session->userdata('logged_in'))
		{	
					$data['runid'] = $this->runid();
					$data['dvlist'] = $this->division_model->division_getall();
					$data['fldlist'] = $this->folder_model->folder_getdistall();
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'document/document_add';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }
	}

	function docid_check() {
		$id = $this->input->post('doc_id');
		$result = $this->document_model->documentid_check($id);
        if($result==true)
		   {	
			 $this->form_validation->set_message('docid_check', iconv('TIS-620', 'UTF-8', 'รหัสนี้ถูกใช้งานแล้ว'));
			 return false;
		   }
		   else
		   {
			 return true;
		   }
	}

	function report($data){
		if($this->session->userdata('logged_in'))
		{
			$arr['doc_log'] = date('Y-m-d h:i:s');
			$arr['doc_id'] = $data['doc_id'];
			$arr['folder_id'] = $data['folder_id']; 
			$arr['division_id'] = $data['division_id'];
			$arr['doc_type'] = $data['doc_type'];
			//$arr['report_detail'] = 
			$arr['report_act'] = $data['action'];			
			if($arr['report_act'] == 'add'){
				$arr['report_detail'] = 'Create New Document';
			}else if($arr['report_act'] == 'edit'){
				$arr['report_detail'] = 'Edit Document';
			}else if($arr['report_act'] == 'delete'){
				$arr['report_detail'] = 'Delete Document';
			}else{
				$arr['report_detail'] = '';
			}
			$session_data = $this->session->userdata('logged_in');
			$arr['user_id'] = $session_data['user_id'];					
		 }

		$this->report_model->report_insert($arr);
	}

	function folder_delete($id){
		if($this->session->userdata('logged_in'))
		   {
				$query = $this->folder_model->folder_info($id);
				foreach($query as $row){
					$data['folder_name'] = $row['folder_name'];
					$data['division_id'] = $row['division_id'];
					$data['folder_id'] = $row['folder_id'];
				}
				$data['action'] = 'delete';
				$data['timestamp'] = date('Y-m-d h:i:s');				
				$session_data = $this->session->userdata('logged_in');
				$data['create_folder'] = $session_data['user_fname'].' '.$session_data['user_lname'];
				 $mkfolder = $this->path.$this->sl.iconv('UTF-8','TIS-620',$data['folder_name']);
			    if(is_dir($mkfolder) && ($this->check_empty_folder($mkfolder))) 
				{				
					$result = $this->folder_model->folder_info_insert($data);
					rmdir($mkfolder);
				   if($result)
				   {						   
					   $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','ลบข้อมูลเรียบร้อย').'</font>');
					   redirect('home/folder_delete_view');
				   }
			   }else{
					 $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','ไม่สามารถลบข้อมูลได้').'</font>');
					 redirect('home/folder_delete_view');
			   }
		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}
//delete all
function rmdir_recursive($dir) {
    $it = new RecursiveDirectoryIterator($dir);
    $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach($it as $file) {
        if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
        if ($file->isDir()) rmdir($file->getPathname());
        else unlink($file->getPathname());
    }
    rmdir($dir);
}

function check_empty_folder ( $folder )
{
	$files = array ();
	if ( $handle = opendir ( $folder ) ) {
		while ( false !== ( $file = readdir ( $handle ) ) ) {
			if ( $file != "." && $file != ".." ) {
				$files [] = $file;
			}
		}
		closedir ( $handle );
	}
	return ( count ( $files ) > 0 ) ? FALSE : TRUE;
}

	function folder_delete_view()
	{		
		if($this->session->userdata('logged_in'))
		   {
				$config['base_url'] = base_url().'index.php/home/folder_delete_view';
				$config['total_rows'] = $this->folder_model->folder_countid_dist();//$this->db->count_all('folder');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->folder_model->folder_getall3($config['per_page'],$this->uri->segment(3));
				$session_data = $this->session->userdata('logged_in');
				$data['user_fname'] = $session_data['user_fname'];
				$data['user_lname'] = $session_data['user_lname'];
				$data['user_name'] = $session_data['user_name'];		
				$data['user_id'] = $session_data['user_id'];
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];				
				$data['content_view'] = 'folder/folder_delete_view';
				$this->load->view('index',$data);
		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function folder_edit($id){			
		$this->form_validation->set_rules('folder_name', 'Folder Name', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-submit'))
		{			
			if($this->form_validation->run()==FALSE)
			{		
			   $this->load->view('folder/folder_edit');		
			}
			else
			{				
				$data['folder_name'] = $this->input->post('folder_name');
				$data['division_id'] = $this->input->post('division_id');
				$data['folder_id'] = $this->input->post('hdfolder_id');
				$query = $this->folder_model->folder_info($data['folder_id']);
					foreach($query as $row){
						$folder_oldname = $row['folder_name'];					
					}
				$data['create_folder'] = $this->input->post('create_folder');
				$data['timestamp'] = date('Y-m-d h:i:s');
				$data['action'] = 'edit';
			   //query the database
			    $mkfolder = $this->path.$this->sl.iconv('UTF-8','TIS-620',$data['folder_name']);
			    $mkfolder_old = $this->path.$this->sl.iconv('UTF-8','TIS-620',$folder_oldname);
			    if($this->check_empty_folder($mkfolder_old))
				{	
					if(is_dir($mkfolder)){
						 $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','ชื่อแฟ้มเอกสารซ้ำซ้อน ไม่สามารถแก้ไขข้อมูลได้').'</font>');
						redirect('home/folder_edit_view');
					}
					else{
					   $result = $this->folder_model->folder_info_insert($data);
					   rename($mkfolder_old,$mkfolder);
					   if($result)
					   {			 
							$this->session->set_flashdata('message', '<font color="green">'.iconv('TIS-620','UTF-8','บันทึกข้อมูลเรียบร้อย').'</font>');
						   redirect('home/folder_edit_view');
					   }
					}
				}else{
					 $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','แฟ้มเอกสารถูกใช้งาน ไม่สามารถแก้ไขข้อมูลได้').'</font>');
					 redirect('home/folder_edit_view');
				}
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{				
					$data['dvlist'] = $this->division_model->division_getall();
					$data['query'] = $this->folder_model->folder_info($id);
					$session_data = $this->session->userdata('logged_in');
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_id'] = $session_data['user_id'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'folder/folder_edit';
					$this->load->view('index',$data);
				 }
			   else
			   {
				 //If no session, redirect to login page
				 redirect('index', 'refresh');
			   }
	}

	function folder_edit_view()
	{		
		if($this->session->userdata('logged_in'))
		   {
			//$this->load->library('pagination');
				$config['base_url'] = base_url().'index.php/home/folder_edit_view';
				$config['total_rows'] = $this->folder_model->folder_countid_dist();
				//$config['total_rows'] = $this->folder_model->count_all('folder');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);
			
				$data['query'] = $this->folder_model->folder_getall3($config['per_page'],$this->uri->segment(3));
				
				$session_data = $this->session->userdata('logged_in');
				$data['user_fname'] = $session_data['user_fname'];
				$data['user_lname'] = $session_data['user_lname'];
				$data['user_name'] = $session_data['user_name'];		
				$data['user_id'] = $session_data['user_id'];
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];
				
				$data['content_view'] = 'folder/folder_edit_view';
				$this->load->view('index',$data);

		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function folder_add(){				
			$this->form_validation->set_rules('folder_id', 'Folder ID', 'trim|required|max_length[5]|xss_clean|callback_folderid_check');
			$this->form_validation->set_rules('folder_name', 'Folder Name', 'trim|required|max_length[20]|xss_clean|callback_foldername_check');
			$this->form_validation->set_rules('division_id', 'Division ID', 'trim|required|xss_clean');
			
			$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 $this->form_validation->set_message('required');
				}
				else
				{
					$data['create_folder'] = $this->input->post('create_folder');
					$data['folder_id'] = $this->input->post('folder_id');
					$data['folder_name'] = $this->input->post('folder_name');
					$data['division_id'] = $this->input->post('division_id');
					$data['timestamp'] = date('Y-m-d h:i:s');
					$data['action'] = 'add';
				   //query the database
				   $result = $this->folder_model->folder_info_insert($data);

				   if($result)
				   {	 
					    $mkfolder = $this->path.$this->sl.iconv('UTF-8','TIS-620',$data['folder_name']);
					   if(!is_dir($mkfolder)) //create the folder if it's not already exists
						{
						   mkdir($mkfolder,0777,TRUE);
						}
					    $this->session->set_flashdata('message', '<font color="green">'.iconv('TIS-620','UTF-8','บันทึกข้อมูลเรียบร้อย').'</font>');
					   redirect('home/folder_edit_view');
				   }
				} 
			}
			
		if($this->session->userdata('logged_in'))
		{	
					$data['dvlist'] = $this->division_model->division_getall();
					$session_data = $this->session->userdata('logged_in');
					$data['user_id'] = $session_data['user_id'];
					$data['user_fname'] = $session_data['user_fname'];
					$data['user_lname'] = $session_data['user_lname'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'folder/folder_add';
					$this->load->view('index',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }
	}

	function foldername_check(){
		 $fld = $this->input->post('folder_name');
		 $mkfolder = $this->path.$this->sl.$fld;
		 if(is_dir($mkfolder)) //create the folder if it's already exists
		 {
			 $this->form_validation->set_message('foldername_check', '<font color="red">'.iconv('TIS-620','UTF-8','ชื่อแฟ้มเอกสารซ้ำซ้อน').'</font>');		
			 return false;
		 }
		 else
		   {
			 return true;
		   }		
	}

	function folderid_check() {
    $id = $this->input->post('folder_id');
	$result = $this->folder_model->folderid_check($id);
       
        if($result==true)
		   {	
			 $this->form_validation->set_message('folderid_check', iconv('TIS-620', 'UTF-8', 'รหัสนี้ถูกใช้งานแล้ว'));
			 return false;
		   }
		   else
		   {
			 return true;
		   }
	}

	function user_delete_view()
	{		
		if($this->session->userdata('logged_in'))
		   {
			//$this->load->library('pagination');
				$config['base_url'] = base_url().'index.php/home/user_delete_view';
				$config['total_rows'] = $this->db->count_all('user');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->user_model->user_getall2($config['per_page'],$this->uri->segment(3));
				$session_data = $this->session->userdata('logged_in');
				 $data['user_name'] = $session_data['user_name'];		
				 $data['user_id'] = $session_data['user_id'];
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];
				
				$data['content_view'] = 'user/user_delete_view';
				$this->load->view('index',$data);

		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function user_delete($id){
		 $result = $this->user_model->user_info_del($id);
		 if($result)
		 {			 
		   $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','ลบข้อมูลเรียบร้อย').'</font>');
		   redirect('home/user_delete_view');
		  }
	}

	function user_edit_view()
	{
		
		if($this->session->userdata('logged_in'))
		   {
			//$this->load->library('pagination');
				$config['base_url'] = base_url().'index.php/home/user_edit_view';
				$config['total_rows'] = $this->db->count_all('user');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->user_model->user_getall2($config['per_page'],$this->uri->segment(3));
				$session_data = $this->session->userdata('logged_in');
				 $data['user_name'] = $session_data['user_name'];		
				 $data['user_id'] = $session_data['user_id'];
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];
				
				$data['content_view'] = 'user/user_edit_view';
				$this->load->view('index',$data);

		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function user_edit($id){			
		//$this->form_validation->set_rules('user_id', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_pass', 'Password', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('id_card', 'ID Card', 'trim|required|numeric|max_length[13]|xss_clean');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|max_length[50]|valid_email|xss_clean');
		$this->form_validation->set_rules('user_sex', 'Sex', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_position', 'Position', 'trim|required|xss_clean');
		$this->form_validation->set_rules('division_id', 'Division ID', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-submit'))
		{			
			if($this->form_validation->run()==FALSE)
			{		
			   $this->load->view('user/user_edit');		
			}
			else
			{
				//$data['user_id'] = $this->input->post('user_id');
				$data['user_name'] = $this->input->post('user_name');
				$data['user_pass'] = $this->input->post('user_pass');
				$data['user_fname'] = $this->input->post('user_fname');
				$data['user_lname'] = $this->input->post('user_lname');				
				$data['Userdb_Date'] = $this->input->post('Userdb_Date');
				$data['Usermb_Date'] = $this->input->post('Usermb_Date');
				$data['Useryb_Date'] = $this->input->post('Useryb_Date');
				$data['id_card'] = $this->input->post('id_card');
				$data['user_email'] = $this->input->post('user_email');					
				$data['user_sex'] = $this->input->post('user_sex');					
				$data['user_position'] = $this->input->post('user_position');
				$data['division_id'] = $this->input->post('division_id');
				//$data['Register_Date'] = date('Y-m-d h:i:s');
			   //query the database
			   $result = $this->user_model->user_info_update($id,$data);

			   if($result)
			   {			 
				   $this->session->set_flashdata('message', '<font color="green">'.iconv('TIS-620','UTF-8','บันทึกข้อมูลเรียบร้อย').'</font>');
				   redirect('home/user_edit_view');
			   }
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{				
					//$data['grplist'] = $this->user_model->user_group_getall();
					//$this->load->view('user/user_edit',$data);
					$data['query'] = $this->user_model->user_info($id);
					//$session_data = $this->session->userdata('logged_in');
					$data['dvlist'] = $this->division_model->division_getall();
					$session_data = $this->session->userdata('logged_in');
					 $data['user_id'] = $session_data['user_id'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'user/user_edit';
					$this->load->view('index',$data);
				 }
			   else
			   {
				 //If no session, redirect to login page
				 redirect('index', 'refresh');
			   }
	}
	
	function user_add(){				
			$this->form_validation->set_rules('user_id', 'ID', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|xss_clean|callback_username_check');
			$this->form_validation->set_rules('user_pass', 'Password', 'trim|required|min_length[4]|xss_clean|callback_password_check');
			//$this->form_validation->set_rules('user_fname', 'First Name', 'trim|xss_clean');
			//$this->form_validation->set_rules('user_lname', 'Last Name', 'trim|xss_clean');
			//$this->form_validation->set_rules('Userdb_Date', 'Userdb_Date', 'trim|xss_clean');
			//$this->form_validation->set_rules('Usermb_Date', 'Usermb_Date', 'trim|xss_clean');
			//$this->form_validation->set_rules('Useryb_Date', 'Useryb_Date', 'trim|xss_clean');
			$this->form_validation->set_rules('id_card', 'ID Card', 'trim|required|numeric|max_length[13]|xss_clean');
			$this->form_validation->set_rules('user_email', 'Email', 'trim|required|max_length[50]|valid_email|xss_clean');
			$this->form_validation->set_rules('user_sex', 'Sex', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_position', 'Position', 'trim|required|xss_clean');
			$this->form_validation->set_rules('division_id', 'Division ID', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('User_Status', 'Maritial Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 $this->form_validation->set_message('required');
				}
				else
				{
					$data['user_id'] = $this->input->post('user_id');
					$data['user_name'] = $this->input->post('user_name');
					$data['user_pass'] = $this->input->post('user_pass');
					$data['user_fname'] = $this->input->post('user_fname');
					$data['user_lname'] = $this->input->post('user_lname');				
					$data['Userdb_Date'] = $this->input->post('Userdb_Date');
					$data['Usermb_Date'] = $this->input->post('Usermb_Date');
					$data['Useryb_Date'] = $this->input->post('Useryb_Date');
					$data['id_card'] = $this->input->post('id_card');
					$data['user_email'] = $this->input->post('user_email');					
					$data['user_sex'] = $this->input->post('user_sex');					
					$data['user_position'] = $this->input->post('user_position');
					$data['division_id'] = $this->input->post('division_id');
					$data['Register_Date'] = date('Y-m-d h:i:s');
				   //query the database
				   $result = $this->user_model->user_info_insert($data);

				   if($result)
				   {	
						$this->session->set_flashdata('message', '<font color="green">'.iconv('TIS-620','UTF-8','บันทึกข้อมูลเรียบร้อย').'</font>');
					   redirect('home/user_edit_view');
				   }
				} 
			}
			
		if($this->session->userdata('logged_in'))
		{	
					$data['dvlist'] = $this->division_model->division_getall();
					$session_data = $this->session->userdata('logged_in');
					 $data['user_id'] = $session_data['user_id'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'user/user_add';
					$this->load->view('index',$data);
					//$this->load->view('home_view',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }
	}

	function username_check() {
   // echo $id;
    $username = $this->input->post('user_name');
	$result = $this->user_model->username_check($username);
       
        if($result==true)
		   {	
			 $this->form_validation->set_message('username_check', iconv('TIS-620', 'UTF-8', 'Username นี้ถูกใช้งานแล้ว'));
			 return false;
		   }
		   else
		   {
			 return true;
		   }
}

	function password_check() {
   // echo $id;
    $password = $this->input->post('user_pass');
	$result = $this->user_model->password_check($password);
       
        if($result==true)
		   {	
			 $this->form_validation->set_message('password_check', iconv('TIS-620', 'UTF-8', 'รหัสนี้ถูกใช้งานแล้ว'));
			 return false;
		   }
		   else
		   {
			 return true;
		   }
	}

	function division_delete_view()
	{		
		if($this->session->userdata('logged_in'))
		   {
				$config['base_url'] = base_url().'index.php/home/division_delete_view';
				$config['total_rows'] = $this->db->count_all('division');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->division_model->division_getall2($config['per_page'],$this->uri->segment(3));
				$session_data = $this->session->userdata('logged_in');
				 $data['user_id'] = $session_data['user_id'];
				 $data['user_name'] = $session_data['user_name'];	
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];				
				$data['content_view'] = 'division/division_delete_view';
				$this->load->view('index',$data);

		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}

	function division_delete($id){
		 $result = $this->division_model->division_info_del($id);
		 if($result)
		 {			 
		   $this->session->set_flashdata('message', '<font color="red">'.iconv('TIS-620','UTF-8','ลบข้อมูลเรียบร้อย').'</font>');
		   redirect('home/division_delete_view');
		  }
	}

	function division_edit($id){			
		$this->form_validation->set_rules('division_name', 'Name', 'trim|required|max_length[30]|xss_clean');
		$this->form_validation->set_rules('division_detail', 'Detail', 'trim|max_length[50]|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-submit'))
		{			
			if($this->form_validation->run()==FALSE)
			{		
			   $this->load->view('division/division_edit');		
			}
			else
			{
				//$data['user_id'] = $this->input->post('user_id');
				$data['division_name'] = $this->input->post('division_name');
				$data['division_detail'] = $this->input->post('division_detail');
				
			   //query the database
			   $result = $this->division_model->division_info_update($id,$data);

			   if($result)
			   {			 
				   redirect('home/division_edit_view');
			   }
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{				
					//$data['grplist'] = $this->user_model->user_group_getall();
					//$this->load->view('user/user_edit',$data);
					$data['query'] = $this->division_model->division_info($id);
					$session_data = $this->session->userdata('logged_in');
					 $data['user_id'] = $session_data['user_id'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'division/division_edit';
					$this->load->view('index',$data);
				 }
			   else
			   {
				 //If no session, redirect to login page
				 redirect('index', 'refresh');
			   }
	}

	function division_edit_view()
	{		
		if($this->session->userdata('logged_in'))
		   {
			//$this->load->library('pagination');
				$config['base_url'] = base_url().'index.php/home/division_edit_view';
				$config['total_rows'] = $this->db->count_all('division');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->division_model->division_getall2($config['per_page'],$this->uri->segment(3));
				$session_data = $this->session->userdata('logged_in');
				 $data['user_id'] = $session_data['user_id'];
				 $data['user_name'] = $session_data['user_name'];		
				//$data['userid'] = $session_data['userid'];
				$data['user_pass'] = $session_data['user_pass'];
				$data['user_position'] = $session_data['user_position'];				
				$data['content_view'] = 'division/division_edit_view';
				$this->load->view('index',$data);

		   }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	}


	function division_add(){				
			$this->form_validation->set_rules('division_id', 'Division ID', 'trim|required|max_length[5]|xss_clean|callback_divisionid_check');
			$this->form_validation->set_rules('division_name', 'Name', 'trim|required|max_length[30]|xss_clean');
			$this->form_validation->set_rules('division_detail', 'Detail', 'trim|max_length[50]|xss_clean');
			
			$this->form_validation->set_error_delimiters('<em>','</em>');
			if($this->input->post('button-submit'))
			{			
				if($this->form_validation->run()==FALSE)
				{	
					 $this->form_validation->set_message('required');
				}
				else
				{
					$data['division_id'] = $this->input->post('division_id');
					$data['division_name'] = $this->input->post('division_name');
					$data['division_detail'] = $this->input->post('division_detail');
					
				   //query the database
				   $result = $this->division_model->division_info_insert($data);

				   if($result)
				   {			 
					   redirect('home/division_edit_view');
				   }
				} 
			}
			
		if($this->session->userdata('logged_in'))
		{	
					//$data['dvlist'] = $this->division_model->division_getall();
					$session_data = $this->session->userdata('logged_in');
					 $data['user_id'] = $session_data['user_id'];
					$data['user_name'] = $session_data['user_name'];	
					$data['user_pass'] = $session_data['user_pass'];
					$data['user_position'] = $session_data['user_position'];
					$data['content_view'] = 'division/division_add';
					$this->load->view('index',$data);
					//$this->load->view('home_view',$data);
		 }
		else
		 {
			 redirect('index', 'refresh');
		 }
	}

	function divisionid_check() {
    $id = $this->input->post('division_id');
	$result = $this->division_model->divisionid_check($id);
       
        if($result==true)
		   {	
			 $this->form_validation->set_message('divisionid_check', iconv('TIS-620', 'UTF-8', 'รหัสนี้ถูกใช้งานแล้ว'));
			 return false;
		   }
		   else
		   {
			 return true;
		   }
}
/***********************************category section******************************************/

function catename_check() {  
		$str = $this->input->post('CategoryName_En');
		if ($str == '') {
			 $this->form_validation->set_message('catename_check', 'The %s is require!');
			 return FALSE;
		}
		else {
		return TRUE;
		}
	}
	
/***********************************product section******************************************/
 function product(){
		 if($this->session->userdata('logged_in'))
		 {
			    $limit = 10;
				$terms = array();
				$uri_segment = 3; 
				$offset = $this->uri->segment($uri_segment,'');	
				// assign posted valued
				$data['ProductCode'] = $this->input->post('ProductCode');
				$data['ProductName_En']      = $this->input->post('ProductName_En');		
				$data['Description']    = $this->input->post('Description');
				// gets total URI segments
				$total_seg = $this->uri->total_segments();	
				// set search params
				// enters here only when 'Search' button is pressed or through 'Paging'
				if(isset($_POST['search']) || $total_seg>3){
					
					$default = array('ProductCode', 'ProductName_En', 'Description');
					if($total_seg > 3){
						
 						// navigation from paging
						$terms = $this->uri->uri_to_assoc(3,$default); 
							
						for($i=0;$i<count($default);$i++){										
							if($terms[$default[$i]] == 'unset'){
								$terms[$default[$i]] = '';						
								$this->terms_uri[$default[$i]] = 'unset'; 
							}else{
								$this->terms_uri[$default[$i]] = $this->terms[$default[$i]];		
							}									
						}	

					
					// When the page is navigated through paging, it enters the condition below
						if(($total_seg % 2) > 0){					 		 
							// exclude the last array item (i.e. the array key for page number), prepare array for database query
							$terms = array_slice($terms, 0 , (floor($total_seg/2)-1));					
		 
							$offset = $this->uri->segment($total_seg, '');		
							$uri_segment = $total_seg;
						}

						// Convert associative array $this->terms_uri to segments to append to base_url
						$keys = $this->uri->assoc_to_uri($this->terms_uri);		
		 
						$data['query'] = $this->product_model->get_search_pagedlist($terms,$limit, $offset);
						$config['total_rows'] = $this->product_model->count_all_search($terms);		
 
						$terms = array();								// resetting terms array
						$this->terms_uri = array();							// resetting terms_uri array
				
					}else{
					// navigation through POST search button 
						$searchparams_uri = array();

						for($i=0;$i<count($default);$i++){
							if($this->input->post($default[$i]) != ''){						
								$searchparams_uri[$default[$i]] = $this->input->post($default[$i]);
								$data[$default[$i]] = $this->input->post($default[$i]);						
							}else{										
								$searchparams_uri[$default[$i]] = 'unset';
								$data[$default[$i]] = '';						
							}
						}			
 
						// Replace all the 'unset' values in an associative array to null value and create a new array '$searchparams' for database processing
						foreach($searchparams_uri as $k=>$v){
							if($v != 'unset'){
								$searchparams[$k] = $v;
							}else{
								$searchparams[$k] = '';
							}	
						}					
 
						$data['query'] = $this->product_model->get_search_pagedlist($searchparams,$limit, $offset);
	 
						// turn associative array to segments to append to base_url
						$keys = $this->uri->assoc_to_uri($searchparams_uri);	
	 
						// set total_rows config data for pagination			
						$config['total_rows'] = $this->product_model->count_all_search($searchparams);
					}

				}else{
					// load data
					$data['query'] = $this->product_model->get_paged_list($limit, $offset);
		 
					// set total_rows config data for pagination
					$config['total_rows'] = $this->db->count_all('tbl_product');
					$searchparams = "";
					$keys = "";
				}	

				// generate pagination
				//$this->load->library('pagination'); 
				$config['base_url'] = site_url('home/product').'/'.$keys.'/';
  				$config['per_page'] = $limit;
				$config['uri_segment'] = $uri_segment;
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);
			
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['userid'] = $session_data['userid'];
				$data['password'] = $session_data['password'];
				$data['usergroup'] = $session_data['usergroup'];
				$data['side_app'] = "product";
				$data['content_view'] = 'product/product_view';
				$this->load->view('home_view',$data);
				
				 }
		   else
		   {
			 redirect('index', 'refresh');
		   }
	
	}

function product_delete_image($pid,$id,$name){
		 $result = $this->product_model->product_imgdel($id);
		 if($result)
		 {			 
			 unlink($this->gallery_path.$this->sl.$name);
			 unlink($this->gallery_path.$this->sl.'thumbn_'.$name);  
		   redirect('home/product_image/'.$pid);
		 }
		

}

 
/*----------------------*/

   function getsubcate($id) {
		
		$subcatelst = $this->state_city_model->get_cities_from_state($id);
		if($subcatelst != false){
			echo form_error('SubCategory');
			echo form_dropdown('SubCategory', $subcatelst);
		}

   }

	function subcate_check() {  
		$str = $this->input->post('SubCategory');
		if ($str == '-') {
			 $this->form_validation->set_message('subcate_check', 'The %s is require!');
			 return FALSE;
		}
		else {
			return TRUE;
		}
	}

	function productname_check() {  
    $str = $this->input->post('ProductName_En');
    if ($str == '') {
         $this->form_validation->set_message('productname_check', 'The %s is require!');
         return FALSE;
    }
    else {
    return TRUE;
    }
}

function product_info($id,$cate,$subcate){
	
		if($this->session->userdata('logged_in'))
				{	
				    $data = array(
							 'dir' => array(
							 'original' => '../image_data/',
							 'thumb' => '../image_data/'
											 ),
							'images' => array(),
							 'error' => ''
					);
					$fileimg = $this->product_model->product_getimgname($id);				
					$i = 0;
					if(!empty($fileimg)){
						foreach ($fileimg as $row) {
							$data['images'][$i]['thumb'] =$row['ImageThumnail'];
							$data['images'][$i]['original'] = str_replace('thumbn_', '', $row['ImageThumnail']);
							$i++;
						}
					}else{
							$data['images'][0]['thumb'] = 'thumbn_no_image.jpg';
							$data['images'][0]['original'] = str_replace('thumbn_', '',  'thumbn_no_image.jpg');
					}
					$data['subcate'] = $this->product_model->product_getsubcatename($subcate);
					$data['cate'] = $this->product_model->product_getcatename($cate);
					$data['query'] = $this->product_model->product_info($id);
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$data['userid'] = $session_data['userid'];
					$data['password'] = $session_data['password'];
					$data['usergroup'] = $session_data['usergroup'];
					$data['side_app'] = "product";
					$data['content_view'] = 'product/product_info';
					$this->load->view('home_view',$data);
				 }
			   else
			   {
				 redirect('index', 'refresh');
			   }
}

/***********************************customer section******************************************/
 function customer(){
		 if($this->session->userdata('logged_in'))
		   {
				//$this->load->library('pagination');
				$config['base_url'] = base_url().'index.php/home/customer/';
				$config['total_rows'] = $this->db->count_all('tbl_customer');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->customer_model->customer_getall2($config['per_page'],$this->uri->segment(3));

				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['userid'] = $session_data['userid'];
				$data['password'] = $session_data['password'];
				$data['usergroup'] = $session_data['usergroup'];
				$data['side_app'] = "customer";
				$data['content_view'] = 'customer/customer_view';
				$this->load->view('home_view',$data);
			}
		   else
		   {
			 //If no session, redirect to login page
			 redirect('index', 'refresh');
		   }
	
	}

function customer_info($id){
			$data['flagbtn'] =  $this->customer_model->customer_shipping_info($id);
				if(empty($data['flagbtn'])){
					$data['flagbtn'] = 'Add';
				}else{
					$data['flagbtn'] = 'Edit';
				}
			if($this->session->userdata('logged_in'))
		   {				
				
				$data['query'] = $this->customer_model->customer_info_shipping($id);
				$data['CustomerID'] = $id;
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['userid'] = $session_data['userid'];
				$data['password'] = $session_data['password'];
				$data['usergroup'] = $session_data['usergroup'];
				$data['side_app'] = "customer";
				$data['content_view'] = 'customer/customer_info';
				$this->load->view('home_view',$data);
				 }
		   else
		   {
			 redirect('index', 'refresh');
		   }	
	}

function customer_reset_pwd($id){
				$data['flagbtn'] =  $this->customer_model->customer_shipping_info($id);
				if(empty($data['flagbtn'])){
					$data['flagbtn'] = 'Add';
				}else{
					$data['flagbtn'] = 'Edit';
				}
		   if($this->session->userdata('logged_in'))
		   {
				if($this->customer_model->customer_reset_passwd($id)==true){	
					$this->session->set_flashdata('message', '<font color="green">Password Reset Success!</font>');	
				}
				else{
					$this->session->set_flashdata('message', '<font color="red">Password Reset Failed!</font>');
				}
				
				$data['query'] = $this->customer_model->customer_info_shipping($id);
				$data['CustomerID'] = $id;
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['userid'] = $session_data['userid'];
				$data['password'] = $session_data['password'];
				$data['usergroup'] = $session_data['usergroup'];
				$data['side_app'] = "customer";
				$data['content_view'] = 'customer/customer_info';
				$this->load->view('home_view',$data);
			}
		   else
		   {
			 //If no session, redirect to login page
			 redirect('index', 'refresh');
		   }
	
	}

function customer_edit_info($id){	
		$this->form_validation->set_rules('CustomerGroup', 'CustomerGroup', 'xss_clean|trim|required');
		$this->form_validation->set_rules('FirstName_En', 'FirstName_En', 'xss_clean|trim|required|max_length[50]');
		$this->form_validation->set_rules('LastName_En', 'LastName_En', 'xss_clean|trim|required|max_length[50]');
		$this->form_validation->set_rules('FirstName_Th', 'FirstName_Th', 'xss_clean|trim|max_length[50]');
		$this->form_validation->set_rules('LastName_Th', 'LastName_Th', 'xss_clean|trim|max_length[50]');
		$this->form_validation->set_rules('Email', 'Email', 'xss_clean|trim|max_length[150]|valid_mail');
		$this->form_validation->set_rules('Phone', 'Phone', 'xss_clean|trim|max_length[150]');
		$this->form_validation->set_rules('Address', 'Address', 'xss_clean|trim|max_length[250]');
		$this->form_validation->set_rules('Province', 'Province', 'xss_clean|trim');
		$this->form_validation->set_rules('Zipcode', 'Zipcode', 'xss_clean|trim|max_length[20]');
		$this->form_validation->set_rules('Mobile', 'Mobile', 'xss_clean|trim|max_length[20]');
		$this->form_validation->set_rules('Gender', 'Gender', 'xss_clean|trim|required');
		$this->form_validation->set_rules('Status', 'Status', 'xss_clean|trim|required');
		$this->form_validation->set_rules('days', 'days', 'trim');
		$this->form_validation->set_rules('months', 'months', 'trim');
		$this->form_validation->set_rules('years', 'years', 'trim');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-submit'))
		{			
			if($this->form_validation->run()==FALSE)
			{		
				$this->form_validation->set_message('required');
			   //$this->load->view('customer/customer_edit_info');		
			}
			else
			{
				

				$data['FirstName_En'] = $this->input->post('FirstName_En');
				$data['LastName_En'] = $this->input->post('LastName_En');
				$data['FirstName_Th'] = $this->input->post('FirstName_Th');
				$data['LastName_Th'] = $this->input->post('LastName_Th');
				$data['Email'] = $this->input->post('Email');
				$data['Phone'] = $this->input->post('Phone');
				$data['Address'] = $this->input->post('Address');
				$data['Province'] = $this->input->post('Province');
				$data['Zipcode'] = $this->input->post('Zipcode');
				$data['Mobile'] = $this->input->post('Mobile');
				$data['Gender'] = $this->input->post('Gender');
				$data['Status'] = $this->input->post('Status');
				$data['RegisterDate'] = $this->input->post('years').'-'.$this->input->post('months').'-'.$this->input->post('days');
				$data['RegisterDate'] = date('Y-m-d H:i:s', strtotime($data['RegisterDate']));
			   //query the database
			   $result = $this->customer_model->customer_info_update($id,$data);

			   if($result)
			   {			 
				   redirect('home/customer');
			   }
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{				
					$data['provincelst'] = $this->customer_model->customer_province_getall();
					$data['query'] = $this->customer_model->customer_info($id);
					$data['CustomerID'] = $id;
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$data['userid'] = $session_data['userid'];
					$data['password'] = $session_data['password'];
					$data['usergroup'] = $session_data['usergroup'];
					$data['side_app'] = "customer";
					$data['content_view'] = 'customer/customer_edit_info';
					$this->load->view('home_view',$data);
				 }
			   else
			   {
				 //If no session, redirect to login page
				 redirect('index', 'refresh');
			   }
	}

function firstname_check() {
   // echo $id;
    $str = $this->input->post('FirstName_Enx');
    if ($str == '') {
         $this->form_validation->set_message('firstname_check', 'The %s is require!');
         return FALSE;
    }
    else {
    return TRUE;
    }
}

	function customer_delete($id){
			 //query the database
		 $this->customer_model->shipping_del($id);
		 $result = $this->customer_model->customer_info_del($id);
		 if($result)
		 {			 
		   redirect('home/customer');
		  }
	}


/***********************************user section********************************************
	function user(){
		 if($this->session->userdata('logged_in'))
		   {
				//$this->load->library('pagination');
				$config['base_url'] = base_url().'index.php/home/user/';
				$config['total_rows'] = $this->db->count_all('tbl_admin');
				$config['per_page'] = '10';
				$config['full_tag_open'] = '<p>';
				$config['full_tag_close'] = '</p>';
				$this->pagination->initialize($config);

				$data['query'] = $this->user_model->user_getall2($config['per_page'],$this->uri->segment(3));
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['userid'] = $session_data['userid'];
				$data['password'] = $session_data['password'];
				$data['usergroup'] = $session_data['usergroup'];
				$data['side_app'] = "user";
				$data['content_view'] = 'user/user_view';
				$this->load->view('home_view',$data);
				 }
		   else
		   {
			 //If no session, redirect to login page
			 redirect('index', 'refresh');
		   }
	
	}

	function user_info($id){
			if($this->session->userdata('logged_in'))
		   {				
				$data['query'] = $this->user_model->user_info($id);
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['userid'] = $session_data['userid'];
				$data['password'] = $session_data['password'];
				$data['usergroup'] = $session_data['usergroup'];
				$data['side_app'] = "user";
				$data['content_view'] = 'user/user_info';
				$this->load->view('home_view',$data);
				 }
		   else
		   {
			 //If no session, redirect to login page
			 redirect('index', 'refresh');
		   }
	
	}

	function user_edit($id){	
		
		$this->form_validation->set_rules('username', 'username', 'xss_clean|trim|required');
		$this->form_validation->set_rules('fullname', 'fullname', 'xss_clean|trim|required|max_length[100]');
		$this->form_validation->set_rules('email', 'email', 'xss_clean|trim|required|max_length[150]|valid_email');
		$this->form_validation->set_rules('groupname', 'groupname', 'xss_clean|trim|required');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-submit'))
		{			
			if($this->form_validation->run()==FALSE)
			{		
			   $this->load->view('user/user_edit');		
			}
			else
			{
				$data['username'] = $this->input->post('username');
				$data['fullname'] = $this->input->post('fullname');
				$data['email'] = $this->input->post('email');
				$data['groupname'] = $this->input->post('groupname');
			   //query the database
			   $result = $this->user_model->user_info_update($id,$data);

			   if($result)
			   {			 
				   redirect('home/user');
			   }
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{				
					$data['grplist'] = $this->user_model->user_group_getall();
					//$this->load->view('user/user_edit',$data);
					$data['query'] = $this->user_model->user_info($id);
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$data['userid'] = $session_data['userid'];
					$data['password'] = $session_data['password'];
					$data['usergroup'] = $session_data['usergroup'];
					$data['side_app'] = "user";
					$data['content_view'] = 'user/user_edit';
					$this->load->view('home_view',$data);
				 }
			   else
			   {
				 //If no session, redirect to login page
				 redirect('index', 'refresh');
			   }
	}


	function user_delete($id){
			 //query the database
		 $result = $this->user_model->user_info_del($id);
		 if($result)
		 {			 
		   redirect('home/user');
		  }
	}

	function user_add(){			
		$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[150]|valid_email|xss_clean');
		$this->form_validation->set_rules('groupname', 'groupname', 'trim|required');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-add'))
		{			
			if($this->form_validation->run()==FALSE)
			{	
				 $this->form_validation->set_message('required');
			}
			else
			{
				$data['username'] = $this->input->post('username');
				$data['password'] = MD5($this->input->post('password')) ;
				$data['fullname'] = $this->input->post('fullname');
				$data['email'] = $this->input->post('email');
				$data['groupname'] = $this->input->post('groupname');
				$data['createdate'] = date('Y-m-d h:i:s');
			   //query the database
			   $result = $this->user_model->user_info_insert($data);

			   if($result)
			   {			 
				   redirect('home/user');
			   }
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{				
					$data['grplist'] = $this->user_model->user_group_getall();
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$data['userid'] = $session_data['userid'];
					$data['password'] = $session_data['password'];
					$data['usergroup'] = $session_data['usergroup'];
					$data['side_app'] = "user";
					$data['content_view'] = 'user/user_add';
					$this->load->view('home_view',$data);
				 }
			   else
			   {
				 redirect('index', 'refresh');
			   }
	}


	function user_changepwd($id){	
		$this->form_validation->set_rules('old_password', 'old_password', 'trim|required|xss_clean|callback_user_oldpass_check');
		$this->form_validation->set_rules('new_password', 'new_password', 'trim|required|xss_clean|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		if($this->input->post('button-submit'))
		{			
			if($this->form_validation->run()==FALSE)
			{		
			  // $this->form_validation->set_message('required');
			  // $this->form_validation->set_message('matches');
			}
			else
			{
				$data['password'] = MD5($this->input->post('new_password'));			
			   //query the database
			   $result = $this->user_model->user_pwd_update($id,$data);

			   if($result)
			   {			 
				   redirect('home');
			   }
			} 
		}
			
			if($this->session->userdata('logged_in'))
				{	
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$data['userid'] = $session_data['userid'];
					$data['password'] = $session_data['password'];
					$data['usergroup'] = $session_data['usergroup'];
					$data['side_app'] = "user";
					$data['content_view'] = 'user/user_changepwd';
					$this->load->view('home_view',$data);
				 }
			   else
			   {
				 //If no session, redirect to login page
				 redirect('index', 'refresh');
			   }
	}

	function user_oldpass_check()
    {
		$old_password = MD5($this->input->post('old_password'));
		$result = $this->user_model->user_check_oldpassword($old_password);
       
        if($result==true)
		   {			
			 return TRUE;
		   }
		   else
		   {
			 $this->form_validation->set_message('user_oldpass_check', 'Invalid old password!');
			 return false;
		   }
    }
*/
}