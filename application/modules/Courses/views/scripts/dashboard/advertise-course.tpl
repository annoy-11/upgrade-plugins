<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecourses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: advertise-courses.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.share', 1); ?>
<?php if(!$this->is_ajax) { ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'courses', array('course' => $this->course)); ?>
    <div class="courses_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } ?>
    <div class="courses_dashboard_content_header">
      <h3><?php echo $this->translate("Advertise Course"); ?></h3>
      <p><?php echo $this->translate("Make your Course more popular inside and outside this social network by advertising it using the below mentioned effective ways."); ?></p>
    </div>  
    <ul class="courses_dashboard_advertise sesbasic_bxs">
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Courses/externals/images/dashboard/message.png" alt="" />
        </div>
        <div class="_cont">
          <div class="_buttons">
            <h3><?php echo $this->translate("Private Message"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to like and follow your Course by sending them message in private."); ?></p>
						<div class="_buttons">
            	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' => 'index', 'action' => 'message','item_id' => $this->course->getIdentity(), 'type' => $this->course->getType()),'default',true); ?>')"> <?php echo $this->translate("Private Message"); ?></a>
            </div>  
         </div>   
        </div>  
      </li>
      
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Courses/externals/images/dashboard/share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Course on this site with a beautiful ads to make it more popular among site members."); ?></p>
          <div class="_buttons">  
            <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => $this->course->getType(),'id' => $this->course->getIdentity(),'format' => 'smoothbox'),'default',true); ?>');return false;"> <?php echo $this->translate("Share on Site"); ?></a>
        	</div>    
        </div>
      </li>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Courses/externals/images/dashboard/quick-share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Quick Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Course on this site by making a quick post."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="sesAjaxQuickShare('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => $this->course->getType(),'id' => $this->course->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Quick Share on Site"); ?></a>
          </div>  
        </div>  
      </li>
      <?php if($allow_share == 2) { ?>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Courses/externals/images/dashboard/send-friend.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Tell a friend"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to join your Course by sharing the importance of the Course with a small note."); ?></p>
            <div class="_buttons">
              <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'tellafriend','type' => $this->course->getType(),'id' => $this->course->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Tell a friend"); ?></a>
            </div>
          </div>
        </li>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Courses/externals/images/dashboard/social-share.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Social Share"); ?></h3>
            <p><?php echo $this->translate("Share the post of your Course to other sites to gather more audience and members."); ?></p>
            <div class="_buttons">
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->course, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 30)); ?>
              <div class="addthis_sharing_toolbox"></div>
            </div>  
          </div>
        </li>
      <?php } ?>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Courses/externals/images/dashboard/send-update.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Send Updates"); ?></h3>
          <p><?php echo $this->translate("Send updates to the members of your Course who have liked / followed or joined your Course."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'ecourses', 'controller' => 'dashboard', 'action' => 'send-updates', 'course_id' => $this->course->custom_url, 'resource_id' => $this->course->getIdentity(), 'resource_type' => $this->course->getType()),'courses_dashboard',true); ?>')"> <?php echo $this->translate("Send Updates"); ?></a>
          </div>  
      	</div>    
      </li>
    </ul>
<?php if(!$this->is_ajax) { ?>
  </div>
</div>
</div>
<?php } ?>
<?php if($this->is_ajax) die; ?>
