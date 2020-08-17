<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: general-settings.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<ul>
  <?php if($viewer->level_id == 1 || $viewer->level_id == 2):?>
    <li>
      <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><?php echo $this->translate('Administrator');?></a>
    </li>
  <?php endif;?>
  <li>
    <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><?php echo $this->translate('Logout');?></a>
  </li>
</ul>
