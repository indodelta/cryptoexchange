$(document).ready(function() {
    /*  Activate/Deactivate status */        
    jQuery(".select_all").click(function(){
        if(jQuery(this).is(':checked')){
            jQuery(".checkbox").each(function(){
                if(!jQuery(this).is(':checked')){
                    jQuery(this).click();
                }
            });
        }else{
            jQuery(".checkbox").each(function(){
                if(jQuery(this).is(':checked')){
                    jQuery(this).click();
                }
            });
        }
    });

    jQuery(".checkbox").click(function(){
        if(jQuery(this).is(':checked') == false){
            if(jQuery(".select_all").is(':checked')){
                jQuery(".select_all").prop("checked",false);
            }
        }
    });

    jQuery(".req_action").click(function(){
        var action = jQuery(this).val();
        var tbl = jQuery(this).data("tbl");
        var function_name = "";
        if(jQuery(this).data("action") != ""){
            function_name = jQuery(this).data("action");
        }

        jQuery(".app_req").each(function(){
            var id = jQuery(this).attr("id");
            if(jQuery("#chk_"+id).is(':checked')){
                requestAction(id,action,tbl,function_name);
            }
        });
    });


    //image Zoom
    $('.zoomex').click(function() {            
        var path = $(this).children('img').first().attr('src');        
        $('#zoom').attr('src', path);
    });  


    $('.update_action').click(function() {            
        var data_key = $(this).data("key");
        var csrf_token = jQuery("#csrf-token").val(); 
        var function_name = $(this).data("action");
        $.ajax({
            type:"post",
            url:"/organize/"+function_name,
            data:{data_key:data_key,_token:csrf_token},
            success:function(data){
                       window.location.reload();
            }
        });    
    }); 


    $('.update_auth').change(function() {      
        var data_key = $(this).val(); 
        var csrf_token = $("#csrf-token").val();
        var key = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to undo 2FA status!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type:"post",
                            url:"/organize/update_auth",
                            data:{data_key:data_key,_token:csrf_token},
                            success:function(data){
                                       window.location.reload();
                            }
                        });
                    }else{    
                        $("#"+key).bootstrapToggle('on')
                    }
                });
    

    }); 

        
    //for date picker    
    $('#datetimepicker1').datepicker();    
    $('#datetimepicker2').datepicker();
	
    $('#userName').selectpicker();


    $('.value_model').click(function() {   
        var par  = $(this).val();
        var data_key  = $("#"+par+"dk").val();
        var tb   = $("#"+par+"tb").val();
        var ts   = $("#"+par+"ts").val();
        var tp   = $("#"+par+"tp").val();
        var ta   = $("#"+par+"ta").val();
        var csrf_token = $("#csrf-token").val();
        $.ajax({
            type:"post",
            url:"/organize/update_rate",
            data:{data_key:data_key,tb:tb,ts:ts,tp:tp,ta:ta,_token:csrf_token},
            success:function(data){
                       window.location.reload();
            }
        });  
    });




    $('.add').click(function () {
        $(this).prev().val(+$(this).prev().val() + 1);
    });
    $('.sub').click(function () {
        if ($(this).next().val() > -50) $(this).next().val(+$(this).next().val() - 1);
    });
    
    $('.suba').click(function () {
        if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
    });


});

function requestAction(rec_id,value,tbl,function_name="update_userstatus"){
    var status = value == 0 ? 1 : 0;
    var csrf_token = jQuery("#csrf-token").val(); 
    $.ajax({
	    type:"post",
	    url:"/organize/"+function_name,
	    data:{id:rec_id,status:status,tbl:tbl,_token:csrf_token},
        success:function(data){
                   window.location.reload();
        }
    });


}


window.onload = function(){   
    var csrf_token = $("#csrf-token").val(); 
    $.ajax({
        type:"post",
        url:"/organize/select_user",
        data:{_token:csrf_token},
        dataType:"json",
        success:function(data){
                var len = data.length;         

                var userData ="<option value=''>Select User</option>";
                for(i=0;i<len;i++){
                   userData += '<option value='+data[i].user_id +'>'+data[i].username+'</option>';
                } 

                document.getElementById("userName").innerHTML = userData; 
                $('#userName').selectpicker('refresh');              
        }

    });
}


function refamt(){   
    var csrf_token = $("#csrf-token").val(); 
    var user_token = $("#userName").val();     
    $.ajax({
        type:"post",
        url:"/organize/select_ref_amt",
        data:{user_token:user_token,_token:csrf_token},
        dataType:"json",
        success:function(data){
                var len = data.length;               
                var userData ="<option value=''>Select</option>";
                for(i=0;i<len;i++){
                   userData += '<option value='+data[i].refamtid+'>'+data[i].amount+'</option>';
                } 
                document.getElementById("ref_amount_id").innerHTML = userData;
        }
    });
}

function successAlert(message){
   swal("Success", message, "success");
}

function errorAlert(message){
   swal("Error", message, "error");
}

function errorAlert2(message){
   swal("Error", message, "error");
}

