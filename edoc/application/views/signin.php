<!DOCTYPE HTML>
<head>
<title>::Log In to E-Document::</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css" type="text/css" />
<script type="text/javascript" src="js/jquery.latest.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.login.js"></script>
</head>
<body>
<div id="head" class="header">
 <img src="<?=base_url();?>assets/images/header_green.png" alt="header" name="head" id="head" width="60%"/>
 <div/>
 <div id="page" align="center">
    <section class="login_wrapper">  
	 <?php
 $attributes = array('class' => 'cmxform', 'id' => 'form_login' , 'name' => 'form_login' ); 
 ?>
<?php if(validation_errors() != false) { iconv('TIS-620', 'UTF-8', 'Username or PasswordäÁè¶Ù¡µéÍ§'); } ?>
	   <?=form_open('index/index/', $attributes)?>
            <table width="100%" cellspacing="0" class="tablelogin">
            <tr>
            <td width="25%">Username:</td>
            <td width="75%">	<?=form_input('User_name', set_value('User_name'));?><font color="red"><?=form_error('User_name')?></font>		
			</td>
            </tr>
            <tr>
            <td>Password:</td>
            <td>			<?=form_password('User_pass');?><font color="red"><?=form_error('User_pass')?></font>	
			</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=form_submit('login', 'LOGIN')?>
              </td>
            </tr>
            </table>  <?=form_close();?>    
	
    </section>    
</div>
</body>
</html>