
<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
en4.core.runonce.add(function()
{
  if(sesJqueryObject('#dragandrophandlerbackground').hasClass('requiredClass')){
      sesJqueryObject('#dragandrophandlerbackground').parent().parent().find('#photouploader-label').find('label').addClass('required').removeClass('optional');	
  }
  $('photouploader-wrapper').style.display = 'block';
  $('coupon_main_photo_preview-wrapper').style.display = 'none';
  $('photo-wrapper').style.display = 'none';
  var obj = sesJqueryObject('#dragandrophandlerbackground');
  obj.click(function(e){
      sesJqueryObject('#photo').val('');
      sesJqueryObject('#coupon_main_photo_preview').attr('src','');
    sesJqueryObject('#photo').trigger('click');
  });
  obj.on('dragenter', function (e) 
  {
      e.stopPropagation();
      e.preventDefault();
      sesJqueryObject (this).addClass("sesbd");
  });
  obj.on('dragover', function (e) 
  {
        e.stopPropagation();
        e.preventDefault();
  });
  obj.on('drop', function (e) 
  {
    sesJqueryObject (this).removeClass("sesbd");
    sesJqueryObject (this).addClass("sesbm");
    e.preventDefault();
    var files = e.originalEvent.dataTransfer;
    handleFileBackgroundUpload(files,'coupon_main_photo_preview');
  });
  sesJqueryObject(document).on('dragenter', function (e) 
  {
    e.stopPropagation();
    e.preventDefault();
  });
  sesJqueryObject(document).on('dragover', function (e) 
  {
    e.stopPropagation();
    e.preventDefault();
  });
  sesJqueryObject(document).on('drop', function (e) 
  {
        e.stopPropagation();
        e.preventDefault();
  });
});
en4.core.runonce.add(function()
{
  var obj = jqueryObjectOfSes('#dragandrophandler');
  obj.on('dragenter', function (e) 
  {
      e.stopPropagation();
      e.preventDefault();
      jqueryObjectOfSes (this).addClass("sesbd");
  });
  obj.on('dragover', function (e) 
  {
      e.stopPropagation();
      e.preventDefault();
  });
  obj.on('drop', function (e) 
  {
    jqueryObjectOfSes (this).removeClass("sesbd");
    jqueryObjectOfSes (this).addClass("sesbm");
    e.preventDefault();
      var files = e.originalEvent.dataTransfer.files;
      //We need to send dropped files to Server
      handleFileUpload(files,obj);
  });
  jqueryObjectOfSes (document).on('dragenter', function (e) 
  {
      e.stopPropagation();
      e.preventDefault();
  });
  jqueryObjectOfSes (document).on('dragover', function (e) 
  {
    e.stopPropagation();
    e.preventDefault();
  });
	jqueryObjectOfSes (document).on('drop', function (e) 
	{
			e.stopPropagation();
			e.preventDefault();
	});
});

var rotation = {
  1: 'rotate(0deg)',
  3: 'rotate(180deg)',
  6: 'rotate(90deg)',
  8: 'rotate(270deg)'
};
function _arrayBufferToBase64(buffer) {
  var binary = ''
  var bytes = new Uint8Array(buffer)
  var len = bytes.byteLength;
  for (var i = 0; i < len; i++) {
    binary += String.fromCharCode(bytes[i])
  }
  return window.btoa(binary);
}
var orientation = function(file, callback) {
  var fileReader = new FileReader();
  fileReader.onloadend = function() {
    var base64img = "data:" + file.type + ";base64," + _arrayBufferToBase64(fileReader.result);
    var scanner = new DataView(fileReader.result);
    var idx = 0;
    var value = 1; // Non-rotated is the default
    if (fileReader.result.length < 2 || scanner.getUint16(idx) != 0xFFD8) {
      // Not a JPEG
      if (callback) {
        callback(base64img, value);
      }
      return;
    }
    idx += 2;
    var maxBytes = scanner.byteLength;
    while (idx < maxBytes - 2) {
      var uint16 = scanner.getUint16(idx);
      idx += 2;
      switch (uint16) {
        case 0xFFE1: // Start of EXIF
          var exifLength = scanner.getUint16(idx);
          maxBytes = exifLength - idx;
          idx += 2;
          break;
        case 0x0112: // Orientation tag
          // Read the value, its 6 bytes further out
          // See store 102 at the following URL
          // http://www.kodak.com/global/plugins/acrobat/en/service/digCam/exifStandard2.pdf
          value = scanner.getUint16(idx + 6, false);
          maxBytes = 0; // Stop scanning
          break;
      }
    }
    if (callback) {
      callback(base64img, value);
    }
  }
  fileReader.readAsArrayBuffer(file);
};
var courseidparam = "";
function handleFileBackgroundUpload(input,id) {
  var files = sesJqueryObject(input)[0].files[0];
  var url = input.value;
  if(typeof url == 'undefined')
    url = input.files[0]['name'];
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
    courseidparam = id;
    if (files) {
        orientation(files, function(base64img, value) {
          //$(id+'-wrapper').attr('src', base64img);
          sesJqueryObject(courseidparam).closest('.form-wrapper').show();;
          var rotated = sesJqueryObject(courseidparam).attr('src', base64img);
          if (value) {
            sesJqueryObject(courseidparam).css('transform', rotation[value]);
          }
        });
      }
    $('photouploader-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('coupon_main_photo_preview').style.display = 'block';
    $('coupon_main_photo_preview-wrapper').style.display = 'block';
  }
}
function removeImage() {
    $('photouploader-element').style.display = 'block';
    $('removeimage-wrapper').style.display = 'none';
    $('removeimage1').style.display = 'none';
    $('coupon_main_photo_preview').style.display = 'none';
    $('coupon_main_photo_preview-wrapper').style.display = 'none';
    $('coupon_main_photo_preview').src = '';
    $('MAX_FILE_SIZE').value = '';
    $('removeimage2').value = '';
    $('photo').value = '';
}

en4.core.runonce.add(function() {
    jqueryObjectOfSes('#coupon_code_availability').click(function(){
      checkAvailsbility();
    });
    sesJqueryObject('input[name=discount_end_type]:checked').trigger('change');
  });
  function checkAvailsbility(submitform) {
    var coupon_code = jqueryObjectOfSes('#coupon_code').val();
    if(!coupon_code && typeof submitform == 'undefined')
    return;
    jqueryObjectOfSes('#coupon_code_wrong').hide();
    jqueryObjectOfSes('#coupon_code_correct').hide();
    jqueryObjectOfSes('#coupon_code_loading').css('display','block');
    jqueryObjectOfSes.post('<?php echo $this->url(array('action' => 'check-availability','subject'=>'admin'), "ecoupon_general") ?>',{coupon_code:coupon_code},function(response){
      jqueryObjectOfSes('#coupon_code_loading').hide();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error){
        jqueryObjectOfSes('#coupon_code_correct').hide();
        jqueryObjectOfSes('#coupon_code_wrong').css('display','block');
        if(typeof submitform != 'undefined') {
          alert('<?php echo $this->translate("Coupon Code is not available. Please select another URL."); ?>');
          var errorFirstObject = jqueryObjectOfSes('#coupon_code').parent().parent();
          jqueryObjectOfSes('html, body').animate({
          scrollTop: errorFirstObject.offset().top
          }, 2000);
        }
      } else{
        jqueryObjectOfSes('#coupon_code').val(response.coupon_code);
        jqueryObjectOfSes('#coupon_code_wrong').hide();
        jqueryObjectOfSes('#coupon_code_correct').css('display','block');
        if(typeof submitform != 'undefined') {
          jqueryObjectOfSes('#upload').attr('disabled',true);
          jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
          jqueryObjectOfSes('#submit_check').trigger('click');
        }
      }
    });
  }
  sesJqueryObject(document).on('change','input[name=discount_end_type]',function(e){
    var value = sesJqueryObject('input[name=discount_end_type]:checked').val();
    if(value == 1){
      sesJqueryObject('#discount_end_date-wrapper').show();
    }else{
      sesJqueryObject('#discount_end_date-wrapper').hide();
    }
  });
  function changeDiscountType(value){
    if(value == 1){ 
      sesJqueryObject('#fixed_discount_value-wrapper').show();
      sesJqueryObject('#percentage_discount_value-wrapper').hide();
    }else{
      sesJqueryObject('#percentage_discount_value-wrapper').show();
      sesJqueryObject('#fixed_discount_value-wrapper').hide();
    }
  };
  en4.core.runonce.add(function() {
    var value = sesJqueryObject('input[name=discount_type]:checked').val();
    if(!value)
      value = 0;
    changeDiscountType(value);
  });
  
var rowCount=0;
jqueryObjectOfSes(document).on('click','div[id^="abortPhoto_"]',function(){
		var id = jqueryObjectOfSes(this).attr('id').match(/\d+/)[0];
		if(typeof jqXHR[id] != 'undefined'){
				jqXHR[id].abort();
				delete filesArray[id];	
				execute = true;
				jqueryObjectOfSes(this).parent().remove();
				executeupload();
		}else{
				delete filesArray[id];	
				jqueryObjectOfSes(this).parent().remove();
		}
});

  var cal_startdate_onHideStart = function(){
    // check end date and make it the same date if it's too
    cal_enddate.calendars[0].start = new Date( $('startdate-date').value );
    // redraw calendar
    cal_enddate.navigate(cal_enddate.calendars[0], 'm', 1);
    cal_enddate.navigate(cal_enddate.calendars[0], 'm', -1);
  }
  var cal_enddate_onHideStart = function(){
    // check start date and make it the same date if it's too
    cal_startdate.calendars[0].end = new Date( $('enddate-date').value );
    // redraw calendar
    cal_startdate.navigate(cal_startdate.calendars[0], 'm', 1);
    cal_startdate.navigate(cal_startdate.calendars[0], 'm', -1);
  }
  function changePackageInfo(value){
    if((value == 'all') || (value == 'sescredit')) {
      sesJqueryObject('#package-wrapper').hide();
    } else {
      sesJqueryObject('#package-wrapper').show();
    }
    sesJqueryObject('#item_ids').val('');
    sesJqueryObject('.ecoupon_tag').remove();
  }
  var contentAutocompletePackage;
  en4.core.runonce.add(function () {
    changePackageInfo(sesJqueryObject('#item_type').val());
    contentAutocompletePackage = new Autocompleter.Request.JSON('package', "<?php echo $this->url(array('module' => 'ecoupon', 'controller' => 'index', 'action' => 'selected-package'), 'default', true) ?>", {
      'postVar': 'text',
      'minLength': 1,
      'delay' : 250,
      'selectMode': 'pick',
      'autocompleteType': 'message',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest message-autosuggest',
      'postData' : getItemType(),
      'injectChoice': function(token) {
        var choice = new Element('li', {
          'class': 'autocompleter-choices', 
          'html': token.photo, 
          'id':token.label
        });
        new Element('div', {
          'html': this.markQueryValue(token.label),
          'class': 'autocompleter-choice'
        }).inject(choice);
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      },
      onFocus: function() {
        this.queryValue='';
        this.options.postData = getItemType();
      },
    });
    contentAutocompletePackage.addEvent('onSelection', function(element, selected, value, input) {
      var shareItem = selected.retrieve('autocompleteChoice');
      if($('item_ids').value) {
        var str = $('item_ids').value;
        var split_str = str.split(",");
        var notAddagain = false;
        for (var i = 0; i < split_str.length; i++) {
          if (split_str[i] == shareItem.id) {
            notAddagain = true;
          }
        }
        if(notAddagain == false) {
          $('item_ids').value = $('item_ids').value+','+shareItem.id;
          var shareItemmyElementPrivate = new Element('span', {'id' : 'package_remove_'+shareItem.id, 'class' : 'ecoupon_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValuePackage('+shareItem.id+');">x</a>'
          });
          $('package-element').appendChild(shareItemmyElementPrivate);
          $('package-element').setStyle('height', 'auto');
          $('package').value = '';
        }
      } else {
        $('item_ids').value = shareItem.id;
        var shareItemmyElementPrivate = new Element('span', {'id' : 'package_remove_'+shareItem.id, 'class' : 'ecoupon_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValuePackage('+shareItem.id+');">x</a>'
        });
        $('package-element').appendChild(shareItemmyElementPrivate);
        $('package-element').setStyle('height', 'auto');
        $('package').value = '';
      }
    });
  });
  function getItemType() {
    return {
      'item_type': sesJqueryObject('#item_type').val()
    }
  }
  function removeToValuePackage(id, toValueArray){
    for (var i = 0; i < toValueArray.length; i++){
      if (toValueArray[i]==id) toValueIndex =i;
    }

    toValueArray.splice(toValueIndex, 1);
    $('item_ids').value = toValueArray.join();
  }
  function removeFromToValuePackage(id) {
    var toValues = $('item_ids').value;
    var toValueArray = toValues.split(",");
    removeToValuePackage(id, toValueArray);
    $('package-element').removeClass('dnone');
    if ($('package_remove_'+id)) {
      $('package_remove_'+id).destroy();
    }
  }
</script>

