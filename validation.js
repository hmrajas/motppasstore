
$(document).ready(function(){
	//global vars
	var form = $("#customForm");
	var name = $("#name");
	var lastname = $("#lastname");
	var nameInfo = $("#nameInfo");
	var lastnameInfo = $("#lastnameInfo");
	var MessageInfo = $("#MessageInfo");
	var email = $("#email");
	var emailInfo = $("#emailInfo");
	var pass1 = $("#pass1");
	var pass1Info = $("#pass1Info");
	var pass2 = $("#pass2");
	var pass2Info = $("#pass2Info");
	
	var passp1 = $("#passp1");
	var passp1Info = $("#passp1Info");
	var passp2 = $("#passp2");
	var passp2Info = $("#passp2Info");
	
	
	var message = $("#message");
	
		var phone = $("#phone");
	var phoneinfo = $("#phoneinfo");
	
	
	
	//On blur
	name.blur(validateName);
	lastname.blur(validateLastName);
	email.blur(validateEmail);
	pass1.blur(validatePass1);
	pass2.blur(validatePass2);
	passp1.blur(validatePassp1);
	passp2.blur(validatePassp2);
	//On key press
	name.keyup(validateName);
		lastname.keyup(validateLastName);
	pass1.keyup(validatePass1);
	pass2.keyup(validatePass2);
	passp1.keyup(validatePassp1);
	passp2.keyup(validatePassp2);
	message.keyup(validateMessage);
	phone.keyup(validatephone)
	
	//On Submitting
	form.submit(function(){
		if(validateName() & validateLastName() & validateEmail() & validatePass1() & validatePass2()& validatePassp1() & validatePassp2() & validatephone()  &validateMessage())
			return true
		else
			return false;
	});
	
	//validation functions
	function validateEmail(){
		//testing regular expression
		var a = $("#email").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			email.removeClass("error");
			emailInfo.text("Valid E-mail please, you will need it to log in!");
			emailInfo.removeClass("error");
			return true;
		}
		//if it's NOT valid
		else{
			email.addClass("error");
			emailInfo.text("Please provide a valid email address, please!");
			emailInfo.addClass("error");
			return false;
		}
	}
	function validateName(){
		//if it's NOT valid
		if(name.val().length < 2){
			name.addClass("error");
			nameInfo.text("We want names with more than 1 letter!");
			nameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
			nameInfo.text("What's your name?");
			nameInfo.removeClass("error");
			return true;
		}
	}


	function validateLastName(){
		//if it's NOT valid
		if(lastname.val().length < 2){
			lastname.addClass("error");
			lastnameInfo.text("We want last names with more than 1 letter!");
			lastnameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			lastname.removeClass("error");
			lastnameInfo.text("What's your last name?");
			lastnameInfo.removeClass("error");
			return true;
		}
	}



function validatephone(){
		//if it's NOT valid
		if(phone.val().length < 10){
			phone.addClass("error");
			phoneinfo.text("We want phone number with at least 11 digits ");
			phoneinfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			phone.removeClass("error");
			phoneinfo.text("The phone number provided seems to be valid");
			phoneinfo.removeClass("error");
			return true;
		}
	}



	function validatePassp1(){
		var a = $("#password1");
		var b = $("#password2");

		//it's NOT valid
		if(passp1.val().length <8 ){
			passp1.addClass("error");
			passp1Info.text("8 chars minimum , please");
			passp1Info.addClass("error");
			return false;
		}
		//it's valid
		else{			
			passp1.removeClass("error");
			passp1Info.text("8 chars minimum ");
			passp1Info.removeClass("error");
			validatePassp2();
			return true;
		}
	}
	function validatePassp2(){
		var a = $("#password1");
		var b = $("#password2");
		//are NOT valid
		if( passp1.val() != passp2.val() ){
			passp2.addClass("error");
			passp2Info.text("Passphrases dont match!");
			passp2Info.addClass("error");
			return false;
		}
		//are valid
		else{
			passp2.removeClass("error");
			passp2Info.text("Confirm Password");
			passp2Info.removeClass("error");
			return true;
		}
	}
	
	


function validatePass1(){
		var a = $("#password1");
		var b = $("#password2");

		//it's NOT valid
		if(pass1.val().length !=4 ){
			pass1.addClass("error");
			pass1Info.text("4 Digits PIN , please");
			pass1Info.addClass("error");
			return false;
		}
		//it's valid
		else{			
			pass1.removeClass("error");
			pass1Info.text("4 Digits PIN ");
			pass1Info.removeClass("error");
			validatePass2();
			return true;
		}
	}
	function validatePass2(){
		var a = $("#password1");
		var b = $("#password2");
		//are NOT valid
		if( pass1.val() != pass2.val() ){
			pass2.addClass("error");
			pass2Info.text("PINs don't match!");
			pass2Info.addClass("error");
			return false;
		}
		//are valid
		else{
			pass2.removeClass("error");
			pass2Info.text("Confirm PIN");
			pass2Info.removeClass("error");
			return true;
		}
	}
	function validateMessage(){
		//it's NOT valid
		if(message.val().length < 10){
			message.addClass("error");
			MessageInfo.text("Please provide valid init-Secret value");
				MessageInfo.addClass("error");
			return false;
		}
		//it's valid
		else{			
			message.removeClass("error");
				MessageInfo.removeClass("error");
			return true;
		}
	}
});