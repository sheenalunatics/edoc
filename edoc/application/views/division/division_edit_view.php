 <?php
	$attributes = array( 'id' => 'form' , 'name' => 'form' ); 
	//echo validation_errors();
	//foreach($query as $row){    ,'enctype'=>'multipart/form-data'
?>

	  <section id="main"><article class="width_full"> 
 <header>
      <h3 class="tab_name">EDIT DIVISION</h3>
           <!--  <h3 class="tab_manage"><a href="#">Edit</a></h3> -->
 </header>
	<div  class="module_content">
		  <?=form_open('home/division_edit', $attributes)?>
      <table class="tableform">
        <thead>
			<tr>        
            <td class="center" width="15%">Division ID</td>
            <td class="center" width="20%">Name</td>
            <td class="center" width="50%">Detail</td>  
			<td class="center" width="10%">Action</td>  
          </tr>
		</thead>
		<tbody>
		<?php 
		if(!empty($query)){
			foreach($query as $row){ 
			?>
			<tr> 
            <td class="center"><?=$row['division_id'];?></td>
            <td class="center"><?=$row['division_name'];?></td>
            <td class="center"><?=$row['division_detail'];?></td>
			
            <td class="center">[<a href='#' class="btn" onclick='EditInfo("<?=$row['division_id']?>");'>Edit</a>]
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

</article></section>

<script>
function EditInfo(id){
	window.location='<? echo base_url();?>'+'index.php/home/division_edit/'+id;
}

</script>



