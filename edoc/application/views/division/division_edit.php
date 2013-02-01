 <?php
	$attributes = array('id' => 'form1' , 'name' => 'form1' ); 
	if(validation_errors() != false) { echo iconv('TIS-620', 'UTF-8', '<font color="red">ข้อมูลไม่ถูกต้อง</font>'); }
	foreach($query as $row){ 
?>
 <?=form_open('home/division_edit/'.$row['division_id'], $attributes)?>
<section id="main"><article class="width_full"> 
 <header>
      <h3 class="tab_name">EDIT DIVISION</h3>
           <!--  <h3 class="tab_manage"><a href="#">Edit</a></h3> -->
 </header>

  <div class="module_content">
    <table width="100%" cellspacing="0" class="tableform">
		<tr>
            <td width="20%"><font color="red">* Required</font></td></tr>
		 <tr>
            <td width="20%" class="data">ID</td>
            <td width="80%" class="data"><?=$row['division_id'];?></td>
        </tr> 
		<tr>
             <td width="20%" class="mandatory">Name</td>
            <td width="80%" class="data"><?=form_input('division_name', $row['division_name']);?>&nbsp;<?=form_error('division_name');?></td>
        </tr>
		<tr><?php
			$input = array ( "name"=>"division_detail","id"=>"division_detail", "size"=>"60" );
		?>
             <td width="20%" class="data">Detail</td>
            <td width="80%" class="data"><?=form_input($input, $row['division_detail']);?>&nbsp;<?=form_error('division_detail');?></td>
        </tr>
			
		 <tr>
                <td>&nbsp;</td>
                <td>
                <input name="button-submit" type="submit" id="button-submit" value="SUBMIT" />
                <input name="button-cancel" type="button" id="button-cancel" value="BACK" onclick="goBack();" />  
                </td>
                </tr>
    </table>
</div>


</article></section> <?=form_close();?> 
<?php
}

?> 
<script>
function goBack(){
	window.location='<? echo base_url();?>'+'index.php/home/division_edit_view';
}
</script>