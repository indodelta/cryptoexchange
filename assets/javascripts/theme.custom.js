/* Add here all your JS customizations */
$(document).ready(function() {
	var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){
    dd='0'+dd;
} 
if(mm<10){
    mm='0'+mm;
} 
var today = mm+'/'+dd+'/'+yyyy;
			$('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                endDate: today,
                forceParse: false,
                autoclose: true
            });

		
  
    // current_btc_price_ask =0;
  var token = $(".formtoken input[name='_token']").val();

  jQuery('.trade_price, .order_price').keyup(function () { 
      this.value = this.value.replace(/[^0-9\.]/g,'');
  });
  var current_btc_price = "";
  $.post( "/current_btc_price", { '_token': token}).done(function( data ) {
    current_btc_price = parseFloat(data);

    // console.log(current_btc_price);
  });
var global_g =0;
  showmore();
	setInterval(function(){
     $.ajax({
        url: "/thpdata",
        type: 'POST',
        data:  {'_token':token},
        success: function(data){
          var thpdata = jQuery.parseJSON(data);
          var itbit = global_g = jQuery.parseJSON(thpdata.itbit);
          $('.red').addClass('white').removeClass('red')
          $('.green').addClass('white').removeClass('green')
          $('.blue-text').addClass('white').removeClass('blue-text')
          $('.fa-arrow-down').remove()
          $('.fa-arrow-up').remove()
          var last_trade =  (itbit.lastPrice>parseFloat($(".last_trade").text())?'green':'red')
          var ask        =  (itbit.ask>parseFloat($(".ask").text())?'green':'red')
          var bid        =  (itbit.bid>parseFloat($(".bid").text())?'green':'red')
          var volume24h  =  (itbit.volume24h>parseFloat($(".volume24h").text())?'blue-text':'blue-text')

          $(".last_trade").parent().addClass(last_trade).removeClass('white').append((last_trade=='green')?'<i class="fa fa-arrow-up"></i>':'<i class="fa fa-arrow-down"></i>');
          $(".ask").parent().addClass(ask).removeClass('white').append((ask=='green')?'<i class="fa fa-arrow-up"></i>':'<i class="fa fa-arrow-down"></i>');
          $(".bid").parent().addClass(bid).removeClass('white').append((bid=='green')?'<i class="fa fa-arrow-up"></i>':'<i class="fa fa-arrow-down"></i>');
          $(".volume24h").parent().addClass(volume24h).removeClass('white');
          $(".last_trade").text(parseFloat(itbit.lastPrice).toFixed(2));//<i class="fa fa-arrow-up"></i>
          $(".ask").text(parseFloat(itbit.ask).toFixed(2));
          $(".bid").text(parseFloat(itbit.bid).toFixed(2));
          $(".volume24h").text(parseFloat(itbit.volume24h).toFixed(2));
          if($(".order_body").length>0){
            $(".order_body").fadeOut().html(thpdata.order_html).fadeIn();
            showmore();
          }   
        }  

    });
      $('#orders_table').load(document.URL +  ' #orders_table'); 
      $('#trail_he').load(document.URL +  ' #trail_he');
  },6000);

  $(".deposit_amt").on("click",function () {
    if($("#transaction").val() == 1){
      var countdown = 15 * 60; // Interval stop after 15 minutes.
      var check_btc = setInterval(function(){
        countdown -= 1;
        var min = Math.floor(countdown / (60 * 1000));
        var sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);  //correct
        if (countdown <= 0) {
            clearInterval(check_btc);
        }
        $.ajax({
            url: "/check_bitcoin",
            type: 'POST',
            data:  {'_token':token,'ajax':1},
            success: function(resp){
              if(resp == 1 || resp == 2){
                clearInterval(check_btc);
                location.reload();
              }
            }  
        });
      },15000);
    }
  });

  $(".withdrawal_amt").on("change",function(){
    if($(this).val() == 1){
      $(".usd-form").hide();
      $(".bitcoin-form").fadeIn();
    }else if($(this).val() == 5){ 
      $(".bitcoin-form").hide();
      $(".usd-form").fadeIn();
    }
  });

  $("#transaction").on("change",function () {
    if($(this).val() == 1){
      generate_address();
      $(".deposit_amt").attr("href","#modalForm");
    }else if($(this).val() == 5){
      $(".deposit_amt").attr("href","#modaldeposit");
    }else{
      $(".deposit_amt").attr("href","#"); 
    }
  });
  $(document).on("click",".cross",function () {
    $(this).parent().remove();
    mynoti($(this).parent().attr('class').split(' ').pop());
  });
  $(document).on("submit","#uploadfile",function(e){
        e.preventDefault();
            $.ajax({
                url: "/kyc",
                type: "POST",
                data:  new FormData(this),
                contentType: false,       
                cache: false,              
                processData:false,
                success: function(data){              
                    if(data['success']==1){
                        $.get('/user_authenticat');
                        window.location="funding";
                     }
                }                 
            });
    });
  $(document).on("submit","#uploadfile_profile",function(e){
      $(".loading",this).show();
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
                        window.location="settings";
                     }
                }                 
            });
    });

  $(document).on("submit",".new_bank",function(e){
        e.preventDefault();
        $(".loading").show();
        $.ajax({
            url: "/bank",
            type: "POST",  
            data: $(this).serialize(),             
            success: function(resp){  
              var new_bank = jQuery.parseJSON(resp);
              var html  = "<option value='"+new_bank.id+"'>"+new_bank.bank_name+"</option>";
              $(".bank_name_select").append(html).val(new_bank.id).change();
              $(".loading").hide();
              $("#close_bank_pop").click();
              Command: toastr['success']("bank added successfully")
                  toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": false,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }

            }                 
        });
        setTimeout(location.reload(), 3000);
        
    });
    $(document).on("click","#close_bank_pop, .close_bank_pop",function(){
      $(".new_bank input[type=text]").val("");
    });

    $(document).on("click",".usdpopup",function () {
      $.magnificPopup.open({
          items: {
              src: '#USDdollar-modal1'
          },
          type: 'inline'
      });
    });


  $(document).on("click",".btcpopup",function () {
      $.magnificPopup.open({
          items: {
              src: '#USDbitcoin-modal'
          },
          type: 'inline'
      });
    });

    $(".bank_name_select").on("change",function () {
      if($(this).val()>0){
        $(".bank_name_select").removeAttr("style");
        $(".bank_name_small").text("");
        $.ajax({
              url: "/bank_det",
              type: "POST",  
              data: { '_token': token, 'bank_id':$(this).val()},             
              success: function(resp){  
                var bank_data = jQuery.parseJSON(resp);
                if(bank_data){
                  var bnk_name = bank_data.bank_name;
                  var ben_name = bank_data.beneficiary_name;
                  var acc_no = bank_data.beneficiary_account_no;
                  var swft_code = bank_data.swift_code;

                  $(".val_bank_name").text(bnk_name);
                  $(".val_beneficiary_name").text(ben_name);
                  $(".val_beneficiary_account").text(acc_no);
                  $(".val_swift_code").text(swft_code);
                }
              }                 
          });
        if($(".withusdamount").val() !=""){        
          $(".withdraw_usdollar").addClass("usdpopup");
        }
        if($(".withusdamount").val() > parseFloat(bdecrypt6($("#usd__token").val()))){
           $(".withdraw_usdollar").removeClass("usdpopup");
        }
      }else{
        $(".withdraw_usdollar").removeClass("usdpopup");
      }
    });
    $(document).on("click",".withdraw_usdollar",function () {      
      if($(".bank_name_select").val() ==""){         
        $(".bank_name_select").css("border","1px solid red");
        $(".bank_name_small").text("Please select bank first.");
      }
      if($(".withusdamount").val() ==""){         
        $(".withusdamount").css("border","1px solid red");
        $(".usdsmall").text("Please enter amount.");
      }  
    });

    $(document).on("click",".withdraw_bitcoin",function () {      
      if($(".withbtcamount").val() ==""){         
        $(".withbtcamount").css("border","1px solid red");
        $(".btcsmall").text("Please enter amount.");
      }
      if($(".btcaddress").val() ==""){         
        $(".btcaddress").css("border","1px solid red");
        $(".btcaddresssmall").text("Please add address.");
      }  
    });

    $(".withusdamount").on("keyup",function () {
        if($(this).val()>0){

          $(this).removeAttr("style");
          $(".usdsmall").text("");
          $(".val_usdamount").html("<b>$</b> "+$(this).val());
          var cond = 0;
           cond = ($(this).val() > parseFloat(bdecrypt6($("#usd__token").val())));
           if($(".bank_name_select").val() !=""){ 
            $(".withdraw_usdollar").addClass("usdpopup");
          }
           if(cond){
              $(".withusdamount").css("border","1px solid red");
        $(".usdsmall").text("Your amount must not be greater than avaliable USD amount");
            $(".withdraw_usdollar").removeClass("usdpopup");
           }
          

          
        }else{
          $(".val_usdamount").text("");
          $(".withdraw_usdollar").removeClass("usdpopup");
        }


    });
    $(".withbtcamount").on("keyup",function () {
        if($(this).val()>0){
          $(this).removeAttr("style");
          $(".btcsmall").text("");
          $(".val_btc_amount").html('<i class="fa fa-btc" aria-hidden="true"></i> '+$(this).val());
          if($(".btcaddress").val() !=""){ 
            $(".withdraw_bitcoin").addClass("btcpopup");
          }
          cond = ($(this).val() > parseFloat(bdecrypt6($("#xbt__token").val())));
          if(cond){
              $(".withbtcamount").css("border","1px solid red");
        $(".btcsmall").text("Your amount must not be greater than avaliable BTC amount");
            $(".withdraw_bitcoin").removeClass("btcpopup");
           }
        }else{
          $(".val_btc_amount").text('');
          $(".withdraw_bitcoin").removeClass("btcpopup");
        }
    });

    $(".btcaddress").on("keyup",function () {
        if($(this).val()!=""){
          $(this).removeAttr("style");
          $(".btcaddresssmall").text("");
          $(".val_btc_address").text($(this).val());
          if($(".withbtcamount").val() >0){ 
            $(".withdraw_bitcoin").addClass("btcpopup");
          }
          cond = ($(".withbtcamount").val() > parseFloat(bdecrypt6($("#xbt__token").val())));
          if(cond){
            $(".withdraw_bitcoin").removeClass("btcpopup");
           }
        }else{
          $(".val_btc_address").text("");
          $(".withdraw_bitcoin").removeClass("btcpopup");
        }
    });
    /*$(".withdraw_bitcoin").click(function () {      
      if($(".withbtcamount").val() ==""){         
        $(".withbtcamount").css("border","1px solid red");
        $(".btcsmall").text("Please select bank first.");
      }  
    });*/

    $(document).on("click",".validate_gcode",function () {
        gvalidate();
    });
    $(document).on("submit",".formtoken",function (e) {
        e.preventDefault();
        gvalidate();
    });
    $(document).on("keyup change",".int_field",function () {
        if($(this).val() != "" && isNaN($(this).val())){
          $(this).val("");
        }
    });
var pcrypt = parseFloat(bdecrypt6($(".pcrypted").text()));
var pcrypts = parseFloat(bdecrypt6($(".pcrypteds").text()));
    $(document).unbind("keyup change").on("keyup change",".trade_price",function () {

        var section = $(this).data("section");
        if($("#"+section+"_order_price").val() !=""){
          
          if($(this).val() != "" && isNaN($(this).val())){
            $(this).val("");
          }

          
          if($("."+section+" .per-list-selected").length>0){
            $("."+section+" .per-list-selected").removeClass("per-list-selected");
          }
          // var current_btc_price =  $("#"+section+"_order_price").val();
          var currency = $(this).data('currency');
          var value = $(this).val();
          var flag = true;
          if(value>0){
              $(this).removeAttr("style");
              if(currency == "BTC"){
                var converted_amount = (parseFloat(value) * $("#"+section+"_order_price").val());
                  flag = true;
                if(flag){
                  $("#"+section+"_USD_conversion").val(converted_amount.toFixed(2)).removeAttr("style");
                  $("."+section+"_quantity").text(parseFloat(value).toFixed(4));
                }
              }
              else if(currency == "USD"){ 
                  if(section == "buy"){
                    if(value > 1000 && value == parseFloat(bdecrypt6($("#usd__token").val()))){
                      value = parseFloat(value) - parseFloat(parseFloat(value) * (pcrypt/100));
                    }
                  
                      // trade_error(false, section);
                      flag = true;
                  
                  }
               if(flag){
                  var converted_amount = (parseFloat(value) / $("#"+section+"_order_price").val());
                  $("#"+section+"_BTC_conversion").val(converted_amount.toFixed(4)).removeAttr("style");
                  $("."+section+"_quantity").text(parseFloat(converted_amount).toFixed(4));
                }
              }


              if(flag){

                var fee_estimate = 0;
                if(parseFloat($("#"+section+"_USD_conversion").val()) > 1000){
                  if(section=="buy") { 
                  fee_estimate = parseFloat(parseFloat($("#"+section+"_USD_conversion").val()) * (pcrypt/100)).toFixed(2);
                    }
                    else{
                      fee_estimate = parseFloat(parseFloat($("#"+section+"_USD_conversion").val()) * (pcrypts/100)).toFixed(2);
                    }
                  $("."+section+"_fee_estimate").text(fee_estimate);
                  $("."+section+"fee_estimate").val(fee_estimate);
                }else{
                  fee_estimate = 0;
                }
                var total_usd = 0;
                if($("#"+section+"_USD_conversion").val() != ""){
                  total_usd = parseFloat($("#"+section+"_USD_conversion").val());
                }

                if(total_usd > 1000 && total_usd < parseFloat(bdecrypt6($("#usd__token").val())) && section == "buy"){
                  total_usd = (total_usd + parseFloat(fee_estimate));
                }else if(total_usd > 1000 && section == "sell"){
                  total_usd = (total_usd - parseFloat(fee_estimate));
                }
                  $("."+section+"_total_usd").text(parseFloat(total_usd).toFixed(2));
                  $("."+section+"_total_amount").val(parseFloat(total_usd).toFixed(2));

                if(fee_estimate==0){
                $("."+section+"_fee_estimate").text("0.00");
                $("."+section+"fee_estimate").val("");
                }
              }
          }else{
            if(currency == "BTC"){
              $("#"+section+"_USD_conversion").val("");
            }
            else if(currency == "USD"){
              $("#"+section+"_BTC_conversion").val("");
            }
            $("."+section+"_fee_estimate").text('0.00');
            $("."+section+"_total_usd").text('0.00');
            $("."+section+"_quantity").text('0.000000');
          }
        }else{
          $("#"+section+"_order_price").css("border","1px solid red").focus();
          $("."+section+"_small").text("Please enter this field first");
          $(".trade_price").val("");
        }      
    });
    $(document).on("keyup change",".order_price",function () {
      var section = $(this).data("section");
      if($(this).val() != ""){
        $(this).removeAttr("style");
        if($("#"+section+"_BTC_conversion").val() !=""){
          var converted_amount = (parseFloat($("#"+section+"_BTC_conversion").val()) * parseFloat($(this).val()));
          $("#"+section+"_USD_conversion").val(converted_amount.toFixed(2));
          if(parseFloat($("#"+section+"_USD_conversion").val()) > 1000){
          if(section=="buy") { 
            fee_estimate = parseFloat(parseFloat($("#"+section+"_USD_conversion").val()) * (pcrypt/100)).toFixed(2);
              }
          else{
               fee_estimate = parseFloat(parseFloat($("#"+section+"_USD_conversion").val()) * (pcrypts/100)).toFixed(2);
              }
          $("."+section+"_fee_estimate").text(fee_estimate);
            $("."+section+"fee_estimate").val(fee_estimate);
          }else{
            $("."+section+"_fee_estimate").text("0.00");
            $("."+section+"fee_estimate").val("");
          }

            var total_usd = 0;
                if($("#"+section+"_USD_conversion").val() != ""){
                  total_usd = parseFloat($("#"+section+"_USD_conversion").val());
                }

                if(total_usd > 1000 && total_usd < parseFloat(bdecrypt6($("#usd__token").val())) && section == "buy"){
                  total_usd = (total_usd + parseFloat(fee_estimate));
                }else if(total_usd > 1000 && section == "sell"){
                  total_usd = (total_usd - parseFloat(fee_estimate));
                }
                  $("."+section+"_total_usd").text(parseFloat(total_usd).toFixed(2));
                  $("."+section+"_total_amount").val(parseFloat(total_usd).toFixed(2));


        }

        $("."+section+"_order_price").text(format2(parseFloat($(this).val())));
        $("#"+section+"_order_price").removeAttr("style");
        $("."+section+"_small").text("");
        // $("#"+section+"_BTC_conversion").keyup();
        
      }else{
        $("."+section+"_order_price").text("0.00");
      }
    });

    $(document).on("click",".addperc",function () {
      var section = $(this).data('section');
      var converted_amount = "";
      if(section == "buy"){
        converted_amount = (parseFloat(bdecrypt6($("#usd__token").val())) * parseFloat($(this).data("perc"))).toFixed(2);  
        $("#"+section+"_USD_conversion").val(converted_amount).focus().keyup();
      }else{
        converted_amount = (parseFloat(bdecrypt6($("#xbt__token").val())) * parseFloat($(this).data("perc"))).toFixed(4);        
        $("#"+section+"_BTC_conversion").val(converted_amount).focus().keyup();
      }

      $("."+section+" .per-list-selected").removeClass("per-list-selected");
      $(this).addClass("per-list-selected");
    });

    $(document).on("click",".trade_btn",function () {
      var section = $(this).data('section');
      
      var flag = true;
      if($("#"+section+"_USD_conversion").val() == ""){
        $("#"+section+"_USD_conversion").css("border","1px solid red").focus();
        flag = false;
      }
      if($("#"+section+"_BTC_conversion").val() == ""){
        $("#"+section+"_BTC_conversion").css("border","1px solid red").focus();
        flag = false;
      }
      if($("#"+section+"_order_price").val() == ""){
        $("#"+section+"_order_price").css("border","1px solid red").focus();
        flag = false;
      }
      if(flag){
        var fee = $("."+section+"fee_estimate").val() !=""?$("."+section+"fee_estimate").val():"0.00";
        $("."+section+"_USD_conversion_lbl").text("$"+$("#"+section+"_USD_conversion").val());
        $("."+section+"_BTC_conversion_lbl").html('<i class="fa fa-bitcoin" style="color: black;" aria-hidden="true"></i>'+$("#"+section+"_BTC_conversion").val());
        $("."+section+"_order_price_lbl").text("$"+$("#"+section+"_order_price").val());
        $("."+section+"_fee_estimate_lbl").text("$"+fee);
        
        $.magnificPopup.open({
            items: {
                src: '#'+section+'-modal'
            },
            type: 'inline'
        });
      }else{
        return flag;
      }
    });
    $(document).on("click",".order_now",function () {
      var section = $(this).data('section');

      var total_usd = 0;
      if($("#"+section+"_USD_conversion").val() != ""){
        total_usd = parseFloat($("#"+section+"_USD_conversion").val());
      }

      if(total_usd > 1000 && total_usd < parseFloat(bdecrypt6($("#usd__token").val())) && section == "buy"){
        total_usd = (total_usd + parseFloat(fee_estimate));
      }else if(total_usd > 1000 && section == "sell"){
        total_usd = (total_usd - parseFloat(fee_estimate));
      }

      var cond = false;
      var bt_val = 0;
      var text = "";
      if(section == "buy"){
        cond = (total_usd > parseFloat(bdecrypt6($("#usd__token").val())));
        bt_val = bencrypt6(parseFloat(bdecrypt6($("#usd__token").val()))-total_usd);
      }else{
        cond = (parseFloat($("#"+section+"_BTC_conversion").val()) > parseFloat(bdecrypt6($("#xbt__token").val())));
         bt_val = bencrypt6(parseFloat(bdecrypt6($("#xbt__token").val()))-parseFloat($("#"+section+"_BTC_conversion").val()));
      }

      if(cond){
        Command: toastr['error']("Insufficient Fund")                
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "progressBar": false,
          "preventDuplicates": false,
          "positionClass": "toast-top-center",
          "onclick": null,
          "showDuration": "400",
          "hideDuration": "1000",
          "timeOut": "7000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };
      }
      else{
        var id_t =(section=='sell')?"#xbt__token":"#usd__token";
        $(id_t).val(bt_val);
        var form_data = $("#"+section+"_trade_form").serialize();
        $("#"+section+"_USD_conversion").val("");
        $("#"+section+"_BTC_conversion").val("");
        $("#"+section+"_order_price").val((section=='sell')?parseFloat(global_g==0?$('.bid').text():global_g.bid).toFixed(2):parseFloat(global_g==0?$('.ask').text():global_g.ask).toFixed(2));
        // console.log(form_data);
        $.ajax({
                url: "/trading",
                type: "POST",  
                data: form_data,             
                success: function(resp){
                  $('#orders_table').load(document.URL +  ' #orders_table');
                  $('#trail_he').load(document.URL +  ' #trail_he');

                  // console.log(resp);
                  if(resp==0){                    
                    Command: toastr['error']("Something went wrong")
                  }else{
                    Command: toastr['success']("Order Placed")
                  }
                  toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": false,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-center",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  };
                  $(".orderStatusButton").hover(function(){
                      $(this).text("Cancel");
                    }, function(){
                      $(this).text("Open");
                  });
                }                 
            });
        }
        $(".close_bank_pop").click();
    });

    $(".orderStatusButton").hover(function(){
        $(this).text("Cancel");
      }, function(){
        $(this).text("Open");
    });
});

/*function trade_error(cond, section, text="", total_usd="") { 
  if(cond){
    if(section == "buy"){
      $("#"+section+"_USD_conversion").css("border","1px solid red").val("").focus().keyup();
      $("#"+section+"_USD_conversion").siblings("small").text(text);
    }else{
      $("#"+section+"_BTC_conversion").css("border","1px solid red").val("").focus().keyup();
      $("#"+section+"_BTC_conversion").siblings("small").text(text);
    }
  }else{
    if(section == "buy"){
      $("#"+section+"_USD_conversion").removeAttr("style");
      $("#"+section+"_USD_conversion").siblings("small").text("");
    }else{
      $("#"+section+"_BTC_conversion").removeAttr("style");
      $("#"+section+"_BTC_conversion").siblings("small").text("");
    }
    $("."+section+"_total_usd").text(parseFloat(total_usd).toFixed(2));
    $("."+section+"_total_amount").val(parseFloat(total_usd).toFixed(2));
  }
}*/

function mynoti(class_n){
    var token = $(".formtoken input[name='_token']").val();
    $.ajax({
              url: "/my_noti",
              type: "POST",  
              data: { '_token': token, 'type':class_n},             
              success: function(resp){  
                
              }                 
          });
  }

function format2(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}



function bank_sub(e){
  $(e).prop('disabled', true);
  var token = $(".formtoken input[name='_token']").val();
  var bank_id = $('.bank_name_select').val();
  var amount = $('.withusdamount').val();
   $.ajax({
        url: "/bank_sub",
        type: "POST",
        data:  {'_token':token,'bank_id':bank_id,'amount':amount},
        success: function(resp){

             location.reload();
        }                
    });
}

function showmore(table="order_book",btn="show") {
  var rows2display=parseInt($("."+table+"_visible").val());
  var totalrowshidden;
  var rowCount = $('.'+table+' tr').length;
  var MaxCntr=0;

  if($('.'+table+' tr').length > rows2display){
    $('#'+btn).fadeIn();
  }  

  $('#'+btn).unbind('click').on("click",function() {

    MaxCntr = forStarter + rows2display;

    if (forStarter <= rowCount) {

        for (var i = forStarter; i < MaxCntr; i++) {
          $('.'+table+' tr:nth-child(' + i + ')').show(200);
        }
        $("."+table+"_visible").val(MaxCntr-1);

        forStarter = forStarter + rows2display

    } else {
        $('#'+btn).hide();
    }
  }); 
  

  for (var i = rowCount; i > rows2display; i--) {
      $('.'+table+' tr:nth-child(' + i + ')').hide(200);
  }
  var forStarter = 10 + 1;
}

function gvalidate(){
    var token = $(".formtoken input[name='_token']").val();
    $.ajax({
        url: "/validate2fa",
        type: "POST",
        data:  {'_token':token,'totp':$(".totp").val(),'ajax':'1'},
        success: function(resp){
            // console.log(resp);                    
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

function generate_address() {
  var token = $(".formtoken input[name='_token']").val();
  $.ajax({
      url: "/generate_address",
      type: 'POST',
      data:  {'_token':token},
      success: function(data){
        var address_data = jQuery.parseJSON(data);
        $(".btc_qr").attr("src",address_data.url);
        $(".btc_address").val(address_data.address);
      } 
  });
}


function round(value, exp) {
  if (typeof exp === 'undefined' || +exp === 0)
    return Math.round(value);

  value = +value;
  exp = +exp;

  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
    return NaN;

  // Shift
  value = value.toString().split('e');
  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

  // Shift back
  value = value.toString().split('e');
  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}


function btc_sub(e){
  $(e).prop('disabled', true);
  var token = $(".formtoken input[name='_token']").val();
  var bct_add = $('.btcaddress').val();
  var amount = $('.withbtcamount').val();
   $.ajax({
        url: "/btc_sub",
        type: "POST",
        data:  {'_token':token,'bct_add':bct_add,'amount':amount},
        success: function(resp){
          
             location.reload();
        }                
    });

}


function message(e){
  if(!($("#testrty").val())){
      $('.message_text').prepend("<p class='text_check' style='color:red;'>Check google auth first</p>");   
    }
    else{
      $(e).prop('disabled', true);
          var token = $(".formtoken input[name='_token']").val();
  var cyl   = $("#testrty").val();
  $.ajax({
      url: "/validate2fa",
      type: 'POST',
      data:  {'_token':token,'totp':cyl,'ajax':'1'},
      success: function(data){
       if(data==1){

        $('.text_check').remove();
        $('.message_text').prepend("<p class='text_check' style='color:green;'>match successfully</p>");
        
        var token = $(".formtoken input[name='_token']").val();
        if($('.btcaddress').val())
        {
          var bct_add = $('.btcaddress').val();
        var amount = $('.withbtcamount').val();
         $.ajax({
              url: "/btc_sub",
              type: "POST",
              data:  {'_token':token,'bct_add':bct_add,'amount':amount},
              success: function(resp){
                
                   location.reload();
              }                
          });
       }
       else if($('.bank_name_select').val())
       {
        var token = $(".formtoken input[name='_token']").val();
        var bank_id = $('.bank_name_select').val();
        var amount = $('.withusdamount').val();
         $.ajax({
              url: "/bank_sub",
              type: "POST",
              data:  {'_token':token,'bank_id':bank_id,'amount':amount},
              success: function(resp){

                   location.reload();
              }                
          });
       }
       }
       else{
        $(e).prop('disabled', false);
        $('.text_check').remove();
        $('.message_text').prepend("<p class='text_check' style='color:red;'>Didn't match</p>");
       }
      } 
  });
    } 
    
  }


function check_da(){
  var token = $(".formtoken input[name='_token']").val();
  var cyl   = $("#testrty").val();
  $.ajax({
      url: "/validate2fa",
      type: 'POST',
      data:  {'_token':token,'totp':cyl,'ajax':'1'},
      success: function(data){
       if(data==1){
        $('.text_check').remove();
        $(".text_message").attr('onclick','bank_sub(this)');
        $('.message_text').prepend("<p class='text_check' style='color:green;'>match successfully</p>");
       }
       else{
        $('.text_check').remove();
        $('.message_text').prepend("<p class='text_check' style='color:red;'>Didn't match</p>");
       }
      } 
  });
} 
var i = 1;
function submit(type){
  var token = $(".formtoken input[name='_token']").val();
                  if(i==1)
                  { 
                    i++;
                    var urld = "/trading_history?start_d="+encodeURIComponent($('#start_d').val())+"&end_d="+encodeURIComponent($('#end_d').val());

                    window.location.href = urld;
                 }
                }

function bencrypt6(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}

function bdecrypt6(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    
}