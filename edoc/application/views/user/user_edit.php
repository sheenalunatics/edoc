 <?php
	$attributes = array('id' => 'form1' , 'name' => 'form1' ); 
	if(validation_errors() != false) { echo iconv('TIS-620', 'UTF-8', '<font color="red">ข้อมูลไม่ถูกต้อง</font>'); }
	foreach($query as $row){ 
?>
 <?=form_open('home/user_edit/'.$row['user_id'], $attributes)?>
<section id="main"><article class="width_full"> 
 <header>
      <h3 class="tab_name">EDIT USER</h3>
           <!--  <h3 class="tab_manage"><a href="#">Edit</a></h3> -->
 </header>

  <div class="module_content">
    <table width="100%" cellspacing="0" class="tableform">
		<tr>
            <td width="20%"><font color="red">* Required</font></td></tr>
		 <tr>
            <td width="20%" class="data">ID</td>
            <td width="80%" class="data"><?=$row['user_id'];?></td>
        </tr> 
		<tr>
             <td width="20%" class="mandatory">Username</td>
            <td width="80%" class="data"><?=form_input('user_name', $row['user_name']);?>&nbsp;<?=form_error('user_name');?></td>
        </tr>
		<tr>
             <td width="20%" class="mandatory">Password</td>
            <td width="80%" class="data"><?=form_password('user_pass', $row['user_pass']);?>&nbsp;<?=form_error('user_pass');?></td>
        </tr>
		<tr>
            <td width="20%" class="data">First Name</td>
            <td width="80%" class="data"><?=form_input('user_fname', $row['user_fname']);?>&nbsp;<?=form_error('user_fname');?></td>
        </tr>
		<tr>
            <td width="20%" class="data">Last Name</td>
            <td width="80%" class="data"><?=form_input('user_lname', $row['user_lname']);?>&nbsp;<?=form_error('user_lname');?></td>
        </tr>
		<tr>
		<?php 		
				//Setup days
				 $days = array('FALSE' => 'Day');
				 for($i=1;$i<=31;$i++){
					$days[$i] = $i;
				 }
				 //Setup months
				 $months = array('FALSE' => 'Month',
								 '01'  => 'January',
								 '02'  => 'February',
								 '03'  => 'March',
								 '04'  => 'April',
								 '05'  => 'May',
								 '06'  => 'June',
								 '07'  => 'July',
								 '08'  => 'August',
								 '09'  => 'September',
								 '10' => 'October',
								 '11' => 'November',
								 '12' => 'December'
								);

				 //Setup years
				 $start_year = date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")-100)); //Adjust 100 to however many year back you want
				 $years = array('FALSE' => 'Year',);

				 for ($i=$start_year;$i<=date("Y");++$i) {
					$years[$i] = $i;
				}
			
		?>
            <td width="20%" class="data">BirthDay</td>
            <td width="80%" class="data"><?=form_dropdown('Userdb_Date',$days, $row['userdb_date']);?>&nbsp;
										<?=form_dropdown('Usermb_Date',$months,$row['usermb_date']);?>&nbsp;										<?=form_dropdown('Useryb_Date',$years,$row['useryb_date']);?>&nbsp;
										<?=form_error('Userdb_Date');?>&nbsp;<?=form_error('Usermb_Date');?>&nbsp;<?=form_error('Useryb_Date');?>&nbsp;</td>			
        </tr>
		<tr>
            <td width="20%" class="mandatory">ID Card</td>
            <td width="80%" class="data"><?=form_input('id_card', $row['id_card']);?>&nbsp;<?=form_error('id_card');?></td>			
        </tr>
		<tr>
            <td width="20%" class="mandatory">Email</td>
            <td width="80%" class="data"><?=form_input('user_email', $row['user_email']);?>&nbsp;<?=form_error('user_email');?></td>			
        </tr>
		<?php 
			$statuslist = array(
					''  => '-',
                  'Single'  => 'Single',
                  'Married' => 'Married',
				  'Divorce' => 'Divorce'
                );
			$sexlist = array(
				  ''  => '-',
                  'Male'  => 'Male',
                  'Female' => 'Female'
                );
			$positionlist = array(
				  'FALSE'  => '-',
                  'Admin' => 'Admin',
                  'Management' => 'Management',
				  'Staff' => 'Staff'
                );
			?>
		<tr>
            <td width="20%" class="data">Maritial Status</td>
            <td width="80%" class="data"><?=form_dropdown('user_status',$statuslist,$row['user_status']);?>&nbsp;<?=form_error('user_status');?></td>			
        </tr>
		<tr>
            <td width="20%" class="mandatory">Sex</td>
			
            <td width="80%" class="data"><?=form_dropdown('user_sex',$sexlist,$row['user_sex']);?>&nbsp;<?=form_error('user_sex');?></td>			
        </tr>
		<tr>
            <td width="20%" class="mandatory">Position</td>
            <td width="80%" class="data"><?=form_dropdown('user_position',$positionlist,$row['user_position']);?>&nbsp;<?=form_error('user_position');?></td>			
        </tr>
		
		<tr>
            <td width="20%" class="mandatory">Division ID</td>
			<?php
		//if(!empty($query)){
		//	foreach($query as $row){ 
				?>
            <td width="80%" class="data"><?=form_dropdown('division_id',$dvlist,$row['division_id']);?>&nbsp;<?=form_error('division_id');?></td>	
			<?php //} ?>
        </tr>
		
		<!--<tr>
            <td width="20%" class="mandatory">Register Date</td>
            <td width="80%" class="data"><?=form_error('Register_Date')?><?=form_input('Register_Date');?>&nbsp;</td>			
        </tr>-->		
		 <tr>
                <td>&nbsp;</td>
                <td><!-- <?=form_submit('button-add', 'Submit');?>  <?=form_reset('button-reset', 'Reset','id="button-cancel"');?><?//=form_button('button-cancel', 'Cancel');?>-->
                <input name="button-submit" type="submit" id="button-submit" value="SUBMIT" />
              <!--  --> <input name="button-cancel" type="button" id="button-cancel" value="BACK" onclick="goBack();" />  
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
	//alert('<? echo base_url();?>'+'index.php/home/user_info/'+id);
	window.location='<? echo base_url();?>'+'index.php/home/user_edit_view';
}
</script>