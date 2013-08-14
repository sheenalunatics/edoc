<?php
Class User_model extends CI_Model
{

 function login($user_name, $user_pass)
 {
   $this -> db -> select('user_id, user_name, user_pass, user_fname, user_lname, user_position, division_id');
   $this -> db -> from('user');
   $this -> db -> where('user_name = ' . "'" . $user_name . "'");
   $this -> db -> where('user_pass = ' . "'" . $user_pass . "'");
   $this -> db -> limit(1);
	//$sql = "select * from tbl_admin where username='$username' and password = '".MD5($password)."'";
   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

function username_check($user_name)
 {
   $this -> db -> select('user_name');
   $this -> db -> from('user');
   $this -> db -> where('user_name = ' . "'" . $user_name . "'");
  // $this -> db -> where('user_pass = ' . "'" . $user_pass . "'");
   $this -> db -> limit(1);
	//$sql = "select * from tbl_admin where username='$username' and password = '".MD5($password)."'";
   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }
 }

function password_check($password)
 {
   $this -> db -> select('user_pass');
   $this -> db -> from('user');
   //$this -> db -> where('user_name = ' . "'" . $user_name . "'");
   $this -> db -> where('user_pass = ' . "'" . $password . "'");
   $this -> db -> limit(1);
	//$sql = "select * from tbl_admin where username='$username' and password = '".MD5($password)."'";
   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }
 }

function user_getall2($num, $offset)
{
	$this->db->select('user_id,user_name,user_fname,user_lname,user_email,user_position,register_date');
	$query = $this->db->get('user', $num, $offset);	
    if($query -> num_rows() > 0)
   {
     return $query->result_array();
   }
   else
   {
     return false;
   }
} 

function user_info_insert($data)
 {
	
	$ret = $this->db->insert('user', $data); 
	 if($ret == true)
	{
		return true;
	}
	else
	{
		return false;
	}
 } 

 function user_info($id)
 {
   $this -> db -> select('user_id, user_name, user_pass, user_fname, user_lname, userdb_date, usermb_date, useryb_date, id_card, user_email, user_status, user_sex, user_position, division_id');
   $this -> db -> from('user');
   $this -> db -> where('user_id = ' .  $id );
   $this -> db -> limit(1);
	
   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result_array();
   }
   else
   {
     return false;
   }
 } 

  function user_info_update($id,$data)
 {
	$this->db->where('user_id', $id);
	$ret = $this->db->update('user', $data); 
   
   if($ret == true)
   {
     return true;
   }
   else
   {
     return false;
   }
 } 

 function user_info_del($id)
 {
	$this->db->where('user_id', $id);
	$ret = $this->db->delete('user'); 
  
   if($ret == true)
   {
     return true;
   }
   else
   {
     return false;
   }
 }


function user_getlist()
 {
	 $this->db->select('user_id,user_fname,user_lname');
	$this->db->from('user');
	$this->db->order_by('user_id');
	$query = $this->db->get();
	$ret = array();
	if($query -> num_rows() > 0)
   {
		$ret[''] = '';
		foreach($query->result_array() as $row){
            $ret[$row['user_id']] =  $row['user_fname'].' '.$row['user_lname'];//$row['user_id'];
        }
   }
   return $ret;
 } 

}
?>