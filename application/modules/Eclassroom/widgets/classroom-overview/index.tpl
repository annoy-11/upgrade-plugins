<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if($this->editOverview){ ?>
	<?php 
   if($this->subject->overview){
   	$overviewicon = "sesbasic_icon_edit";
   	$overviewtext = $this->translate("Change Overview");
   }else{
    $overviewicon = "sesbasic_icon_add";
   	$overviewtext = $this->translate("Add Overview");
   } ?>
  <div class="sesbasic_profile_tabs_top sesbasic_clearfix">
    <a href="<?php echo $this->url(array('classroom_id' => $this->subject->custom_url, 'action'=>'overview'), 'eclassroom_dashboard', true); ?>" class="sesbasic_button <?php echo $overviewicon; ?>">
      <?php echo $overviewtext; ?>
    </a>
  </div>
<?php } ?>
<div class="sesbasic_html_block">
  <?php if($this->subject->overview):?>
    <?php echo $this->subject->overview;?>
  <?php else: ?>
    <div class="tip">
      <span><?php echo $this->translate("There is currently no overview.");?></span>
    </div>     
  <?php endif; ?>
</div>
