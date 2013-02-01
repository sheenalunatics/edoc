$(document).ready(function(){
	
	function Validate_Email(Val) {
	  var objRegExp  = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	  return objRegExp.test(Val);
	}	
	
	$("#Username").focus();
	$("#form_login").submit(function(){
		if($("#Username").val()==""){ 
			alert('Please complete your username'); 
			$('#Username').focus(); 
			return false;
		}
		if($("#Password").val()==""){ 
			alert('Please complete your password'); 
			$("#Password").focus(); 
			return false;
		}
		$.post('login.php',{
			'Username':$("#Username").val(),
			'Password':$("#Password").val()
		},
		function(data){
			if(data.status==false){
				alert("Login failed! Incorrect username or password.");
				$("#Password").val('');
				$("#Password").focus();
				return false;
			}
			else{
				window.location.href=data.page;
			}
		},'json');
		return false;
	});
	
	$("#button-submit-forgot").click(function(){
		var ForgotEmail=$("#ForgotEmail");
		if(!ForgotEmail.val()){
			alert("Please complete your email address");
			ForgotEmail.focus();
			return false;
		}
		
		if(ForgotEmail.val() && !Validate_Email(ForgotEmail.val())){
			alert("Please enter a valid email address");
			ForgotEmail.focus();
			return false;
		}
		
		if(confirm("Please confirm your email address")){
			$("#button-section").hide();
			$("#forgetting").show();
			var Val = $('#form_forgot').serialize();
			$.ajax({
				type : 'POST',
				url : 'forgot.php',
				data : Val,
				success : function(data) {
					if(data==true){
						alert("Password has been sent to your email address.");
						document.form_forgot.reset();
						$("#form_forgot").hide();
						$("#form_login").show();
					}else{
						document.form_forgot.reset();
						alert("Invalid email address. Please try again...");
					}
					$("#forgetting").hide();
					$("#button-section").show();
				}
			});
		}
	});
	
	$("#forgotpassword").click(function(){
		$("#form_login").hide();
		$("#form_forgot").show();
		$("#ForgotEmail").focus();
	});

	$("#forgotpassword-cancel").click(function(){
		$("#form_forgot").hide();
		$("#form_login").show();
		$("#Username").focus();
	});

});
