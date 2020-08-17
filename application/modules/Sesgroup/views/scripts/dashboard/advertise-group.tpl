<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: advertise-group.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.share', 1); ?>
<?php if(!$this->is_ajax) { ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array('group' => $this->group)); ?>
    <div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } ?>
    <div class="sesgroup_dashboard_content_header">
      <h3><?php echo $this->translate("Advertise Group"); ?></h3>
      <p><?php echo $this->translate("Make your Group more popular inside and outside this social network by advertising it using the below mentioned effective ways."); ?></p>
    </div>  
    <ul class="sesgroup_dashboard_advertise sesbasic_bxs">
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sesgroup/externals/images/dashboard/message.png" alt="" />
        </div>
        <div class="_cont">
          <div class="_buttons">
            <h3><?php echo $this->translate("Private Message"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to like and follow your Group by sending them message in private."); ?></p>
						<div class="_buttons">
            	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' => 'index', 'action' => 'message','item_id' => $this->group->getIdentity(), 'type' => $this->group->getType()),'default',true); ?>')"> <?php echo $this->translate("Private Message"); ?></a>
            </div>  
         </div>   
        </div>  
      </li>
      
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sesgroup/externals/images/dashboard/share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Group on this site with a beautiful ad to make it more popular among site members."); ?></p>
          <div class="_buttons">  
            <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => $this->group->getType(),'id' => $this->group->getIdentity(),'format' => 'smoothbox'),'default',true); ?>');return false;"> <?php echo $this->translate("Share on Site"); ?></a>
        	</div>    
        </div>
      </li>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sesgroup/externals/images/dashboard/quick-share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Quick Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Group on this site by making a quick post."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="sesAjaxQuickShare('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => $this->group->getType(),'id' => $this->group->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Quick Share on Site"); ?></a>
          </div>  
        </div>  
      </li>
      <?php if($allow_share == 2) { ?>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Sesgroup/externals/images/dashboard/send-friend.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Tell a friend"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to join your Group by sharing the importance of the Group with a small note."); ?></p>
            <div class="_buttons">
              <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'tellafriend','type' => $this->group->getType(),'id' => $this->group->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Tell a friend"); ?></a>
            </div>
          </div>
        </li>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Sesgroup/externals/images/dashboard/social-share.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Social Share"); ?></h3>
            <p><?php echo $this->translate("Share the post of your Group to other sites to gather more audience and members."); ?></p>
            <div class="_buttons">
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->group, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 30)); ?>
              <div class="addthis_sharing_toolbox"></div>
            </div>  
          </div>
        </li>
      <?php } ?>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sesgroup/externals/images/dashboard/send-update.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Send Updates"); ?></h3>
          <p><?php echo $this->translate("Send updates to the members of your Group who have liked / followed or joined your Group."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesgroup', 'controller' => 'dashboard', 'action' => 'send-updates', 'group_id' => $this->group->custom_url, 'resource_id' => $this->group->getIdentity(), 'resource_type' => $this->group->getType()),'sesgroup_dashboard',true); ?>')"> <?php echo $this->translate("Send Updates"); ?></a>
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