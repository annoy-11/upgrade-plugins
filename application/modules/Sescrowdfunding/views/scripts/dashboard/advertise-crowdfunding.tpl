<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: advertise-crowdfunding.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
<?php if(!$this->is_ajax) { ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding)); ?>
    <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } ?>
    <div class="sescrowdfunding_dashboard_content_header">
      <h3><?php echo $this->translate("Advertise Crowdfunding"); ?></h3>
      <p><?php echo $this->translate("Make your Crowdfunding more popular inside and outside this social network by advertising it using the below mentioned effective ways."); ?></p>
    </div>  
    <ul class="sescrowdfunding_dashboard_advertise sesbasic_bxs">
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sescrowdfunding/externals/images/dashboard/message.png" alt="" />
        </div>
        <div class="_cont">
          <div class="_buttons">
            <h3><?php echo $this->translate("Send as Message"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to like and follow your Crowdfunding by sending them message in private."); ?></p>
						<div class="_buttons">
            	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' => 'index', 'action' => 'message','item_id' => $this->crowdfunding->getIdentity(), 'type' => 'crowdfunding'),'default',true); ?>')"> <?php echo $this->translate("Send as Message"); ?></a>
            </div>  
         </div>   
        </div>  
      </li>
      
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sescrowdfunding/externals/images/dashboard/share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Crowdfunding on this site with a beautiful ad to make it more popular among site members."); ?></p>
          <div class="_buttons">  
            <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => 'crowdfunding','id' => $this->crowdfunding->getIdentity(),'format' => 'smoothbox'),'default',true); ?>');return false;"> <?php echo $this->translate("Share on Site"); ?></a>
        	</div>    
        </div>
      </li>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sescrowdfunding/externals/images/dashboard/quick-share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Quick Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Crowdfunding on this site by making a quick post."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="sesAjaxQuickShare('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => 'crowdfunding','id' => $this->crowdfunding->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Quick Share on Site"); ?></a>
          </div>  
        </div>  
      </li>
      <?php if($allow_share == 2) { ?>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Sescrowdfunding/externals/images/dashboard/send-friend.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Tell a friend"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to join your Crowdfunding by sharing the importance of the Crowdfunding with a small note."); ?></p>
            <div class="_buttons">
              <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'tellafriend','type' => 'crowdfunding','id' => $this->crowdfunding->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Tell a friend"); ?></a>
            </div>
          </div>
        </li>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Sescrowdfunding/externals/images/dashboard/social-share.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Social Share"); ?></h3>
            <p><?php echo $this->translate("Share the post of your Crowdfunding to other sites to gather more audience and members."); ?></p>
            <div class="_buttons">
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->crowdfunding, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 30)); ?>
              <div class="addthis_sharing_toolbox"></div>
            </div>  
          </div>
        </li>
      <?php } ?>
    </ul>
<?php if(!$this->is_ajax) { ?>
  </div>
</div>
</div>
<?php } ?>
<?php if($this->is_ajax) die; ?>
