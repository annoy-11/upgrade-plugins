<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: open-hours.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/jquery.timepicker.min.css'); ?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/scripts/jquery-timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/scripts/jquery.timepicker.min.js'); ?>

<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } 	
?><?php $hoursData = $this->hoursData; ?>
  <div class="estore_db_manage_hours estore_dashboard_form">
  	<form class="global_form" method="post">
    	<div>
      	<div>
        	<h3>Edit your details</h3>
          <div class="form-elements">
            <div class="form-wrapper">
              <div class="form-label"><label>Hours</label></div>
              <div class="form-element">
                <ul class="form-options-wrapper">
                  <li><input type="radio" name="hours" <?php echo !empty($hoursData['type']) && $hoursData['type'] == "selected" ? "checked='checked'" : (empty($hoursData['type']) ? "checked='checked'" : "" ); ?>  value="selected"><label>Open on selected hours</label></li>
                  <li><input type="radio" name="hours" <?php echo !empty($hoursData['type']) && $hoursData['type'] == "always" ? "checked='checked'" :  "" ?> value="always"><label>Always open</label></li>
                  <li><input type="radio" name="hours" <?php echo !empty($hoursData['type']) && $hoursData['type'] == "notavailable" ? "checked='checked'" :  "" ?>  value="notavailable"><label>No hours available</label></li>
                  <li><input type="radio" name="hours" <?php echo !empty($hoursData['type']) && $hoursData['type'] == "closed" ? "checked='checked'" :  "" ?>  value="closed"><label>Permanently closed</label></li>
                </ul>
              </div>
            </div>
            <div class="form-wrapper estore_choose_day_wrapper">
              <div class="form-label"><label>&nbsp;</label></div>
              <div class="form-element">
                <?php
                $timezoneArray = array(
                    'US/Pacific' => '(UTC-8) Pacific Time (US & Canada)',
                    'US/Mountain' => '(UTC-7) Mountain Time (US & Canada)',
                    'US/Central' => '(UTC-6) Central Time (US & Canada)',
                    'US/Eastern' => '(UTC-5) Eastern Time (US & Canada)',
                    'America/Halifax' => '(UTC-4)  Atlantic Time (Canada)',
                    'America/Anchorage' => '(UTC-9)  Alaska (US & Canada)',
                    'Pacific/Honolulu' => '(UTC-10) Hawaii (US)',
                    'Pacific/Samoa' => '(UTC-11) Midway Island, Samoa',
                    'Etc/GMT-12' => '(UTC-12) Eniwetok, Kwajalein',
                    'Canada/Newfoundland' => '(UTC-3:30) Canada/Newfoundland',
                    'America/Buenos_Aires' => '(UTC-3) Brasilia, Buenos Aires, Georgetown',
                    'Atlantic/South_Georgia' => '(UTC-2) Mid-Atlantic',
                    'Atlantic/Azores' => '(UTC-1) Azores, Cape Verde Is.',
                    'Europe/London' => 'Greenwich Mean Time (Lisbon, London)',
                    'Europe/Berlin' => '(UTC+1) Amsterdam, Berlin, Paris, Rome, Madrid',
                    'Europe/Athens' => '(UTC+2) Athens, Helsinki, Istanbul, Cairo, E. Europe',
                    'Europe/Moscow' => '(UTC+3) Baghdad, Kuwait, Nairobi, Moscow',
                    'Iran' => '(UTC+3:30) Tehran',
                    'Asia/Dubai' => '(UTC+4) Abu Dhabi, Kazan, Muscat',
                    'Asia/Kabul' => '(UTC+4:30) Kabul',
                    'Asia/Yekaterinburg' => '(UTC+5) Islamabad, Karachi, Tashkent',
                    'Asia/Calcutta' => '(UTC+5:30) Bombay, Calcutta, New Delhi',
                    'Asia/Katmandu' => '(UTC+5:45) Nepal',
                    'Asia/Omsk' => '(UTC+6) Almaty, Dhaka',
                    'Indian/Cocos' => '(UTC+6:30) Cocos Islands, Yangon',
                    'Asia/Krasnoyarsk' => '(UTC+7) Bangkok, Jakarta, Hanoi',
                    'Asia/Hong_Kong' => '(UTC+8) Beijing, Hong Kong, Singapore, Taipei',
                    'Asia/Tokyo' => '(UTC+9) Tokyo, Osaka, Sapporto, Seoul, Yakutsk',
                    'Australia/Adelaide' => '(UTC+9:30) Adelaide, Darwin',
                    'Australia/Sydney' => '(UTC+10) Brisbane, Melbourne, Sydney, Guam',
                    'Asia/Magadan' => '(UTC+11) Magadan, Solomon Is., New Caledonia',
                    'Pacific/Auckland' => '(UTC+12) Fiji, Kamchatka, Marshall Is., Wellington',
                );
                ?>              
                <div> 
                  <label>Timezone:</label> 
                  <select name="timezone">
                    <?php foreach($timezoneArray as $key=>$zone){ ?> 
                      <option value="<?php echo $key ?>" <?php echo !empty($this->timezone) && $this->timezone == $key ? "selected='selected'" :  "" ?> ><?php echo $zone; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <br>
              	<div class="_day">
                	<input type="checkbox" class="checkbox" <?php echo !empty($hoursData[1]) ? "checked='checked'" : ""; ?> id="mon" value="1" name="checkbox1" />
                  <label for="mon">Monday</label>
                  <div class="_timeslot" data-rel="1">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="1[0][starttime]" value="<?php echo !empty($hoursData[1][0]['starttime']) ? $hoursData[1][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="1[0][endtime]" value="<?php echo !empty($hoursData[1][0]['endtime']) ? $hoursData[1][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                  <?php if(!empty($hoursData[1][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="1[1][starttime]" value="<?php echo !empty($hoursData[1][1]['starttime']) ? $hoursData[1][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="1[1][endtime]" value="<?php echo !empty($hoursData[1][1]['endtime']) ? $hoursData[1][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                  </div>
                </div>
                <div class="_day">
                	<input type="checkbox" class="checkbox" <?php echo !empty($hoursData[2]) ? "checked='checked'" : ""; ?> id="tue" value="1"  name="checkbox2" />
                  <label for="tue">Tuesday</label>
                  <div class="_timeslot" data-rel="2">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="2[0][starttime]" value="<?php echo !empty($hoursData[2][0]['starttime']) ? $hoursData[2][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="2[0][endtime]" value="<?php echo !empty($hoursData[2][0]['endtime']) ? $hoursData[2][0]['endtime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                    
                    <?php if(!empty($hoursData[2][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="2[1][starttime]" value="<?php echo !empty($hoursData[2][1]['starttime']) ? $hoursData[2][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="2[1][endtime]" value="<?php echo !empty($hoursData[2][1]['endtime']) ? $hoursData[2][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                    
                  </div>
                </div>
                <div class="_day">
                	<input type="checkbox" class="checkbox" id="wed" value="1" <?php echo !empty($hoursData[3]) ? "checked='checked'" : ""; ?> name="checkbox3" />
                  <label for="wed">Wednesday</label>
                  <div class="_timeslot" data-rel="3">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="3[0][starttime]" value="<?php echo !empty($hoursData[3][0]['starttime']) ? $hoursData[3][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="3[0][endtime]" value="<?php echo !empty($hoursData[3][0]['endtime']) ? $hoursData[3][0]['endtime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                    
                    <?php if(!empty($hoursData[3][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="3[1][starttime]" value="<?php echo !empty($hoursData[3][1]['starttime']) ? $hoursData[3][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="3[1][endtime]" value="<?php echo !empty($hoursData[3][1]['endtime']) ? $hoursData[3][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                  </div>
                </div>
                <div class="_day">
                	<input type="checkbox"  class="checkbox" <?php echo !empty($hoursData[4]) ? "checked='checked'" : ""; ?> id="thur" value="1" name="checkbox4" />
                  <label for="thur">Thursday</label>
                  <div class="_timeslot" data-rel="4">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="4[0][starttime]"value="<?php echo !empty($hoursData[4][0]['starttime']) ? $hoursData[4][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="4[0][endtime]" value="<?php echo !empty($hoursData[4][0]['endtime']) ? $hoursData[4][0]['endtime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                    <?php if(!empty($hoursData[4][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="4[1][starttime]" value="<?php echo !empty($hoursData[4][1]['starttime']) ? $hoursData[4][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="4[1][endtime]" value="<?php echo !empty($hoursData[4][1]['endtime']) ? $hoursData[4][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                    
                  </div>
                </div>
                <div class="_day">
                	<input type="checkbox" class="checkbox" id="fri" <?php echo !empty($hoursData[5]) ? "checked='checked'" : ""; ?> value="1" name="checkbox5" />
                  <label for="fri">Friday</label>
                  <div class="_timeslot" data-rel="5">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="5[0][starttime]" value="<?php echo !empty($hoursData[5][0]['starttime']) ? $hoursData[5][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="5[0][endtime]" class="timepicker" value="<?php echo !empty($hoursData[5][0]['endtime']) ? $hoursData[5][0]['endtime'] : ""; ?>" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                    <?php if(!empty($hoursData[5][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="5[1][starttime]" value="<?php echo !empty($hoursData[5][1]['starttime']) ? $hoursData[5][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="5[1][endtime]" value="<?php echo !empty($hoursData[5][1]['endtime']) ? $hoursData[5][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                    
                  </div>
                </div>
                <div class="_day">
                	<input type="checkbox"  class="checkbox" id="sat" <?php echo !empty($hoursData[6]) ? "checked='checked'" : ""; ?> value="1" name="checkbox6" />
                  <label for="sat">Saturday</label>
                  <div class="_timeslot" data-rel="6">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="6[0][starttime]" value="<?php echo !empty($hoursData[6][0]['starttime']) ? $hoursData[6][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="6[0][endtime]" value="<?php echo !empty($hoursData[6][0]['endtime']) ? $hoursData[6][0]['endtime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                    
                    <?php if(!empty($hoursData[6][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="6[1][starttime]" value="<?php echo !empty($hoursData[6][1]['starttime']) ? $hoursData[6][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="6[1][endtime]" value="<?php echo !empty($hoursData[6][1]['endtime']) ? $hoursData[6][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                  </div>
                </div>
                <div class="_day">
                	<input type="checkbox" class="checkbox" id="sun" <?php echo !empty($hoursData[7]) ? "checked='checked'" : ""; ?> value="1" name="checkbox7" />
                  <label for="sun">Sunday</label>
                  <div class="_timeslot" data-rel="7">
                  	<p class="sesbasic_clearfix">
                    	<input type="text" name="7[0][starttime]" value="<?php echo !empty($hoursData[7][0]['starttime']) ? $hoursData[7][0]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="7[0][endtime]" value="<?php echo !empty($hoursData[7][0]['endtime']) ? $hoursData[7][0]['endtime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" style="display:none;" class="sesbasic_button fa fa-plus addbtn"></a>
                    </p>
                    <?php if(!empty($hoursData[7][1]['starttime'])){ ?>
                    <p class="sesbasic_clearfix">
                    	<input type="text" name="7[1][starttime]" value="<?php echo !empty($hoursData[7][1]['starttime']) ? $hoursData[7][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <span>-</span>
                      <input type="text" name="7[1][endtime]" value="<?php echo !empty($hoursData[7][1]['endtime']) ? $hoursData[7][1]['starttime'] : ""; ?>" class="timepicker" placeholder="Time">
                      <a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a>
                    </p>
                  <?php } ?>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="form-wrapper">
              <div class="form-label"><label>&nbsp;</label></div>
          		<div class="form-element">
              	<button type="submit">Save Changes</button>
              </div>
            </div>  
          </div>  
    		</div>
      </div>
    </form>
  </div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
sesJqueryObject('input[type=radio][name=hours]').change(function() {
  var value = sesJqueryObject(this).val();
  if(value != "selected"){
     sesJqueryObject('.estore_choose_day_wrapper').hide();
  }else{
     sesJqueryObject('.estore_choose_day_wrapper').show();
  }
});
sesJqueryObject('.timepicker').focus(function(){
  var parent = sesJqueryObject(this).closest('._day');
  var check = parent.find('input[type=checkbox]');
  if(!check.prop('checked')) {
    check.trigger('click');
  }
    
});
sesJqueryObject(".checkbox").change(function() {
  if(this.checked) {
     var elem = sesJqueryObject(this).parent().find('._timeslot').find('p');
     var input = elem.find('input');
     input.eq(0).val('09:00 AM');
     input.eq(1).val('05:00 PM');
     elem.find('a').show();
  }else{
     var elem = sesJqueryObject(this).parent().find('._timeslot').find('p');
     elem.eq(1).remove(); 
     elem.eq(0).find('a').hide();
     elem.eq(0).find('input').val('');
  }
});
sesJqueryObject(document).on('click','.addbtn',function(e){
  e.preventDefault();
  sesJqueryObject(this).hide();
  var parent = sesJqueryObject(this).closest('._timeslot');
  var value = parent.data('rel');
  var html = '<p class="sesbasic_clearfix"><input type="text" name="'+value+'[1][starttime]" value="6:00 pm" class="timepicker" placeholder="Time"><span>-</span><input type="text" class="timepicker" placeholder="Time" name="'+value+'[1][endtime]" value="7:00 pm"><a href="javascript:void(0);" class="sesbasic_button fa fa-times removeBtn"></a></p>';
  parent.append(html);
  estoreTimePickerJqueryObject('input.timepicker').timepicker();
});
sesJqueryObject(document).on('click','.removeBtn',function(e){
  var parent = sesJqueryObject(this).closest('._timeslot');
  parent.find('p').eq(1).remove();
  parent.find('p').find('a').show();
});
(function($) {
    $(function() {
        var timeslots = sesJqueryObject('._timeslot');
        for(i=0;i<timeslots.length;i++){
           if(sesJqueryObject(timeslots[i]).find('p').length == 1){
             if(sesJqueryObject(timeslots[i]).find('p').find('input').eq(0).val() != "")
              sesJqueryObject(timeslots[i]).find('p').find('a').show();
           }
        }
        sesJqueryObject('input[type=radio][name=hours]:checked').trigger('change');
        estoreTimePickerJqueryObject('input.timepicker').timepicker();
    });
})(estoreTimePickerJqueryObject);
</script>
<?php if($this->is_ajax) die; ?>
