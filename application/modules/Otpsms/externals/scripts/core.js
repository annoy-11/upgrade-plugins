sesJqueryObject(document).on("click",".opt_change_type",function(){
  var value = sesJqueryObject(this).data("rel");
  sesJqueryObject(this).closest('.form-elements').find('#otp_field_type').val(value);
  if(value == "phone"){
      sesJqueryObject(this).closest("#change_otp_type-wrapper").next().next().show();
      sesJqueryObject(this).closest("#change_otp_type-wrapper").next().hide();
      sesJqueryObject(this).parent().find('a').eq(0).hide();
      sesJqueryObject(this).parent().find('a').eq(1).show();
  }else{
      sesJqueryObject(this).closest("#change_otp_type-wrapper").next().next().hide();
      sesJqueryObject(this).closest("#change_otp_type-wrapper").next().show();
      sesJqueryObject(this).parent().find('a').eq(0).show();
      sesJqueryObject(this).parent().find('a').eq(1).hide();
  }  
});
var otpsmsVerifyText;
sesJqueryObject(document).on('submit','.otpsms_login_verify',function(e){
  e.preventDefault();
  var obj = sesJqueryObject(this);
  var value = sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').val();
  if(!value || value == ""){
      sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').css('border','1px solid red');
      return;
  }
  sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').css('border','');
  var url = sesJqueryObject(this).attr('action');
  
  var elem = sesJqueryObject(obj).find('.form-elements').find('#buttons-wrapper').find('#buttons-element').find('#submit');
  otpsmsVerifyText = elem.html();
  if(elem.hasClass('active'))
    return;
  elem.addClass('active');
  resendHTML = elem.html();
  new Request.JSON({
   url: url,
    method: 'post',
    data: {
      user_id:sesJqueryObject(obj).find('.form-elements').find('#email_data').val(),
      code:sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').val(),
      type:'login_template',
      format: 'json',
    },
    onRequest: function(){
      elem.html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading">');
    },
    onSuccess: function(responseJSON) {
      elem.removeClass('active');
      if (responseJSON.error == 1) {
        //show error
        var html = '<ul class="form-errors"><li><ul class="errors"><li>'+responseJSON.message+'</li></ul></li></ul>';
        sesJqueryObject(obj).find('.form-elements').parent().find('.form-errors').remove();
        sesJqueryObject(html).insertBefore(sesJqueryObject(obj).find('.form-elements'));
      }else{
        window.location.href = responseJSON.url;
        return;  
      }
      elem.html(otpsmsVerifyText);
    }
  }).send();
});

function otpsmsTimerData(){
    var elem = sesJqueryObject('.otpsms_timer_class');
    if (elem.length > 0){
        for(i=0;i<elem.length;i++) {
            var dataTime = sesJqueryObject(elem[i]).attr('data-time');

            var startTimeData = sesJqueryObject(elem[i]).attr('data-created');
            if (startTimeData == "") {
                var startTime = new Date();
                var startTimeData = startTime.toJSON();
                sesJqueryObject(elem[i]).attr('data-created', startTimeData);
            }else{
                var startTime = new Date(startTimeData);
            }

            var endtime = sesJqueryObject(elem[i]).attr('data-time');
            var endTime = new Date();
            var expireTime = new Date(startTime.getTime() + 1000*endtime);

            var isValid = true;
            if (endTime.getTime() >= expireTime.getTime()){
                isValid = false;
            }

            console.log(endtime,startTime,expireTime);
            var currentTime = new Date();
            //remaining time in seconds
            var timeDiff = expireTime - currentTime; //in ms
            // strip the ms
            timeDiff /= 1000;

            // get seconds
            var remaining = Math.round(timeDiff);
            if(remaining > 0 && isValid == true) {
                var m = Math.floor(remaining / 60);
                var s = remaining % 60;
                m = m < 10 ? '0' + m : m;
                s = s < 10 ? '0' + s : s;
                sesJqueryObject(elem[i]).html(m + ':' + s);
            }else{
                sesJqueryObject(elem[i]).css('color','red');
                sesJqueryObject(elem[i]).parent().html(en4.core.language.translate("Token Expired"));
            }

        }
    }

    setTimeout(function() {
        otpsmsTimerData();
    }, 1000);
}

sesJqueryObject(document).ready(function (e) {
   otpsmsTimerData();
});