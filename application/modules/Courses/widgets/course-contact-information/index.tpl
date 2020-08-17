<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class='courses_owner_contact_details sesbasic_clearfix sesbasic_bxs'>
  <ul>
    <?php if( in_array('name',$this->info) && $this->subject->course_contact_name): ?>
      <li class="sesbasic_clearfix courses_owner_contact_name">
        <?php echo nl2br($this->subject->course_contact_name) ?>
      </li>
    <?php endif ?>
    <?php if( in_array('email',$this->info) && $this->subject->course_contact_email): ?>
      <li class="sesbasic_clearfix" title='<?php echo $this->translate("Contact Email"); ?>'>
        <i class="fa fa-envelope-o"></i>  
        <span><a href='mailto:<?php echo $this->subject->course_contact_email ?>' target="_blank" class="sesbasic_linkinherit"><?php echo $this->subject->course_contact_email ?></a></span>
      </li>
    <?php endif ?>
    <?php if( in_array('phone',$this->info) && $this->subject->course_contact_phone): ?>
      <li class="sesbasic_clearfix" title='<?php echo $this->translate("Contact Phone Number"); ?>'>
        <i class="fa fa-phone"></i>
        <span><?php echo ($this->subject->course_contact_phone) ?></span>
      </li>
    <?php endif ?>
 
    <?php if( in_array('website',$this->info) && $this->subject->course_contact_website): ?>
      <li class="sesbasic_clearfix">
        <i class="fa fa-globe"></i>
        <span><a class="sesbasic_linkinherit" target="_blank" href='<?php echo parse_url($this->subject->course_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->course_contact_website : $this->subject->course_contact_website; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo parse_url($this->subject->course_contact_website, PHP_URL_SCHEME) === null ? '' . $this->subject->course_contact_website : $this->subject->course_contact_website; ?></a></span>
      </li>
    <?php endif ?>
      <?php if( in_array('facebook',$this->info) && $this->subject->course_contact_facebook): ?>
        <li class="sesbasic_clearfix">
         <i class="fa fa-facebook"></i>
        <span><a target="_blank" href='<?php echo parse_url($this->subject->course_contact_facebook, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->course_contact_facebook : $this->subject->course_contact_facebook; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo parse_url($this->subject->course_contact_facebook, PHP_URL_SCHEME) === null ? '' . $this->subject->course_contact_facebook : $this->subject->course_contact_facebook; ?></a></span>
        </li>
      <?php endif ?>
      <?php if( in_array('linkedin',$this->info) && $this->subject->course_contact_linkedin): ?>
        <li class="sesbasic_clearfix">
         <i class="fa fa-linkedin"></i>
        <span><a target="_blank" href='<?php echo parse_url($this->subject->course_contact_linkedin, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->course_contact_linkedin : $this->subject->course_contact_linkedin; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo parse_url($this->subject->course_contact_linkedin, PHP_URL_SCHEME) === null ? '' . $this->subject->course_contact_linkedin : $this->subject->course_contact_linkedin; ?></a></span>
        </li>
      <?php endif ?>
      <?php if( in_array('twitter',$this->info) && $this->subject->course_contact_twitter): ?>
        <li class="sesbasic_clearfix">
          <i class="fa fa-twitter"></i>
          <span><a class="sesbasic_linkinherit" target="_blank" href='<?php echo parse_url($this->subject->course_contact_twitter, PHP_URL_SCHEME) === null ? 'https://' . $this->subject->course_contact_twitter : $this->subject->course_contact_twitter; ?>'><?php echo parse_url($this->subject->course_contact_twitter, PHP_URL_SCHEME) === null ? '' . $this->subject->course_contact_twitter : $this->subject->course_contact_twitter; ?></a></span>
        </li>
      <?php endif ?>
      <?php if( in_array('instagram',$this->info) && $this->subject->course_contact_instagram): ?>
        <li class="sesbasic_clearfix">
         <i class="fa fa-instagram"></i>
          <span><a target="_blank" href='<?php echo parse_url($this->subject->course_contact_instagram, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->course_contact_instagram : $this->subject->course_contact_instagram; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo parse_url($this->subject->course_contact_instagram, PHP_URL_SCHEME) === null ? '' . $this->subject->course_contact_instagram : $this->subject->course_contact_instagram; ?></a></span>
        </li>
      <?php endif ?>
        <?php if( in_array('pinterest',$this->info) && $this->subject->course_contact_pinterest): ?>
          <li class="sesbasic_clearfix">
            <i class="fa fa-pinterest"></i>
            <span><a target="_blank" href='<?php echo parse_url($this->subject->course_contact_pinterest, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->course_contact_pinterest : $this->subject->course_contact_pinterest; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo parse_url($this->subject->course_contact_pinterest, PHP_URL_SCHEME) === null ? '' . $this->subject->course_contact_pinterest : $this->subject->course_contact_pinterest; ?></a></span>
          </li>
      <?php endif ?>
  </ul>
</div>
<script type="application/javascript">
var tabId_contactinfo = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_contactinfo);	
});
</script>
