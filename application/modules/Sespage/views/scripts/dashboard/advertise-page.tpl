<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: advertise-page.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.share', 1); ?>
<?php if(!$this->is_ajax) { ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sespage', array('page' => $this->page)); ?>
    <div class="sespage_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } ?>
    <div class="sespage_dashboard_content_header">
      <h3><?php echo $this->translate("Advertise Page"); ?></h3>
      <p><?php echo $this->translate("Make your Page more popular inside and outside this social network by advertising it using the below mentioned effective ways."); ?></p>
    </div>  
    <ul class="sespage_dashboard_advertise sesbasic_bxs">
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sespage/externals/images/dashboard/message.png" alt="" />
        </div>
        <div class="_cont">
          <div class="_buttons">
            <h3><?php echo $this->translate("Private Message"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to like and follow your Page by sending them message in private."); ?></p>
						<div class="_buttons">
            	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' => 'index', 'action' => 'message','item_id' => $this->page->getIdentity(), 'type' => $this->page->getType()),'default',true); ?>')"> <?php echo $this->translate("Private Message"); ?></a>
            </div>  
         </div>   
        </div>  
      </li>
      
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sespage/externals/images/dashboard/share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Page on this site with a beautiful ad to make it more popular among site members."); ?></p>
          <div class="_buttons">  
            <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => $this->page->getType(),'id' => $this->page->getIdentity(),'format' => 'smoothbox'),'default',true); ?>');return false;"> <?php echo $this->translate("Share on Site"); ?></a>
        	</div>    
        </div>
      </li>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sespage/externals/images/dashboard/quick-share.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Quick Share on Site"); ?></h3>
          <p><?php echo $this->translate("Share your Page on this site by making a quick post."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="sesAjaxQuickShare('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'share','type' => $this->page->getType(),'id' => $this->page->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Quick Share on Site"); ?></a>
          </div>  
        </div>  
      </li>
      <?php if($allow_share == 2) { ?>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Sespage/externals/images/dashboard/send-friend.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Tell a friend"); ?></h3>
            <p><?php echo $this->translate("Invite your friends to join your Page by sharing the importance of the Page with a small note."); ?></p>
            <div class="_buttons">
              <a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sesbasic', 'controller' =>'index','action' => 'tellafriend','type' => $this->page->getType(),'id' => $this->page->getIdentity()),'default',true); ?>');return false;"> <?php echo $this->translate("Tell a friend"); ?></a>
            </div>
          </div>
        </li>
        <li class="sesbasic_clearfix">
          <div class="_icon">
            <img src="application/modules/Sespage/externals/images/dashboard/social-share.png" alt="" />
          </div>
          <div class="_cont">
            <h3><?php echo $this->translate("Social Share"); ?></h3>
            <p><?php echo $this->translate("Share the post of your Page to other sites to gather more audience and members."); ?></p>
            <div class="_buttons">
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->page, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 30)); ?>
              <div class="addthis_sharing_toolbox"></div>
            </div>  
          </div>
        </li>
      <?php } ?>
      <li class="sesbasic_clearfix">
      	<div class="_icon">
        	<img src="application/modules/Sespage/externals/images/dashboard/send-update.png" alt="" />
        </div>
        <div class="_cont">
          <h3><?php echo $this->translate("Send Updates"); ?></h3>
          <p><?php echo $this->translate("Send updates to the members of your Page who have liked / followed or joined your Page."); ?></p>
          <div class="_buttons">
          	<a href="javascript:void(0)" class="sesbasic_button" onClick="openSmoothBoxInUrl('<?php echo $this->url(array('module'=> 'sespage', 'controller' => 'dashboard', 'action' => 'send-updates', 'page_id' => $this->page->custom_url, 'resource_id' => $this->page->getIdentity(), 'resource_type' => $this->page->getType()),'sespage_dashboard',true); ?>')"> <?php echo $this->translate("Send Updates"); ?></a>
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