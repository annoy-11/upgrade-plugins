<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: oftheday.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<script type="text/javascript">
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
</script>
<div class="global_form_popup sesbasic_add_itemoftheday_popup">
  <?php echo $this->form->render($this) ?>
</div>

<script type="text/javascript">
  $('startdate-hour').hide();
  $('startdate-minute').hide();
  $('startdate-ampm').hide();
  $('enddate-hour').hide();
  $('enddate-minute').hide();
  $('enddate-ampm').hide();
</script>
