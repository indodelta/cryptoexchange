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



    //image user doc
    $('.zoomexx').click(function() {            
        var path = $(this).children('img').first().attr('src');        
        $('#zoomkyc').attr('src', path);
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



    $('.update-value').click(function() {            
        var data_key = $(this).val();
        var csrf_token = $("#csrf-token").val(); 
        var data_action = $(this).data("action");
        var data_mode = $(this).data("mode");
        $.ajax({
            type:"post",
            url:"/organize/update_withdrawal_request",
            data:{data_key:data_key,data_action:data_action,data_mode:data_mode,_token:csrf_token},
            success:function(data){
                    if(data==1){
                       window.location.reload();
                    }
            }
        });    
    });


    $('.dataMessage').click(function() {       
        var name    = $(this).data("name");
        var email   = $(this).data("email");
        var inquiry = $(this).data("inquiry");
        var subject = $(this).data("subject");
        var message = $(this).data("message");
        var phn_no  = $(this).data("phone");
        $(".name").text(name);  
        $(".email").text(email); 
        $(".phn_no").text(phn_no); 
        $(".inquiry").text(inquiry); 
        $(".subject").text(subject); 
        $(".message").text(message);       
    });




    //GLOBEL
    $('#trading_price').click(function(e) {
        e.preventDefault();
        var csrf_token = $("#csrf-token").val(); 
        var buy  = $("#buy").val();
        var sell = $("#sell").val();

        $.ajax({
            type:"post",
            url:"/organize/trading_price",
            data:{buy:buy,sell:sell,_token:csrf_token},
            success:function(data){
                swal("Success", 'Updated All Trading price', "success");
                     setTimeout(function(){
    location.reload();
},3000);
            }
        }); 
      


    });

    //GLOBEL
    $('#ticker_price').click(function(e) {
        e.preventDefault();
        var csrf_token = $("#csrf-token").val(); 
        var ask  = $("#ask").val();
        var bid = $("#bid").val();

        $.ajax({
            type:"post",
            url:"/organize/ticker_price",
            data:{ask:ask,bid:bid,_token:csrf_token},
            success:function(data){
                swal("Success", 'Updated All Ticker price', "success");
                      setTimeout(function(){
    location.reload();
},3000);
            }
        }); 
      


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

window.onload = function () {
    get_data();
    //line_chart();
}

function get_data(){
    var csrf_token  = $("#csrf-token").val(); 
    $.ajax({
        type:"post",
        url:"/organize/get_data",
        data:{_token:csrf_token},
        success:function(data){
                    $(".tdu").html(parseFloat(data[0].today_deposit).toFixed(2));
                    $(".ttd").html(parseFloat(data[0].total_deposit).toFixed(2));
                    $(".twu").html(parseFloat(data[0].today_withdrawal).toFixed(2));
                    $(".ttw").html(parseFloat(data[0].total_withdrawal).toFixed(2));
                    $(".tdub").html(parseFloat(data[0].today_deposit_btc).toFixed(4));
                    $(".ttdb").html(parseFloat(data[0].total_deposit_btc).toFixed(4));
                    $(".twub").html(parseFloat(data[0].today_withdrawal_btc).toFixed(4));
                    $(".twbc").html(parseFloat(data[0].total_withdrawal_btc).toFixed(4));
                    chartone(data[0].today_deposit,data[0].today_withdrawal,data[0].today_deposit_btc,data[0].today_withdrawal_btc);
                    charttwo(data[0].total_deposit,data[0].total_withdrawal,data[0].total_deposit_btc,data[0].total_withdrawal_btc);
            }
        }); 
}

function chartone(today_deposit,today_withdrawal,today_deposit_btc,today_withdrawal_btc){
    $('#chart-doughnuttb').chart(
     {
        type: 'doughnut',
        data: {
            labels: ['Today USD Deposit', 'Today USD Withdrawal', 'Today Bitcoin Deposit', 'Today Bitcoin Withdrawal'],
            datasets: [
              {
                  data: [
                      today_deposit,
                      today_withdrawal,
                      today_deposit_btc,
                      today_withdrawal_btc,
                  ],
                  borderColor: 'transparent',
                  backgroundColor: [
                      "#F7464A",
                      "#46BFBD",
                      "#FDB45C",
                      "#949FB1",
                      "#4D5360",
                  ],
                  label: 'Trafic'
              }
            ]
        },
        options: {
          legend: {
            position: 'left',
            labels:{
              boxWidth: 12
            }
          },
          cutoutPercentage: 75
        }
      }
    );
}


function charttwo(total_deposit,total_withdrawal,total_deposit_btc,total_withdrawal_btc){
    $('#chart-doughnuttc').chart(
     {
        type: 'doughnut',
        data: {
            labels: ['Total USD Deposit', 'Total USD Withdrawal', 'Total Bitcoin Deposit', 'Total Bitcoin Withdrawal'],
            datasets: [
              {
                  data: [
                      total_deposit,
                      total_withdrawal,
                      total_deposit_btc,
                      total_withdrawal_btc,
                  ],
                  borderColor: 'transparent',
                  backgroundColor: [
                      "#FDB45C",
                      "#46BFBD",
                      "#4D5360",
                      "#949FB1",
                      "#F7464A",
                      
                  ],
                  label: 'Trafic'
              }
            ]
        },
        options: {
          legend: {
            position: 'left',
            labels:{
              boxWidth: 12
            }
          },
          cutoutPercentage: 75
        }
      }
    );
} 