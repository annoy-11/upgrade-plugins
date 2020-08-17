<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create-lecture.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
  if (APPLICATION_ENV == 'course')
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
  else
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php if(!$this->is_ajax){ ?>
  <?php
  echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
  'course' => $this->course,
  ));	
  ?>
  <div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<div class="courses_dashboard_form courses_create_form sesbasic_bxs">
  <?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax){ ?>
    </div>
      </div>
  </div>
<?php } ?>
<script>
  function updateTextFields(value) { 
      if(value == 'html'){
        sesJqueryObject('#htmltext-wrapper').show();
        sesJqueryObject('#file-wrapper').hide();
        sesJqueryObject('#embedUrl-wrapper').hide();
      }
  }
</script>
