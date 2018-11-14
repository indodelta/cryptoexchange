/* Add here all your JS customizations */
$(document).ready(function() {
  var current_btc_price_itbit =0;
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
  $.ajax({
        url: "/thpdata",
        type: 'POST',
        data:  {'_token':token},
        success: function(data){
          var thpdata1 = jQuery.parseJSON(data);
          current_btc_price_itbit = jQuery.parseJSON(thpdata1.itbit);
        }
  });
  showmore();
  setInterval(function(){
     $.ajax({
        url: "/thpdata",
        type: 'POST',
        data:  {'_token':token},
        success: function(data){
          var thpdata = jQuery.parseJSON(data);
          var itbit = current_btc_price_itbit = jQuery.parseJSON(thpdata.itbit);
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
          $(".volume24h").parent().addClass(volume24h).removeClass('white').append((volume24h=='green')?'<i class="fa fa-arrow-up"></i>':'<i class="fa fa-arrow-down"></i>');
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
  },6000);

  $(".deposit_amt").click(function () {
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

  $(".withdrawal_amt").change(function(){
    if($(this).val() == 1){
      $(".usd-form").hide();
      $(".bitcoin-form").fadeIn();
    }else if($(this).val() == 5){ 
      $(".bitcoin-form").hide();
      $(".usd-form").fadeIn();
    }
  });

  $("#transaction").change(function () {
    if($(this).val() == 1){
      generate_address();
      $(".deposit_amt").attr("href","#modalForm");
    }else if($(this).val() == 5){
      $(".deposit_amt").attr("href","#modaldeposit");
    }else{
      $(".deposit_amt").attr("href","#"); 
    }
  });
  $(".cross").click(function () {
    $(this).parent().remove();
  });
  $("#uploadfile").on("submit",function(e){
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
  $("#uploadfile_profile").on("submit",function(e){
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

  $(".new_bank").on("submit",function(e){
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
                  }

            }                 
        });
    });
    $("#close_bank_pop, .close_bank_pop").click(function(){
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

    $(".bank_name_select").change(function () {
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
      }else{
        $(".withdraw_usdollar").removeClass("usdpopup");
      }
    });
    $(".withdraw_usdollar").click(function () {      
      if($(".bank_name_select").val() ==""){         
        $(".bank_name_select").css("border","1px solid red");
        $(".bank_name_small").text("Please select bank first.");
      }
      if($(".withusdamount").val() ==""){         
        $(".withusdamount").css("border","1px solid red");
        $(".usdsmall").text("Please enter amount.");
      }  
    });

    $(".withdraw_bitcoin").click(function () {      
      if($(".withbtcamount").val() ==""){         
        $(".withbtcamount").css("border","1px solid red");
        $(".btcsmall").text("Please enter amount.");
      }
      if($(".btcaddress").val() ==""){         
        $(".btcaddress").css("border","1px solid red");
        $(".btcaddresssmall").text("Please add address.");
      }  
    });

    $(".withusdamount").keyup(function () {
        if($(this).val()>0){
          $(this).removeAttr("style");
          $(".usdsmall").text("");
          $(".val_usdamount").html("<b>$</b> "+$(this).val());
          if($(".bank_name_select").val() !=""){ 
            $(".withdraw_usdollar").addClass("usdpopup");
          }
        }else{
          $(".val_usdamount").text("");
          $(".withdraw_usdollar").removeClass("usdpopup");
        }
    });
    $(".withbtcamount").keyup(function () {
        if($(this).val()>0){
          $(this).removeAttr("style");
          $(".btcsmall").text("");
          $(".val_btc_amount").html('<i class="fa fa-btc" aria-hidden="true"></i> '+$(this).val());
          if($(".btcaddress").val() !=""){ 
            $(".withdraw_bitcoin").addClass("btcpopup");
          }
        }else{
          $(".val_btc_amount").text('');
          $(".withdraw_bitcoin").removeClass("btcpopup");
        }
    });

    $(".btcaddress").keyup(function () {
        if($(this).val()!=""){
          $(this).removeAttr("style");
          $(".btcaddresssmall").text("");
          $(".val_btc_address").text($(this).val());
          if($(".withbtcamount").val() >0){ 
            $(".withdraw_bitcoin").addClass("btcpopup");
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

    $(".validate_gcode").click(function () {
        gvalidate();
    });
    $(".formtoken").on("submit",function (e) {
        e.preventDefault();
        gvalidate();
    });
    $(".int_field").on("keyup change",function () {
        if($(this).val() != "" && isNaN($(this).val())){
          $(this).val("");
        }
    });

    $(".trade_price").unbind("keyup change").on("keyup change",function () {  
        //console.log(current_btc_price_itbit);    
        var section = $(this).data("section");

        if($(this).val() != "" && isNaN($(this).val())){
          $(this).val("");
        }

        var pcrypt = parseFloat(bdecrypt6($(".pcrypted").text()));
        var pcrypts = parseFloat(bdecrypt6($(".pcrypteds").text()));
        if($("."+section+" .per-list-selected").length>0){
          $("."+section+" .per-list-selected").removeClass("per-list-selected");
        }
        // var current_btc_price =  $("#"+section+"_order_price").val();
        var currency = $(this).data('currency');
        var value = $(this).val();
        var flag = true;
        if(value>0){
            if(currency == "BTC"){
              var converted_amount = (parseFloat(value) * ((section == "buy")?current_btc_price_itbit.ask:current_btc_price_itbit.bid));
              if(section == "buy" && converted_amount < 1){
                trade_error(true, section, "You can't buy with less than $1");
                flag = false;
              }else{
                trade_error(false, section);
                flag = true;
              }
              if(flag){
                $("#"+section+"_USD_conversion").val(converted_amount.toFixed(2));
                $("."+section+"_quantity").text(parseFloat(value).toFixed(4));
              }
            }
            else if(currency == "USD"){ 
                if(section == "buy"){
                  if(value > 1000 && value == parseFloat(bdecrypt6($("#usd__token").val()))){
                    value = parseFloat(value) - parseFloat(parseFloat(value) * (pcrypt/100));
                  }
                  if(value < 1){
                    trade_error(true, section, "You can't Buy with less than $1");
                    flag = false;
                  }else{
                    trade_error(false, section);
                    flag = true;
                  }
                }
             if(flag){
                var converted_amount = (parseFloat(value) / ((section == "buy")?current_btc_price_itbit.ask:current_btc_price_itbit.bid));
                $("#"+section+"_BTC_conversion").val(converted_amount.toFixed(4));
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

              var cond = false;
              var text = "";
              if(section == "buy"){
                cond = (total_usd > parseFloat(bdecrypt6($("#usd__token").val())));
                text = "Your amount must not be greater than avaliable USD amount";
              }else{
                cond = (parseFloat($("#"+section+"_BTC_conversion").val()) > parseFloat(bdecrypt6($("#xbt__token").val())));
                text = "Your quantity must not be greater than avaliable Bitcoin amount";
              }

              trade_error(cond, section, text, total_usd);
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
    });
    $(".order_price").on("keyup",function () {
      var section = $(this).data("section");
      if($(this).val() != ""){
        $("."+section+"_order_price").text(format2(parseFloat($(this).val())));
        // $("#"+section+"_BTC_conversion").keyup();
      }else{
        $("."+section+"_order_price").text("0.00");
      }
    });

    $(".addperc").click(function () {
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
});

function trade_error(cond, section, text="", total_usd="") { 
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
}


function format2(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
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