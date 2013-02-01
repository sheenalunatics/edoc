 <?php
	$attributes = array( 'id' => 'form' , 'name' => 'form' ); 
	//echo validation_errors();
	//foreach($query as $row){    ,'enctype'=>'multipart/form-data'
?>

<!--<div id="content">
	<div class="box"> -->
	  <!-- <div class="left"></div>
	  <div class="right"></div>
	 <div class="heading">
		<h1 style="background-image: url('<?php echo base_url();?>assets/images/user.png')">User</h1>
		 <div class="buttons"><a href="<?=base_url()."index.php/home/user_add";?>" class="button"><span>Register User</span></a>
		//<a onclick="$('form').submit();" class="button"><span>Delete</span></a> </div>
	  </div>-->
	  <section id="main"><article class="width_full"> 
 <header>
      <h3 class="tab_name">DELETE USER</h3>
           <!--  <h3 class="tab_manage"><a href="#">Edit</a></h3> -->
 </header>
	<div  class="module_content">
		  <?=form_open('home/user_delete', $attributes)?>
      <table class="tableform">
        <thead>
			<tr>        
            <td class="center" width="10%">UserID</td>
            <td class="center" width="10%">Username</td>
            <td class="center" width="25%">Name</td>
			 <td class="center" width="25%">Email</td>
			 <td class="center" width="10%">Position</td>
			  <td class="center" width="15%">RegisterDate</td> 
			  <td class="center" width="5%"> Action</td>   
          </tr>
		</thead>
		<tbody>
		<?php 
		if(!empty($query)){
			foreach($query as $row){ 
			?>
			<tr> 
            <td class="center"><?=$row['user_id'];?></td>
            <td class="center"><?=$row['user_name'];?></td>
            <td class="center"><?=$row['user_fname'].' '.$row['user_lname'];?></td>
			<td class="center"><?=$row['user_email'];?></td>
			<td class="center"><?=$row['user_position'];?></td>
			<td class="center"><?=dateconvertTH($row['register_date']);?></td>
			
            <td class="center"><!--[ <a href='#' onclick='ViewInfo("<?=$row['user_name']?>");'>View</a> ]-->[<a href='#' class="btn" onclick='DelInfo("<?=$row['user_id']?>");'>Delete</a>]<!--[ <a href='#' onclick='DelInfo("<?=$row['user_name']?>");'>Delete</a> ]-->
              </td>
          </tr>
		<?php 
		} 	}
			?>
		</tbody>
	  </table>
        <?=form_close();?> 
		<div class="pagination"><div class="results"><?php echo $this->pagination->create_links(); ?></div></div>
		<div><br />
			<?php if($this->session->flashdata('message')) : ?>
		<p><?=$this->session->flashdata('message')?></p>
		<?php endif; ?>
		</div>
	</div>
<!--	</div>
</div>-->
</article></section>
<?php

function dateconvertTH($Date){
	if($Date=="0000-00-00 00:00:00")return;
	$ExpDate=explode("-",$Date);
	switch($ExpDate[1]):
		case "01": $Month="January"; break;
		case "02": $Month="February"; break;
		case "03": $Month="March"; break;
		case "04": $Month="April"; break;
		case "05": $Month="May"; break;
		case "06": $Month="June"; break;
		case "07": $Month="July"; break;
		case "08": $Month="August"; break;
		case "09": $Month="September"; break;
		case "10": $Month="October"; break;
		case "11": $Month="November"; break;
		case "12": $Month="December"; break;
	endswitch;
	$NewDate=$ExpDate[2][0]."".$ExpDate[2][1]." ".$Month." ".($ExpDate[0]);
	return $NewDate;
}

?>
<script>
//function ViewInfo(id){
//	window.location='<? echo base_url();?>'+'index.php/home/user_info/'+id;
//}
//function EditInfo(id){
//	window.location='<? echo base_url();?>'+'index.php/home/user_edit/'+id;
//}
function DelInfo(id){
	if(confirm('<? echo iconv("TIS-620", "UTF-8", "ต้องการลบ?");?>')){
		window.location='<? echo base_url();?>'+'index.php/home/user_delete/'+id;
	}
	else{
		return false;
	}	
}
</script>



