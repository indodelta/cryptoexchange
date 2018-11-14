$(document).ready(function() {

	/*$("#submitlogin").on("click",function(e){

		var email 	 = $("#email").val();
		var password = $("#password").val();

		if(email==''){
			e.preventDefault();
			$("#error-alertl").html('<div class="alert alert-danger fade in close-alert" id="error-alert">Email Id is required.</div>');		
		}else if(password==''){
			e.preventDefault();	
			$("#error-alertl").html('<div class="alert alert-danger fade in close-alert" id="error-alert">Password is required.</div>');
		}
	});	*/

    $("#login_detail").bootstrapValidator({
        fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">Email is required</p>'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">Password is required</p>'
                        }
                    }
                }
        }

    }).on('success.form.bv', function(e) {});

	$("#user_details").bootstrapValidator({
		fields: {
			    first_name: {
                    validators: {
                        notEmpty: {
                            message: 'First Name is required'
                        }
                    }
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: 'Address is required'
                        }
                    }
                },
               	city: {
                    validators: {
                        notEmpty: {
                            message: 'City is required'
                        }
                    }
                },
                state: {
                    validators: {
                        notEmpty: {
                            message: 'State is required'
                        }
                    }
                },
                country: {
                    validators: {
                        notEmpty: {
                            message: 'Country is required'
                        }
                    }
                },
                zipcode: {
                    validators: {
                        notEmpty: {
                            message: 'Zipcode is required'
                        }
                    }
                },
                mobileNo: {
                    validators: {
                        notEmpty: {
                            message: 'Mobile number is required'
                        },                      
                        integer: {
                        	message: 'Please enter valid mobile number'
                      	},
                      	stringLength: {
                       		min: 10,
                        	max: 10,
                        	message: 'Please enter 10 digit mobile number'
                   		}
                    }
                }

		}

	}).on('success.form.bv', function(e) {
		// e.preventDefault();
  //       var $form = $(e.target);
  //       var bv = $form.data('bootstrapValidator');

	});

    $("#user_register").bootstrapValidator({
        fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">The user name is required</p>'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">The email is required</p>'
                        },
                        emailAddress: {
                            message: '<p style="color:red">Please Enter Valid Email Address</p>'
                        },
                        remote: {
                            message: '<p style="color:red">This Email already exits</p>',
                            url: '/validateemail'
                        } 
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">The password is required</p>'
                        },
                        stringLength: {
                            min: 6,                            
                            message: '<p style="color:red">Min length is 6</>'
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">The confirm password is required</p>'
                        },
                        identical: {
                            field: 'password',
                            message: '<p style="color:red">The password and its confirm password should be same</p>'
                        }
                    }
                },
                term_service: {
                    validators: {
                        notEmpty: {
                            message: '<p style="color:red">Please accept term of servies</p>'
                        }
                    }
                }
        }

    }).on('success.form.bv', function(e) {
        // e.preventDefault();
  //       var $form = $(e.target);
  //       var bv = $form.data('bootstrapValidator');

    });    

    $(".validate_gcode").click(function () {
        gvalidate();
    });
    $(".formtoken").on("submit",function (e) {
        e.preventDefault();
        gvalidate();
    });


    $("#uploadfile").on("submit",function(e){

        e.preventDefault();
            $.ajax({
                url: "/verify_kyc",
                type: "POST",
                data:  new FormData(this),
                contentType: false,       
                cache: false,              
                processData:false,
                success: function(data){                    
                    if(data['success']==1){
                         window.location="user_authenticat";
                     }
                }                
            });
    });

    $("#username").focusout(function(){
        if(validateForm($(this).val(),$("#username"))){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "/check_username",
                type: "POST",
                data:  {'username':$(this).val(),'_token':token},
                success: function(resp){
                    console.log(resp);
                    if(resp==0){
                        $("#username").focus().siblings(".err").text("Sorry!! this username already exists");
                    }else{
                        $("#username").siblings(".err").text("");
                    }
                }                
            });
        }
    });
    $("#username").keyup(function(){
        $("#username").val($(this).val().replace(/ /g,'').toLowerCase());
    });
    $("#login_detail").submit(function () {
        $("#login").removeAttr("disabled");
        return check_captcha();
    });
    $("#submitbtn").click(function () {
       return check_captcha();
    });
});

function gvalidate(){
    var token = $(".formtoken input[name='_token']").val();
    $.ajax({
        url: "/validate2fa",
        type: "POST",
        data:  {'_token':token,'totp':$(".totp").val(),'ajax':'1'},
        success: function(resp){              
            if(resp==0){
                $(".err").text("Sorry!! code not matched");    
            }else if(resp==1){
                window.location.href = "/funding";    
            }else{
                window.location.href = "/";    
            }
        }                
    });
}

function check_captcha() {
    var $captcha = $( '#recaptcha' ),
    response = grecaptcha.getResponse();
    if (response.length === 0) {
        $( '.captch_err').text( "reCAPTCHA is mandatory" );
        $captcha.css( "border","1px solid red" );
        return false;           
    }
}


function validateForm(username,element){
    if (username.match(/^[a-z0-9]+$/g) && username.length >=5 && username.length <=12) {
        element.siblings(".err").text("");
        return true;        
    }else{
        element.siblings(".err").text("Only a-z, 0-9, minimum 5 and maximum 12 characters are acceptable.");
        element.focus();
        return false;     
    }
}