<div id="head" class="header">
 <img src="<?=base_url();?>assets/images/header_green.png" alt="header" name="head" id="head" width="60%"/>
 <br />
    <p> <ul class="menu">
<li  class="home"><a href="<?=base_url();?>index.php/home"><b></b></a></li>
<?php 
	if($user_position == "Admin") {
?>
<li><a href="#"><b>Master Management</b></a>
	<ul>
		<li><a href="#">Manage User Data</a>
			<ul>
				<li><a href="<?=base_url();?>index.php/home/user_add">Add New User</a></li>
				<li><a href="<?=base_url();?>index.php/home/user_edit_view">Edit User</a></li>
				<li><a href="<?=base_url();?>index.php/home/user_delete_view">Delete User</a></li>
			</ul>
		</li>
		<li><a href="#">Manage Division Data</a>
			<ul>
				<li><a href="<?=base_url();?>index.php/home/division_add">Add New Division</a></li>
				<li><a href="<?=base_url();?>index.php/home/division_edit_view">Edit Division</a></li>
				<li><a href="<?=base_url();?>index.php/home/division_delete_view">Delete Division</a></li>
			</ul>
		</li>
		<li><a href="#">Manage Folder Data</a>
			<ul>
				<li><a href="<?=base_url();?>index.php/home/folder_add">Add New Folder</a></li>
				<li><a href="<?=base_url();?>index.php/home/folder_edit_view">Edit Folder</a></li>
				<li><a href="<?=base_url();?>index.php/home/folder_delete_view">Delete Folder</a></li>
			</ul>
		</li>
	</ul>
	
</li>
<li><a href="<?=base_url();?>index.php/home/document_add"><b>New Document</b></a></li>
<li><a href="<?=base_url();?>index.php/home/document_search_edit/"><b>Edit Document</b></a></li>
<li><a href="<?=base_url();?>index.php/home/document_search_delete" ><b>Delete Document</b></a></li>
<?php
	}
?>
<li><a href="<?=base_url();?>index.php/home/document_search" ><b>Search Document</b></a></li>
<?php
	if($user_position != "Staff") {
?>
<li><a href="#" ><b>Report</b></a>
	<ul>
		<li><a href="<?=base_url();?>index.php/home/history_rep">History Report</a></li>
		<li><a href="<?=base_url();?>index.php/home/create_rep">Create Report</a></li>
		<li><a href="<?=base_url();?>index.php/home/edit_rep">Edit Report</a></li>
		<li><a href="<?=base_url();?>index.php/home/delete_rep">Delete Report</a></li>
	</ul>
</li>
<?php
	}
?>
<li><a href="<?=base_url();?>index.php/home/logout" ><b>Logout [<?=$user_name;?>]</b></a></li>

</ul></p>
  
  </div>
