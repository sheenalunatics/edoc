<?php
Class Document_model extends CI_Model
{

function document_info_insert($data)
 {
	
	$ret = $this->db->insert('document', $data); 
	 if($ret == true)
	{
		return true;
	}
	else
	{
		return false;
	}
 } 


function documentid_check($id)
 {
   $this -> db -> select('doc_id');
   $this -> db -> from('document');
   $this -> db -> where('doc_id = ' . "'" . $id . "'");
   $this -> db -> limit(1);
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

 function document_countid_dist()
 {
	$this->db->distinct();
	$this->db->select('document_id');
	$this->db->from('document');
	$query = $this -> db -> get();
	return $query -> num_rows();	    
 } 

function document_search($key)
 {
	 $this->db->select('doc_id,doc_name,doc_type,doc_detail,division_id,folder_id,timestamp,action,create_document,doc_path');
	$this->db->from('document');
	$this->db->like('doc_id', $key);
	$this->db->or_like('doc_name', $key); 
	$this->db->or_like('doc_type', $key); 
	$this->db->or_like('doc_detail', $key); 
	$this->db->order_by('doc_id');
	$query = $this->db->get();
	if($query -> num_rows() > 0)
	   {
		 return $query->result_array();
	   }
	   else
	   {
		 return false;
	   }
 } 


function document_search_all()
 {
	 $this->db->select('doc_id,doc_name,doc_type,doc_detail,division_id,folder_id,timestamp,action,create_document,doc_path');
	$this->db->from('document');
	//$this->db->like('doc_id', $key);
	//$this->db->or_like('doc_name', $key); 
	//$this->db->or_like('doc_type', $key); 
	//$this->db->or_like('doc_detail', $key); 
	$this->db->order_by('doc_id');
	$query = $this->db->get();
	if($query -> num_rows() > 0)
	   {
		 return $query->result_array();
	   }
	   else
	   {
		 return false;
	   }
 } 

 function document_docname_all()
 {
	 $this->db->select('doc_name');
	$this->db->from('document');
	//$this->db->like('doc_id', $key);
	//$this->db->or_like('doc_name', $key); 
	//$this->db->or_like('doc_type', $key); 
	//$this->db->or_like('doc_detail', $key); 
	//$this->db->order_by('doc_id');
	$query = $this->db->get();
	if($query -> num_rows() > 0)
	   {
		 return $query->result_array();
	   }
	   else
	   {
		 return false;
	   }
 } 

function document_info($id)
 {
   $this -> db -> select('doc_id,doc_name,doc_type,doc_detail,division_id,folder_id,timestamp,action,create_document,doc_path');
   $this -> db -> from('document');
   $this -> db -> where('doc_id = ' .  $id );
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

function document_getid()
 {
   $this -> db -> select('doc_id');
   $this -> db -> from('document');
   //$this -> db -> where('doc_id = ' .  $id );
   $this -> db -> order_by('doc_id','desc');
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

 function document_info_del($id)
 {
	$this->db->where('doc_id', $id);
	$ret = $this->db->delete('document'); 
  
   if($ret == true)
   {
     return true;
   }
   else
   {
     return false;
   }
 }

 function document_info_update($id,$data)
 {
	$this->db->where('doc_id', $id);
	$ret = $this->db->update('document', $data); 
   
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