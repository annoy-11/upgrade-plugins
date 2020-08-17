<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _timezone.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $timezone = isset($_POST['timezone']) ? $_POST['timezone'] : (isset($this->contest) && !empty($this->contest->timezone) ? $this->contest->timezone : $this->viewer->timezone) ; ?>
<div id="timezone_setn" class="form-wrapper">
	<div id="timezone_setn-label" class="form-label">&nbsp;</div>
  <div id="timezone_setn-element" class="form-element">
    <a href="javascript:;" id="timezone_setting_contest" class="form-link">
      <i class="fa fa-clock-o"></i><?php echo $this->translate("Timezone Setting"); ?> (<span id="selected_timezone_val"><?php echo $timezone; ?></span>)</a>
  </div>
</div>
<div class="sescontest_timezone_popup_overlay" style="display:none;"></div>
<div class="sescontest_timezone_popup" style="display:none;">
	<div class="sescontest_timezone_popup_content">
  	<div class="sescontest_timezone_popup_content_inner">
      <div class="sescontest_timezone_popup_heading">
        <h2><?php echo $this->translate("Select Your Time Zone"); ?></h2>
      </div>
      <div class="sescontest_timezone_popup_elements">  
        <select id="contest_timezone_jq" name="timezone">
        <?php if(count($this->timezone) && count($this->timezone)){ ?>
    			<?php foreach($this->timezone as $key=>$valTimezone){ ?>
          <option value="<?php echo $key ?>" <?php if($key == $timezone){ ?> selected="selected" <?php } ?>><?php echo $valTimezone ?></option>
          <?php } ?>
        <?php } ?>
				</select>
   			<h4 class="sescontest_timezone_popup_subheading" style="display:none;"><?php echo $this->translate("Contests Page Settings"); ?></h4>
        <br />
				<div class="sescontest_timezone_popup_buttons">
          <button id="saveDateTimezoneSetting" onclick="return false;"><?php echo $this->translate("Save"); ?></button>
          <button id="cancelTimeZone" onclick="" class="secondary_button"><?php echo $this->translate("Cancel"); ?></button>
      	</div>
      </div>
		</div>
	</div>
</div>
<script type="application/javascript">
 en4.core.runonce.add(function() {
  sesJqueryObject('#saveDateTimezoneSetting').click(function(e){
  var valueArray = '';
  var timeValues = sesJqueryObject('.sescontest_choose_date').find('input');
  for(i=0;i<timeValues.length;i++){
    valueArray =  sesJqueryObject(timeValues[i]).attr('id')+'='+sesJqueryObject(timeValues[i]).val()+"&"+valueArray; 
  }
	var request = new Request.JSON({
      method: 'post',
      'url': en4.core.baseUrl + "sescontest/index/set-date-data",
      'data': {
        format: 'json',
        values: (valueArray),
        timezone : sesJqueryObject('#contest_timezone_jq').val(),
      },
      onSuccess: function(responseJSON) {
        for(i=0;i<responseJSON.length;i++){
          sesJqueryObject('#'+responseJSON[i]['key']).val(responseJSON[i]['value']);
        }
        sesJqueryObject('.sescontest_timezone_popup_overlay').hide();
        sesJqueryObject('.sescontest_timezone_popup').hide();
        sesJqueryObject('#selected_timezone_val').html(sesJqueryObject('#contest_timezone_jq').val());
        checkAllDateFields();
         //
      }
    });
    request.send();
    return false;
  });

sesJqueryObject('#timezone_setting_contest').click(function(e){
		sesJqueryObject('.sescontest_timezone_popup_overlay').show();
		sesJqueryObject('.sescontest_timezone_popup').show();
		return false;
});

sesJqueryObject('#cancelTimeZone').click(function(e){
		sesJqueryObject('.sescontest_timezone_popup_overlay').hide();
		sesJqueryObject('.sescontest_timezone_popup').hide();
		return false;
});
});
</script>