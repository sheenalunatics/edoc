 <?php
	$attributes = array('class' => 'cmxform', 'id' => 'form1' , 'name' => 'form1' ); 
	if(validation_errors() != false) { echo iconv('TIS-620', 'UTF-8', '<font color="red">ข้อมูลไม่ถูกต้อง</font>'); }
	//foreach($query as $row){ 
?>
 <?=form_open('home/division_add/', $attributes)?>
<section id="main"><article class="width_full"> 
 <header>
      <h3 class="tab_name">NEW DIVISION</h3>
           <!--  <h3 class="tab_manage"><a href="#">Edit</a></h3> -->
 </header>

  <div class="module_content">
    <table width="100%" cellspacing="0" class="tableform">
		<tr>
            <td width="20%"><font color="red">* Required</font></td></tr>
		 <tr>
            <td width="20%" class="mandatory">Division ID</td>
            <td width="80%" class="data"><?=form_input('division_id');?>&nbsp;<?=form_error('division_id');?></td>
        </tr> 
		<tr>
             <td width="20%" class="mandatory">Name</td>
            <td width="80%" class="data"><?=form_input('division_name');?>&nbsp;<?=form_error('division_name');?></td>
        </tr>
		<tr>
		<?php
			$input = array ( "name"=>"division_detail","id"=>"division_detail", "size"=>"60" );
		?>
             <td width="20%" class="data">Detail</td>
            <td width="80%" class="data"><?=form_input($input);?>&nbsp;<?=form_error('division_detail');?></td>
        </tr>
		
		 <tr>
                <td>&nbsp;</td>
                <td>
                <input name="button-submit" type="submit" id="button-submit" value="SUBMIT" />
              <!--  --> <input name="button-cancel" type="button" id="button-cancel" value="RESET" onclick="reset();" />  
                </td>
                </tr>
    </table>
</div>


</article></section> <?=form_close();?> 
<?php
//}

?>  