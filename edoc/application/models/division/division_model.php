<?php
Class Division_model extends CI_Model
{

function division_getlist()
 {
	 $this->db->select('division_id,division_name');
	$this->db->from('division');
	$this->db->order_by('division_id');
	$query = $this->db->get();
	$ret = array();
	if($query -> num_rows() > 0)
   {
		$ret[''] = '';
		foreach($query->result_array() as $row){
            $ret[$row['division_id']] = $row['division_name'];
        }
   }
   return $ret;
 } 

function division_getall()
{
    $this->db->select('Division_Id, Division_Name, Division_Detail');
	$this->db->from('division');
	$query = $this->db->get();
	$ret = array();
	if($query -> num_rows() > 0)
   {
		foreach($query->result_array() as $row){
            $ret[$row['Division_Id']] = $row['Division_Id'];
        }
   }
  	
   return $ret;
} 

function divisionid_check($id)
 {
   $this -> db -> select('division_id');
   $this -> db -> from('division');
   $this -> db -> where('division_id = ' . "'" . $id . "'");
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

 function division_info_insert($data)
 {	
	$ret = $this->db->insert('division', $data); 
	 if($ret == true)
	{
		return true;
	}
	else
	{
		return false;
	}
 } 

function division_getall2($num, $offset)
{
	$this->db->select('division_id,division_name,division_detail');
	$query = $this->db->get('division', $num, $offset);	
    if($query -> num_rows() > 0)
   {
     return $query->result_array();
   }
   else
   {
     return false;
   }
} 

 function division_info($id)
 {
   $this -> db -> select('division_id, division_name, division_detail');
   $this -> db -> from('division');
   $this -> db -> where('division_id = ' .  $id );
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

  function division_info_update($id,$data)
 {
	$this->db->where('division_id', $id);
	$ret = $this->db->update('division', $data); 
   
   if($ret == true)
   {
     return true;
   }
   else
   {
     return false;
   }
 } 

 function division_info_del($id)
 {
	$this->db->where('division_id', $id);
	$ret = $this->db->delete('division'); 
  
   if($ret == true)
   {
     return true;
   }
   else
   {
     return false;
   }
 }

}
?>