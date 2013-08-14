<?php //session_start();?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
<title>.: E-Document :.</title>

<?php echo js_asset('jquery.js'); ?>
<?php echo js_asset('jquery.latest.js'); ?>
<?php echo js_asset('jquery-ui.min.js'); ?>
<?php echo css_asset('main.css'); ?>
<?php echo css_asset('jquery-ui.css'); ?>


</head>
<body>
<?php echo $this->load->view('template/header'); ?>
<div id="page" align="center">
<div id="containner">
	 <?php
        if(isset($content_text))echo $content_text;
        if(isset($content_view)){
            if(isset($content_data)){
                foreach($content_data as $key=>$value){$data[$key]=$value;}
                $this->load->view($content_view,$data);	
            }else{
                $this->load->view($content_view);
            }
        }
        ?> 
</div>
</div>
</body>
</html>